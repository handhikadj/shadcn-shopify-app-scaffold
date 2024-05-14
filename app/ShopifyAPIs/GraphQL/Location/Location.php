<?php

namespace App\ShopifyAPIs\GraphQL\Location;

use Str;
use GuzzleHttp\Promise\Promise;
use Illuminate\Support\Collection;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

/**
 * @property ?string $branch_code
 */
class Location extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    public function getDefault(): Location
    {
        $response = $this->graphQlRequest(Schema::getDefault());

        $response = data_get($response, 'location');

        return $this->setAttributes($response);
    }

    /**
     * @return Collection<Location>
     * @throws \Exception
     */
    public function all()
    {
        $response = $this->graphQlRequest(Schema::all());

        return collect($response['locations']['nodes'])
            ->map(fn($location) => $this->setAttributes($location));
    }

    public function create(array $data): Promise|array
    {
        return $this->graphQlRequest(Schema::create(), [
            'input' => $data,
        ]);
    }

    public function update(string|int $id, array $data): Promise|array
    {
        $id = Str::createShopifyGqlResourceId('Location', $id);

        return $this->graphQlRequest(Schema::update(), [
            'id' => $id,
            'input' => $data,
        ]);
    }
}
