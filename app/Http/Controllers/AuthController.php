<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Helper\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{

    use ApiResponse;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function SignUp(Request $request) {

        if (!$request->hasFile('avatar')) {
            return $this->errorResponse('Sorry! you must upload an avatar', 400);
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone_number' => 'required'
        ]);

        $image = $request->file('avatar');

        $fileName = $image->getClientOriginalName();
        $fileExtension = $image->getClientOriginalExtension();
        $fileSize = $image->getSize();

        if (in_array($fileExtension, array("jpg", "jpeg", "png")) == false ) {
            return $this->errorResponse('Sorry! only image file is allowed', 400);
        }

        if ($fileSize > 1572864) {
            return $this->errorResponse('Sorry! only image file with size smaller than 1,5 Mb is allowed', 400);
        }

        $uuid = $this->attributes['uuid'] = Uuid::uuid4()->toString();
        $avatarName = 'image-' . $uuid . '.' . $fileExtension;

        
        $isExist = User::where('email',$request->input('email'))->first();
        if ($isExist) {
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
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $hashedPw;
        $user->phone_number = $request->input('phone_number');

        $user->avatar = $avatarPath;
        $user->is_admin = $isAdmin;

        $user->save();

        return $this->successResponse($user, 'Sign up successfully', 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $expiryTime = auth()->factory()->getTTL() * 60;

        if (! $token = auth()->attempt($credentials)) {
            return $this->errorResponse('Invalid email or password', 401);
        }

        return $this->loginSuccessResponse($token, 'Login successfully', 200, $expiryTime);
    }

    public function getProfile()
    {
        $user = auth()->user();

        return $this->successResponse($user, 'Get logged user data successfully', 200);
    }
}