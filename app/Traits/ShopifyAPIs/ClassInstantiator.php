<?php

namespace App\Traits\ShopifyAPIs;

use App\Models\User;

trait ClassInstantiator
{
    public static function new(?User $user = null): self
    {
        return new static($user);
    }
}
