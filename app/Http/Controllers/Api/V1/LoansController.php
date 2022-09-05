<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\LoanResource;
use App\Models\Auth\User;
use App\Models\Loan;
use App\Models\PaymentMeta;
use App\Repositories\Backend\LoanRepository;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Http\Resources\UserResource;

class LoansController extends APIController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(LoanRepository $repository)
    {
        $this->repository = $repository;
    }

   /**
     * Get all the loans.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->get('paginate') ? $request->get('paginate') : 25;
        $orderBy = $request->get('orderBy') ? $request->get('orderBy') : 'ASC';
        $sortBy = $request->get('sortBy') ? $request->get('sortBy') : 'created_at';

        $user = $this->jwtUser();
        $input = $request->all();
        
        if(!empty($user)){
            return LoanResource::collection($this->repository->getAllLoans($input,$user)->orderBy($sortBy, $orderBy)->paginate($limit))->additional([
                'status' => 1,
                'message' => '',
                'statusCode' => 200
            ]);
            
        }else{
            return $this->respond([
                'status' => 0,
                'message' => 'No user found!',
                'data' => []
            ]);
        }
    }

    /**
     * Return the specified resource.
     *
     * @param Loan $loan
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Loan $loan)
    {
        $user = $this->jwtUser();
        
        if(!empty($user)){
            // Showing only logged in Users Loan
            if($loan->user_id == $user->id){
                return new LoanResource($loan);
            }else{
                return $this->respond([
                    'status' => 0,
                    'message' => 'No Loan found!',
                    'data' => []
                ]);
            }
            
        }else{
            return $this->respond([
                'status' => 0,
                'message' => 'No user found!',
                'data' => []
            ]);
        }
    }

    /**
     * Apply New Loan
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyLoan(Request $request){
        
        $validation = Validator::make($request->all(), [
            'loan_amt'      => 'required',
            'loan_tenor'       => 'required',
        ]);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->applyLoan($request->all());

        return new LoanResource(Loan::orderBy('created_at', 'desc')->first());
    }

     /**
     * Approve a Loan
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveLoan(Request $request){
        
        $validation = Validator::make($request->all(), [
            'loan_id'      => 'required',
        ]);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }
        
        // Check the loan exist or not
        $loan = Loan::find($request->get('loan_id'));
        
        if(!empty($loan)){
           $response =  $this->repository->approveLoan($loan);
           if($response){
                return $this->respond([
                    'status' => 1,
                    'message' => 'Loan applicaton has been approved!',
                    'data' => []
                ]);
           }else{
                return $this->respond([
                    'status' => 0,
                    'message' => 'Error : Loan approval unsuccessful. Please contact to Administrator',
                    'data' => []
                ]);
           }
        }else{
            return $this->respond([
                'status' => 0,
                'message' => 'Unable to find a Loan.',
                'data' => []
            ]);
        }
    }
    /**
     * Pay a Loan Emi
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function payLoan(Request $request){

        // Validation
        $validation = Validator::make($request->all(), [
            'loan_id'      => 'required',
            'amount'       => 'required'
        ]);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }
        
        // Check the loan exist or not
        $loan = PaymentMeta::where('loan_id',$request->get('loan_id'))->first();
        
        if(!empty($loan)){
            if ( $loan->pending_amount <= 0 )
            {
                return $this->respond([
                    'status' => 1,
                    'message' => 'All EMIs were paid were you, no EMIs pending!',
                    'data' => []
                ]);
            }

            if ( $request->get('amount') < $loan->installment_amount )
            {
                return $this->respond([
                    'status' => 0,
                    'message' => 'You have to pay min ' . $loan->installment_amount . ' every EMI cycle.' ,
                    'data' => []
                ]);
            }

            if ( $request->amount > $loan->installment_amount )
            {
                return $this->respond([
                    'status' => 0,
                    'message' => 'You can only pay max ' . $loan->installment_amount . ' every EMI cycle.'  ,
                    'data' => []
                ]);
            }

           $response =  $this->repository->payLoanEmi($loan);

           if($response){
                return $this->respond([
                    'status' => 1,
                    'message' => 'Loan applicaton has been approved!',
                    'data' => []
                ]);
           }else{
                return $this->respond([
                    'status' => 0,
                    'message' => 'Error : Loan approval unsuccessful. Please contact to Administrator',
                    'data' => []
                ]);
           }
        }else{
            return $this->respond([
                'status' => 0,
                'message' => 'Unable to find a Loan.',
                'data' => []
            ]);
        }
    }
}
