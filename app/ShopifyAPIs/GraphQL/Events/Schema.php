<?php

namespace App\ShopifyAPIs\GraphQL\Events;

class Schema
{
    public static function webhookSubscriptionCreate(): string
    {
        return <<<'GRAPHQL'
            mutation webhookSubscriptionCreate($topic: WebhookSubscriptionTopic!, $webhookSubscription: WebhookSubscriptionInput!) {
                webhookSubscriptionCreate(topic: $topic, webhookSubscription: $webhookSubscription) {
                  webhookSubscription {
                    id
                    topic
                    format
                    endpoint {
                      __typename
                      ... on WebhookHttpEndpoint {
                        callbackUrl
                      }
                    }
                  }
                }
              }
        GRAPHQL;
    }
}
