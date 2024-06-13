<?php

namespace App\Traits\ShopifyAPIs\REST;

use Log;
use Exception;

trait HasRESTRequest
{
    public function request(string $url, string $method = 'GET', array $params = [])
    {
        $shopifyApiVersion = config('shopify-app.api_version');

        $response = $this->user->api()->rest(
            $method,
            "/admin/api/${shopifyApiVersion}/{$url}",
            $params
        );

        if ($response['errors']) {
            if ($response['status'] === 404) return null;

            Log::error('ShopifyAdminAPIs/REST/HasRESTRequest::request error: ' . json_encode($response['body']), [
                'context' => 'ShopifyAdminAPIs/REST/HasRESTRequest::request',
                'url' => $url,
                'method' => $method,
                'params' => $params,
                'response' => $response,
            ]);

            throw new Exception(json_encode($response));
        }

        return $response;
    }

    public function getRequest(string $url, array $params = [])
    {
        return $this->request($url, 'GET', $params);
    }

    public function postRequest(string $url, array $params = [])
    {
        return $this->request($url, 'POST', $params);
    }

    public function putRequest(string $url, array $params = [])
    {
        return $this->request($url, 'PUT', $params);
    }

    public function deleteRequest(string $url, array $params = [])
    {
        return $this->request($url, 'DELETE', $params);
    }
}
