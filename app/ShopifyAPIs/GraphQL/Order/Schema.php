<?php

namespace App\ShopifyAPIs\GraphQL\Order;

class Schema
{
    public static function responseFields(): string
    {
        return <<<GRAPHQL
            id
            name
        GRAPHQL;

    }

    public static function retrieve(string|int $id)
    {
        return <<<GRAPHQL
            query {
              node(id: "gid://shopify/Order/$id") {
                id
                ... on Order {
                  name
                  lineItems(first: 50) {
                    nodes {
                      id
                      quantity
                      discountedUnitPriceAfterAllDiscountsSet {
                        shopMoney {
                          amount
                          currencyCode
                        }
                      }
                      variant {
                        id
                        price
                      }
                    }
                  }
                }
              }
            }
        GRAPHQL;
    }

    public static function update(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            mutation orderUpdate(\$input: OrderInput!) {
              orderUpdate(input: \$input) {
                order {
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
