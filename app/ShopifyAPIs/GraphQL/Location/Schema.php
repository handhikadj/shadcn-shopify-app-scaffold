<?php

namespace App\ShopifyAPIs\GraphQL\Location;

class Schema
{
    public static function responseFields(): string
    {
        return <<<'GRAPHQL'
            id
            name
            address {
              address1
              city
              countryCode
              phone
            }
        GRAPHQL;
    }

    public static function getDefault(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            query location {
              location {
                $responseFields
              }
            }
        GRAPHQL;
    }

    public static function all(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            query locations {
              locations(first: 50) {
                nodes {
                    $responseFields
                    metafields(first: 50) {
                      nodes {
                        key
                        value
                      }
                    }
                }
              }
            }
        GRAPHQL;

    }

    public static function create(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            mutation locationAdd(\$input: LocationAddInput!) {
              locationAdd(input: \$input) {
                location {
                  $responseFields
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }

    public static function update(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            mutation locationEdit(\$id: ID!, \$input: LocationEditInput!) {
              locationEdit(id: \$id, input: \$input) {
                location {
                  $responseFields
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
