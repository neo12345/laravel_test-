<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Admin;
use App\Categories;

class CategoryPolicy
{

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Admin $user, $auth)
    {
        return $auth;
    }
}


