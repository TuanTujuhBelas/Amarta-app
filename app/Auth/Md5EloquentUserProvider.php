<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class Md5EloquentUserProvider extends EloquentUserProvider
{
    /**
     * Validate a user against the given credentials using MD5.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        $plain = $credentials['password'] ?? '';

        if (empty($plain)) {
            return false;
        }

        // Only active accounts can login
        if (isset($user->status) && $user->status !== 'active') {
            return false;
        }

        return hash_equals(md5((string) $plain), (string) $user->getAuthPassword());
    }
}
