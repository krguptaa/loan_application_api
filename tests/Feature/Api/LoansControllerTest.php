<?php

namespace Tests\Feature\Api;

use App\Models\Auth\User;
use App\Models\Loan;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LoansControllerTest extends BaseApiTestCase
{
    /**
     * Api Response Fields.
     *
     * @var array
     */
    private $apiResponseFields = [
        'id',
        'loan_amt',
        'loan_tenor',
        'status',
        'created_by',
        'user_id',
        'created_at',
        'updated_at'        
    ];

    /**
     * Test List Loans.
     */
    public function testListLoan()
    {
        factory(Loan::class, 10)->create();

        $this->getJson('api/v1/loans')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    $this->apiResponseFields,
                ],
            ]);
    }

    /**
     * Test List Loan Fetch All.
     */
    public function testListLoanFetchAll()
    {
        factory(Loan::class, 100)->create();

        $this->getJson('api/v1/loans?per_page=-1')
            ->assertOk()
            ->assertJsonCount(100, 'data.*')
            ->assertJsonStructure([
                'data' => [
                    $this->apiResponseFields,
                ],
            ]);
    }

    /**
     * Test Show Loan.
     */
    public function testShowLoan()
    {
        factory(Loan::class)->create([
            'id' => 1,
        ]);

        $this->getJson('api/v1/loans/1')
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->apiResponseFields,
            ]);
    }

  
    /**
     * Test Apply Loan Validation.
     */
    public function testApplyLoanValidation()
    {
        $this->postJson('api/v1/loans/apply')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'error' => [
                    'message' => [
                        'loan_amt',
                        'loan_tenor'
                    ],
                ],
            ]);
    }

    /**
     * Test Apply Loan.
     */
    public function testApplyLoan()
    {
        $this->postJson('api/v1/loans/apply', $this->getLoanApplyPayload())
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->apiResponseFields,
            ]);

    }

    /**
     * Test Loan ApplyPayload
     */

     public function getLoanApplyPayload(): array
     {
         return [
             'loan_amt' => $this->faker->loan_amt,
             'loan_tenor' => $this->faker->loan_tenor,
         ];
     }


    /**
     * Test Approve Loan.
     */
    public function testApproveLoan()
    {
        $this->postJson('api/v1/loans/approve', ['loan_id' => $this->faker->loan_id])
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->apiResponseFields,
            ]);

    }

     /**
     * Test Pay Loan.
     */
    public function testPayLoan()
    {
        $this->postJson('api/v1/loans/payloan', ['loan_id' => $this->faker->loan_id,'loan_amt' => $this->faker->loan_amt])
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->apiResponseFields,
            ]);

    }

}
