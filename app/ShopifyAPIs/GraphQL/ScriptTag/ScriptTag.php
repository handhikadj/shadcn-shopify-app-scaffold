<?php

namespace App\ShopifyAPIs\GraphQL\ScriptTag;

use App\Models\User;
use GuzzleHttp\Promise\Promise;

class ScriptTag
{
    public function __construct(private ?User $user = null)
    {
        if (!$this->user) {
            $this->user = auth()->user();
        }

        if (!$this->user) {
            throw new \Exception('User not found.');
        }
    }

    public function create(array $data): Promise|array
    {
        return $this->user->api()->graph(Schema::create(), [
            'input' => $data,
        ]);
    }

    public function delete($id): Promise|array
    {
        return $this->user->api()->graph(Schema::delete(), [
            'id' => 'gid://shopify/ScriptTag/' . $id,
        ]);
    }

    public static function new(?User $user = null): self
    {
        return new self($user);
    }
}
