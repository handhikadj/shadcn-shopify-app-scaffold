<?php

namespace App\ShopifyAPIs\GraphQL\Tag;

use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

class Tag extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    public function add(array $variables)
    {
        return $this->graphQlRequest(Schema::add(), $variables);
    }
}
