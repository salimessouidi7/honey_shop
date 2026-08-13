<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // GET /api/admin/users - password is already excluded via User's $hidden property
    public function index()
    {
        return User::select('id', 'name', 'email', 'role', 'created_at')
            ->orderBy('name')
            ->get();
    }
}
