<?php

namespace App\ShopifyAPIs\GraphQL\Location;

class Schema
{
    public static function create(): string
    {
        return <<<'GRAPHQL'
            mutation locationAdd($input: LocationAddInput!) {
              locationAdd(input: $input) {
                location {
                  id
                  address {
                    countryCode
                  }
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }
}
