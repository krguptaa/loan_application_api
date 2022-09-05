<?php

namespace App\Repositories\Backend;

use App\Exceptions\GeneralException;
use App\Models\Auth\User;
use App\Models\Loan;
use App\Models\PaymentMeta;
use App\Models\Payment;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class LoanRepository.
 */
class LoanRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Loan::class;
    
    /**
     * @param array $input
     * @param array $user
     *
     * @throws \Exception
     * @throws \Throwable
     * @return Loan
     */
    public function getAllLoans($input,$user){
        $query = $this->query()
            ->select([
                'loans.id',
                'loans.user_id',
                'loans.loan_amt',
                'loans.loan_tenor',
                'loans.status',
                'loans.created_at',
                'loans.updated_at',
                'loans.deleted_at',
            ]);
          
        $query = $query->where('user_id',$user->id);

        return $query;

    }
     /**
     * @param array $data
     *
     * @throws \Exception
     * @throws \Throwable
     * @return Loan
     */
    public function applyLoan(array $data)
    {
        $loan = $this->createLoanStub($data);

        return DB::transaction(function () use ($loan, $data) {
            if ($loan->save()) {
                return $loan;
            }

            throw new GeneralException(__('exceptions.backend.access.users.create_error'));
        });
    }

     /**
     * @param  $input
     *
     * @return mixed
     */
    protected function createLoanStub($input)
    {
        $loan = self::MODEL;
        $loan = new $loan();
        $loan->user_id = access()->user()->id;
        $loan->loan_amt = $input['loan_amt'];
        $loan->loan_tenor = $input['loan_tenor'];
        $loan->status = 0;
        $loan->created_by = access()->user()->id;
        $loan->created_at = date('Y-m-d H:i:s');
        return $loan;
    }

   /**
     * @param Collection $loan
     *
     * @throws \Exception
     * @throws \Throwable
     * @return Loan
     */
    public function approveLoan($loan){

        $paymentsMeta = new PaymentMeta();

        $paymentsMeta->status = 1;
        $paymentsMeta->loan_id = $loan->id;
        $paymentsMeta->repayment_type_id = 1;
        $paymentsMeta->last_repayment_date = NULL;
        $paymentsMeta->next_repayment_date = date( 'Y-m-d H:i:s', strtotime( '+7 day' ) );
        $paymentsMeta->installment_amount = ceil( $loan->loan_amt /  $loan->loan_tenor );

        $paymentsMeta->pending_amount = $loan->loan_amt;

        if($paymentsMeta->save()){
            $loanUpdate = Loan::where( [ 'id' => $loan->id ] )->update( [ 'status' => 1 ] );

            if ( $loanUpdate )
            {
                return true;
            }
           
        }
        return false;
    }

    /**
     * @param Array $input
     * @param Object $loan
     *
     * @throws \Exception
     * @throws \Throwable
     * @return Boolean
     */
    public function payLoanEmi($input,$loan){

        $payment = new Payment();

        $payment->payment_status = 1;
        $payment->payment_meta_id = $loan->id;
        $payment->amount_received = $input['amount'];
        $payment->created_by = access()->user()->id;

        if ($payment->save())
        {
            $pendingAmount = ( $loan->pending_amount - $loan->installment_amount );
            $prevPaymentDate = date( 'Y-m-d H:i:s', strtotime( '+7 day' ) );
            $nextPaymentDate = date( 'Y-m-d H:i:s', strtotime( '+7 day', strtotime( $prevPaymentDate ) ) );

            $metaUpdate = PaymentMeta::where( [ 'id' => $loan->id ] )->update( [ 'status' => 1, 'last_repayment_date' => $prevPaymentDate, 'next_repayment_date' => $nextPaymentDate, 'pending_amount' => $pendingAmount ] );

            if ($metaUpdate)
            {
                return true;
            }
        }

        return false;
    }
}
