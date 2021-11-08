<?php

namespace App\Http\Controllers\Api;

use DateTime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class AuthenticationController extends BaseController
{

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //validate user login data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users|max:50',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(),422);

        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);//hashing password 
        $user = User::create($input);

        $success['token'] =  $user->createToken('token')->accessToken; //generating of access token
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;

        return $this->sendResponse($success, 'User register successfully.' ,201);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) { //validate if password exists

            $user = Auth::user();

            $success['token'] =  $user->createToken('token')->accessToken; //generating of access token

            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');

        } else {
            
            return $this->sendError('Unauthorised.', 'incorrect username or password.' ,422);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $user = $user->token();

        $user->revoke();

        return $this->sendResponse([], 'User logged out successfully.');

        return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
    }
}
