<?php


namespace App\RepositoryInterfaces;


interface UserRepositoryInterface{

    public function login($data);
    public function logout();
    public function getUser();
}