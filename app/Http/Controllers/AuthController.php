<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Helper\ApiResponse;
use App\Helper\SingleImageUpload;
use App\Interfaces\AuthInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authInterface;
    use ApiResponse;
    use SingleImageUpload;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthInterface $authInterface)
    {
        $this->middleware('auth:api', ['except' => ['login', 'SignUp']]);
        $this->authInterface = $authInterface;
    }

    public function SignUp(Request $request) {

        $email = $request->input('email');
        $name = $request->input('name');
        $phoneNumber = $request->input('phone_number');

        if (!$request->hasFile('avatar')) {
            return $this->errorResponse('Sorry! you must upload an avatar', 400);
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone_number' => 'required'
        ]);
        
        list($image, $avatarName) = $this->imageUpload($request, 'avatar');

        $userAlreadyExist = $this->authInterface->FindUserByEmail($email);
        if ($userAlreadyExist) {
            return $this->errorResponse('User already exist', 400);
        }
        
        $image->move('avatar/', $avatarName);

        $avatarPath = '/public/avatar/' . $avatarName;

        $isAdmin = true;
        $uri = $request->path();
        if ($uri == 'api/v1/auth/signup-customer') {
            $isAdmin = false;
        }

        $hashedPw = Hash::make($request->input('password'));

        $user = new User;
        
        $user->name = $name;
        $user->email = $email;
        $user->password = $hashedPw;
        $user->phone_number = $phoneNumber;
        $user->avatar = $avatarPath;
        $user->is_admin = $isAdmin;
        
        list($createdUser, $error) = $this->authInterface->SignUp($user);
        if ($error != null) {
            return $this->errorResponse($error, 500);
        }

        return $this->successResponse($createdUser, 'Sign up successfully', 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $expiryTime = auth()->factory()->getTTL() * 60;

        list($token, $error) = $this->authInterface->LogIn($credentials, $expiryTime);
        if ($error != null) {
            return $this->errorResponse($error, 500);
        }

        return $this->successResponse($token, 'Login successfully', 200);
    }

    public function getProfile()
    {
        $user = auth()->user();

        return $this->successResponse($user, 'Get logged user data successfully', 200);
    }
}