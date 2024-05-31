<?php

namespace App\Traits\ShopifyAPIs\GraphQL;

use Arr;
use App\ShopifyAPIs\REST\Helpers\CursorBasedPagination;

trait HasRESTModelQueries
{
    public function chunk(int $perPage, callable $callback, array $params = [])
    {
        $params['limit'] = $perPage;
        $params['page_info'] = null;

        $resourceName = $this->getResourceName();

        while (true) {
            $response = $this->getRequest("$resourceName.json", $params);

            // avoid rate limiting
            sleep(2);

            $resourceResponse = collect($response['body']['container'][$resourceName]);

            if ($resourceResponse->isEmpty()) break;

            $callback($resourceResponse->setRestModelAttributes($this));

            $pagination = new CursorBasedPagination($response, $this);

            if (!$pagination->hasNextPage()) break;

            $params['page_info'] = $pagination->getNextPageInfo();

            $params = Arr::only($params, [
                'limit',
                'page_info',
            ]);
        }
    }

    public function retrieve($id, array $params = [])
    {
        $resourceName = $this->getResourceName();
        $singularResourceName = $this->getSingularResourceName();

        $response = $this->getRequest("$resourceName/$id.json", $params);

        return $this->setAttributes($response['body']['container'][$singularResourceName]);
    }

    public function count(?string $resourceName = null, ?array $params = null)
    {
        $resourceName = $resourceName ?? $this->getResourceName();

        $response = $this->getRequest("$resourceName/count.json", $params);

        return $response['body']['container']['count'];
    }
}
