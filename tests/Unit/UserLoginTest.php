<?php

namespace Tests\Feature\Frontend;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_login_route_exists()
    {
        $this->get('api/v1/auth/login')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_login_with_email_and_password()
    {
        $user = factory(User::class)->create([
            'email' => 'john@example.com',
            'first_name'=>'john',
            'last_name' => 'example',
            'status' => 1,
            'password' => 'secret',
        ]);

        Event::fake();

        $this->post('api/v1/auth/register', [
            'email' => 'john@example.com',
            'password' => 'secret',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->post('api/v1/auth/login', [
            'email' => '',
            'password' => '12345',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function password_is_required()
    {
        $response = $this->post('api/v1/auth/login', [
            'email' => 'john@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function cant_login_with_invalid_credentials()
    {
        $this->withoutExceptionHandling();

        $this->expectException(ValidationException::class);

        $this->post('api/v1/auth/login', [
            'email' => 'not-existend@user.com',
            'password' => '9s8gy8s9diguh4iev',
        ]);
    }

    /** @test */
    public function a_user_can_log_out()
    {
        $user = factory(User::class)->create();
        Event::fake();

        $this->actingAs($user)
            ->get('api/v1/auth/logout')
            ->assertRedirect('/');

        $this->assertFalse($this->isAuthenticated());
    }
}
