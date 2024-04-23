<?php

namespace App\ShopifyAPIs\GraphQL\Order;

class Schema
{
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
}
