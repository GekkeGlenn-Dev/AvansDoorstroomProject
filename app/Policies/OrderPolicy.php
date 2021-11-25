<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->isAdmin()
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Order $order): Response
    {
        if ($user->isAdmin()) {
            return $this->allow();
        }

        return $user->id === $order->user_id
            ? $this->allow()
            : $this->deny();
    }

    public function create(User $user): Response
    {
        return $this->allow();
    }

    public function update(User $user, Order $order): Response
    {
        return $user->isAdmin()
            ? $this->allow()
            : $this->deny();
    }

    public function delete(User $user, Order $order): Response
    {
        return $user->isAdmin()
            ? $this->allow()
            : $this->deny();
    }

    public function restore(User $user, Order $order): Response
    {
        return $user->isAdmin()
            ? $this->allow()
            : $this->deny();
    }

    public function forceDelete(User $user, Order $order): Response
    {
        return $this->deny();
    }
}
