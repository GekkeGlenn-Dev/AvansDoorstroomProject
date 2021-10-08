<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): \Inertia\Response
    {
        // all users.
        return $this->renderVue('Dashboard/Users/Index', [
            'users' => User::withCount('orders')
                ->orderBy('created_at')
                ->paginate(25),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user): \Inertia\Response
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        $user->loadMissing('orders');

        return $this->renderVue('Dashboard/Users/Edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
