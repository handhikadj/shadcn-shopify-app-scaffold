<?php

namespace App\ShopifyAPIs\GraphQL\Tag;

class Schema
{
    public static function add(): string
    {
        return <<<'GQL'
            mutation tagsAdd($id: ID!, $tags: [String!]!) {
              tagsAdd(id: $id, tags: $tags) {
                node {
                  id
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GQL;
    }
}
