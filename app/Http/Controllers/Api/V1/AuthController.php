<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Auth\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends APIController
{
     /**
     * Attempt to login the user.
     *
     * If login is successfull, you get an api_token in response. Use that api_token to authenticate yourself for further api calls.
     *
     * @bodyParam email string required Your email id. Example: "user@test.com"
     * @bodyParam password string required Your Password. Example: "abc@123_4"
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile responses/auth/login.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, JWTAuth $JWTAuth)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $password = $request->get('password');
        $email = $request->get('email');
   
        $user = User::where('email',$email)->whereNull('deleted_at')->first();
        
        if (empty($user)) {
            return $this->failedAttempted($request);
        }

        // For Disabled and Inactive User

        if (! is_null($user->status) && $user->status != 1) {
            return $this->throwValidation('This user is no more exist in system. Please contact to administrator!');
        }
       
        if (! Hash::check($password, $user['password'])) {
            return $this->failedAttempted($request);
        }
       
        try {
            if (! $user) {
                return $this->failedAttempted($request);
            }

            $token = JWTAuth::fromUser($user);

            if (! $token) {
                return $this->failedAttempted($request);
            }
        } catch (JWTException $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'status' => 1,
            'message'   => trans('api.messages.login.success'),
            'token'     => $token,
            'statusCode' => 200,
            'data'  => new UserResource($user)
        ]);
    }

   /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $user = $this->jwtUser();

            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'status'  => 1,
            'message' => trans('api.messages.logout.success'),
            'data' => [],
            'statusCode' => 200
        ]);
        
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            $this->respondUnauthorized(trans('api.messages.refresh.token.not_provided'));
        }

        try {
            $refreshedToken = JWTAuth::refresh($token);
        } catch (JWTException $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'token'  => $refreshedToken,
            'status' => 1,
            'message'   =>  trans('api.messages.refresh.status'),
            'data'  => [],
            'statusCode' => 200,
        ]);
    }

     /**
     * Limit the failed attempt.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function failedAttempted($request){
        return $this->throwValidation('Invalid Login Credentials.');
    }

   
}
