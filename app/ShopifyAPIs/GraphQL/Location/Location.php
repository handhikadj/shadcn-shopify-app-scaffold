<?php

namespace App\ShopifyAPIs\GraphQL\Location;

use App\Models\User;
use GuzzleHttp\Promise\Promise;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

class Location extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    // public function __construct(private ?User $user = null)
    // {
    //     $this->user = $user ?? auth()->user();
    // }

    public function create(array $data): Promise|array
    {
        return $this->graphQlRequest(Schema::create(), [
            'input' => $data,
        ]);
    }
}
