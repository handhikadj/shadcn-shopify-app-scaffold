<?php

namespace App\ShopifyAPIs\REST;

use Arr;
use App\ShopifyAPIs\REST\Abstracts\RESTModel;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\Traits\ShopifyAPIs\REST\HasRESTRequest;

/**
 * @property array $transactions
 */
class Order extends RESTModel
{
    use ClassInstantiator, HasRESTRequest;

    public function retrieve(string|int $id)
    {
        $response = $this->getRequest("orders/{$id}.json");

        $res = data_get($response, 'body.container.order');

        return $res ? $this->setAttributes($res) : $res;

    }

    public function getTransactions(string|int $orderId)
    {
        $response = $this->getRequest("orders/{$orderId}/transactions.json");

        $res = data_get($response, 'body.container');

        return $res ? $this->setAttributes($res) : $res;
    }
}
