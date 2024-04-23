<?php

namespace App\ShopifyAPIs\REST;

use App\Models\User;
use App\ShopifyAPIs\REST\Abstracts\RESTModel;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\Traits\ShopifyAPIs\REST\HasRESTRequest;

class Product extends RESTModel
{
    use ClassInstantiator, HasRESTRequest;

    // public function __construct(public ?User $user = null)
    // {
    //     $this->user = $user ?? auth()->user();
    // }

    public function create(array $data)
    {
        $response = $this->postRequest('products.json', ['product' => $data]);

        return $response;
    }
}
