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

    // public function __construct(private ?User $user = null)
    // {
    //     $this->user = $user ?? auth()->user();
    // }

    public function webhookSubscriptionCreate(array $variables): Events|array
    {
        $response = $this->graphQlRequest(Schema::webhookSubscriptionCreate(), $variables);

        $res = Arr::get($response, 'webhookSubscriptionCreate.webhookSubscription');

        return $res ? $this->setAttributes($res) : $response;
    }
}
