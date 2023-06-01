<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\RepositoryInterfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    


    /// Login Method
    public function loginUser(Request $request)
    {
        return $this->userRepository->login($request->all());
        
    }

    

    public function getUserDetail()
    {
        return $this->userRepository->getUser();
    }

    

    //Logout Method
    public function userLogout()
    {
        return $this->userRepository->logout();
    }
}
