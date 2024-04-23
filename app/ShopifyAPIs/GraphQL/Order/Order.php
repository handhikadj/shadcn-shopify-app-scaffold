<?php

namespace App\ShopifyAPIs\GraphQL\Order;

use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

class Order extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    public function retrieve(string|int $id)
    {
        $response = $this->graphQlRequest(Schema::retrieve($id));

        return $this->setAttributes($response['node']);
    }
}
