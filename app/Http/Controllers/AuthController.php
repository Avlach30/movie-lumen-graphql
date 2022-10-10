<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Helper\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    use ApiResponse;

    public function SignUp(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone_number' => 'required'
        ]);

        $isExist = User::where('email',$request->input('email'))->first();
        if ($isExist) {
            return $this->errorResponse('User already exist', 400);
        }

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

        $user->avatar = '/avatar/some-image.jpg';
        $user->is_admin = $isAdmin;

        $user->save();

        return $this->successResponse($user, 'Sign up successfully', 201);
    }
}