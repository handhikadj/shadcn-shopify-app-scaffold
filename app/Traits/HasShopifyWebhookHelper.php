<?php

namespace App\Traits;

use App\Models\User;

trait HasShopifyWebhookHelper
{
    public User $user;

    public function getDomain(): string
    {
        return $this->shopDomain->toNative();
    }

    public function getShop(): User
    {
        $this->user = User::where('name', $this->getDomain())->firstOrFail();

        return $this->user;
    }
}
