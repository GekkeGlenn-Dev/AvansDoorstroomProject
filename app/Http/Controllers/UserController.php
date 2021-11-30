<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return $this->inertia->render('Dashboard/Users/Index', [
            'users' => User::withCount('orders')
                ->orderBy('created_at')
                ->paginate(25),
        ]);
    }

    public function edit(User $user): Response
    {
        $user->loadMissing('orders');

        return $this->inertia->render('Dashboard/Users/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        //
    }
}
