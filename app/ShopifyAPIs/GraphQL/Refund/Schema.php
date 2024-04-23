<?php

namespace App\ShopifyAPIs\GraphQL\Refund;

class Schema
{
    public static function retrieve(string|int $id)
    {
        // refundLineItems(first: 50) {
        // nodes {
        //             quantity
        //             lineItem {
        // id
        //               name
        //               product {
        //     id
        //                 title
        //               }
        //               variant {
        //     sku
        //                 title
        //               }
        //             }
        //           }
        //         }
        //
        return <<<GRAPHQL
            query {
              refund(id: "gid://shopify/Refund/$id") {
                totalRefundedSet {
                  shopMoney {
                    amount
                    currencyCode
                  }
                }
              }
            }
        GRAPHQL;
    }
}
