<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = Auth::user();

            return $this->sendResponse($user, 'Current Logged in user.');
            
        } catch (Exception $e) {

            return $this->sendError('Error !.', $e->getMessage());
        }
    }

    public function allUsers()
    {
        try {
            $users = User::all();

            return $this->sendResponse($users, 'All users record.');
            
        } catch (Exception $e) {

            return $this->sendError('Error !.', $e->getMessage());
        }
    }
 
}
