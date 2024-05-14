<?php

namespace App\ShopifyAPIs\GraphQL\Events;

use Arr;
use App\Models\User;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

class Events extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    public function webhookSubscriptionCreate(array $variables): Events
    {
        $response = $this->graphQlRequest(Schema::webhookSubscriptionCreate(), $variables);

        $response = data_get($response, 'webhookSubscriptionCreate.webhookSubscription');

        return $this->setAttributes($response);
    }
}
