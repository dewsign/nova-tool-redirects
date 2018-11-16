<?php

namespace Dewsign\NovaToolRedirects\Policies;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class RedirectPolicy
{
    use HandlesAuthorization;

    public function viewAny()
    {
        return Gate::any(['viewRedirect', 'manageRedirect']);
    }

    public function view($redirect)
    {
        return Gate::any(['viewRedirect', 'manageRedirect'], $redirect);
    }

    public function create($user)
    {
        return $user->can('manageRedirect');
    }

    public function update($user, $redirect)
    {
        return $user->can('manageRedirect', $redirect);
    }

    public function delete($user, $redirect)
    {
        return $user->can('manageRedirect', $redirect);
    }

    public function restore($user, $redirect)
    {
        return $user->can('manageRedirect', $redirect);
    }

    public function forceDelete($user, $redirect)
    {
        return $user->can('manageRedirect', $redirect);
    }
}
