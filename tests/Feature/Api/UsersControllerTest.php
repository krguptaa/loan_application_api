<?php

namespace Tests\Feature\Api;

use App\Models\Auth\User;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UsersControllerTest extends BaseApiTestCase
{
    /**
     * Api Response Fields.
     *
     * @var array
     */
    private $apiResponseFields = [
        'id',
        'first_name',
        'last_name',
        'email',
        'confirmed',
        'status',
        'created_at',
        'updated_at'        
    ];

    /**
     * Test Show Users.
     */
    public function testShowUser()
    {
        factory(User::class)->create([
            'id' => 1,
        ]);

        $this->getJson('api/v1/users/1')
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->apiResponseFields,
            ]);
    }
    /**
     * Test Register User Validation.
     */
    public function testRegisterUserValidation()
    {
        $this->postJson('api/v1/auth/register')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'error' => [
                    'message' => [
                        'first_name',
                        'last_name',
                        'email',
                        'password',
                    ],
                ],
            ]);
    }

    /**
     * Test Register Users.
     */
    public function testRegisterUser()
    {
        $this->postJson('api/v1/users/register', $this->getPayload())
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->apiResponseFields,
            ]);

        $this->assertNotSame([]);
    }

    /**
     * Get Payload.
     *
     * @return array
     */
    public function getPayload(): array
    {
        return [
            'first_name' => $this->faker->words(5, true),
            'last_name' => $this->faker->words(5, true),
            'email' => $this->faker->email,
            'password' => $this->faker->password(8),
            'status' => 1,
            'confirmed' => 1,
        ];
    }
}
