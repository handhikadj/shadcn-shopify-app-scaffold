<?php

namespace App\ShopifyAPIs\GraphQL\Customer;

use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

class Customer extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    public function update(array $data): self
    {
        $response = $this->graphQlRequest(Schema::update(), [
            'input' => $data
        ]);

        \Log::info('Customer update response', ['response' => $response]);

        $response = data_get($response, 'customerUpdate.customer');

        return $this->setAttributes($response);
    }
}
