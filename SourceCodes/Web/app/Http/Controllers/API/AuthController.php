<?php

namespace App\Http\Controllers\API;

use App\Services\AuthService;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ForgotPasswordService;
use App\Http\Requests\API\LoginFormRequest;
use App\Http\Requests\API\LogoutFormRequest;
use App\Http\Traits\SuccessAndFailedResponseTrait;
use App\Http\Requests\API\RegistrationFormRequest;
use App\Http\Requests\API\ResetPasswordFormRequest;
use App\Http\Requests\API\ForgotPasswordFormRequest;

class AuthController extends Controller
{
    use SuccessAndFailedResponseTrait;
    protected $authService;
    protected $forgotPasswordService;
    public function __construct(AuthService $authService, ForgotPasswordService $forgotPasswordService)
    {
        $this->authService = $authService;
        $this->forgotPasswordService = $forgotPasswordService;
    }

    /**
     * Register function for create new user
     * @param['first_name'] string
     * @param['last_name'] string
     * @param['phone_no'] string
     * @param['email'] string
     * @param['company_name'] string
     * @param['password'] string
     * @param['password_confirmation'] string
     */

    /**
     * @OA\Post(
     * path="/api/register",
     *   tags={"Auth APIs"},
     *   summary="Register API",
     *   operationId="register",
     *
     *  @OA\Parameter(
     *      name="user_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="first_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="last_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="phone_no",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *       name="company_name",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="password_confirmation",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *   @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *   )
     *)
     **/

    public function register(RegistrationFormRequest $request)
    {
        try {
            $user = $this->authService->register($request);
            return $this->successResponse(200, true, trans('messages.admin_user.success.user_registered'), $user);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, trans('messages.admin_user.error.save'));
        }
    }

    /**
     * Authenticate function for user login
     * @param['email'] string
     * @param['password'] string
     */

   /**
     * @OA\Post(
     * path="/api/login",
     *   tags={"Auth APIs"},
     *   summary="Login API",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *   @OA\Response(
     *       response=403,
     *       description="Forbidden"
     *   )
     *)
     **/

    public function authenticate(LoginFormRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->failedResponse(400, false, trans('messages.invalid_login_credentials'));
            }

            $user = Auth::user();
            if ($user->status == 0) {
                return $this->failedResponse(400, false, trans('messages.admin_user.error.not_active'));
            }

            if (!$user->is_email_verified) {
                return $this->failedResponse(400, false, trans('messages.email_not_varify_error'));
            }
            return response()->json([
                'statusCode'    => 200,
                'success'       => true,
                'message'       => trans('messages.loggedin'),
                'data'          => $user,
                'token'         => $token
            ], 200);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Logout function for logout the user from application
     * @param['token'] string
     */

    /**
     *  @OA\Get(
     *      path="/api/logout",
     *      operationId="logout",
     *      tags={"Auth APIs"},
     *      security={
     *          {"bearerAuth": {}},
     *      },
     *      summary="Logout API",
     *      description="Returns user to login page",
     *      @OA\Parameter(
     *          name="token",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      )
     *  )
     **/

    public function logout(LogoutFormRequest $request)
    {
        try {
            JWTAuth::invalidate($request->token);
            return $this->successResponse(200, true, trans('messages.logged_out'), null);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, trans('messages.logout_error'));
        }
    }

    /**
     * Forgot password function for change the password if user forgot her/his password.
     * @param['email'] string
     */

    /**
     *  @OA\Post(
     *      path="/api/forgot/password",
     *      tags={"Auth APIs"},
     *      summary="Forgot Password API",
     *      operationId="forgot_password",
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/

    public function forgotPassword(ForgotPasswordFormRequest $request)
    {
        try {
            $this->forgotPasswordService->forgotPasswordOtp($request);
            return $this->successResponse(200, true, trans('messages.otp_sent'), null);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Reset password function for reset the password
     * @param['token'] string
     * @param['email'] string
     * @param['password'] string
     * @param['password_confirmation'] string
     */

    /**
     *  @OA\Post(
     *      path="/api/reset/password",
     *      tags={"Auth APIs"},
     *      summary="Reset Password API",
     *      operationId="reset_password",
     *
     *      @OA\Parameter(
     *          name="otp",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password_confirmation",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/

    public function resetPassword(ResetPasswordFormRequest $request)
    {
        try {
            $response = $this->forgotPasswordService->resetPasswordOtp($request);
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], null);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Resend Otp function .
     * @param['email'] string
     */

    /**
     *  @OA\Post(
     *      path="/api/resend/otp",
     *      tags={"Auth APIs"},
     *      summary="Resend Otp API",
     *      operationId="resend_otp",
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     **/

    public function resendOtp(ForgotPasswordFormRequest $request)
    {
        try {
            $this->forgotPasswordService->forgotPasswordOtp($request);
            return $this->successResponse(200, true, trans('messages.otp_sent'), null);
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }

    /**
     * Verify user Mail function
     * @param['token'] string
     */
    public function verifyAccount($token)
    {
        try {
            $response = $this->forgotPasswordService->verifyMail($token);
            if ($response['status'] === 'success') {
                return $this->successResponse(200, true, $response['message'], null);
            } else {
                return $this->failedResponse(400, false, $response['message']);
            }
        } catch (\Exception $exception) {
            return $this->failedResponse(500, false, $exception->getMessage());
        }
    }
}

