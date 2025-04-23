<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use GuzzleHttp\Psr7\Request;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\StorProfileRequest;
use App\Http\Requests\AuthRequest\ResendCode;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Requests\AuthRequest\GoogelloginRequest;
use App\Http\Requests\AuthRequest\SetLocationData;
use App\Http\Requests\AuthRequest\VerficationRequest;

/**
 * Class AuthController
 *
 * Handles authentication-related operations, including registration, login, verification, and token management.
 */
class AuthController extends Controller
{
    /**
     * The authentication service instance.
     *
     * @var AuthService
     */
    protected $authService;

    /**
     * Create a new AuthController instance.
     *
     * @param AuthService $authService The authentication service used to handle logic.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     *
     * This method validates the request and forwards the registration logic
     * to the AuthService. If successful, a response containing verification details is returned.
     *
     * @param RegisterRequest $request The request containing user registration data.
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        // Validate request data
        $credentials = $request->validated();

        // Register the user via AuthService
        $result = $this->authService->register($credentials);

        // Return JSON response
        return $result['status'] === 201
            ? self::success($result['data'], $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Verify the user's account using the verification code.
     *
     * This method validates the verification request and confirms the provided code.
     * If valid, the user account is created and authenticated.
     *
     * @param VerficationRequest $request The request containing email and verification code.
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(VerficationRequest $request)
    {
        $validationData = $request->validated();

        // Verify account via AuthService
        $result = $this->authService->verficationacount($validationData);

        return $result['status'] === 200
            ? self::success($result['data'], $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Set the user's location.
     *
     * Updates the user's latitude and longitude without modifying other user information.
     *
     * @param SetLocationData $request The request containing latitude and longitude.
     * @param User $user The authenticated user instance.
     * @return \Illuminate\Http\JsonResponse
     */
    public function setLocation(SetLocationData $request)
    {
        $validationData = $request->validated();

        // Update user location via AuthService
        $result = $this->authService->setLocation($validationData);

        return $result['status'] === 200
            ? self::success(null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Resend the verification code to the user's email.
     *
     * If the previous code expired, a new one is sent.
     *
     * @param ResendCode $request The request containing user email.
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendCode(ResendCode $request)
    {
        $validationData = $request->validated();

        // Resend verification code via AuthService
        $result = $this->authService->resendCode($validationData);

        return $result['status'] === 200
            ? self::success($result['data'], $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Log in an existing user.
     *
     * Validates credentials and returns a JWT token on successful authentication.
     *
     * @param LoginRequest $request The request containing user credentials.
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Authenticate user via AuthService
        $result = $this->authService->login($credentials);

        return $result['status'] === 201
            ? self::success($result['data'], $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Logout the authenticated user.
     *
     * Destroys the user's session and invalidates the JWT token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $result = $this->authService->logout();

        return $result['status'] === 200
            ? self::success(null, $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Refresh the JWT token.
     *
     * Generates a new token if the current one is expired.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $result = $this->authService->refresh();

        return $result['status'] === 200
            ? self::success($result['data'], $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }

    /**
     * Login using Google OAuth.
     *
     * Authenticates the user using Google login.
     *
     * @param GoogelloginRequest $request The request containing Google access token.
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginwithGoogel(GoogelloginRequest $request)
    {
        $validationData = $request->validated();

        // Authenticate user via Google OAuth using AuthService
        $result = $this->authService->loginwithgoogel($validationData['googleToken']);

        return $result['status'] === 200
            ? self::success($result['data'], $result['message'], $result['status'])
            : self::error(null, $result['message'], $result['status']);
    }
}
