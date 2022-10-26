<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Helper\SingleImageUpload;
use App\Interfaces\AuthInterface;
use App\GraphQL\Types\ResponseSuccess;
use App\GraphQL\Types\ResponseError;

final class CreateAccount
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */

    protected $authInterface;
    use SingleImageUpload;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        
        //* Get input value
        $email = $args['email'];
        $name = $args['name'];
        $phoneNumber = $args['phone_number'];
        $password = $args['password'];
        $avatar = $args['avatar'];

        $userAlreadyExist = $this->authInterface->FindUserByEmail($email);
        if ($userAlreadyExist) {
            return new ResponseError(['message' => 'User already exist']);
            // return $this->errorResponse('User already exist', 400);
        }

        $hashedPw = Hash::make($password);

        $user = new User;
        
        $user->name = $name;
        $user->email = $email;
        $user->password = $hashedPw;
        $user->phone_number = $phoneNumber;
        $user->avatar = $avatar;
        $user->is_admin = 0;
        
        list($createdUser, $error) = $this->authInterface->SignUp($user);
        if ($error != null) {
            return new ResponseError(['message' => $error]);
            // return $this->errorResponse($error, 500);
        }

        return new ResponseSuccess(['message' => 'Sign up Successfully']);
        // return $this->successResponse($createdUser, 'Sign up successfully', 201);
    }
}
