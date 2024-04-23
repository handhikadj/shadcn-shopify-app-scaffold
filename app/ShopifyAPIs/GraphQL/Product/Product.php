<?php

namespace App\ShopifyAPIs\GraphQL\Product;

use Str;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

/**
 * @property int $totalInventory
 */
class Product extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    // public function __construct(private ?User $user = null)
    // {
    //     $this->user = $user ?? auth()->user();
    // }

    public function getByIds(array $ids): Collection
    {
        $response = $this->graphQlRequest(Schema::getByIds(), [
            'ids' => collect($ids)->map(fn ($id) => Str::createShopifyGqlResourceId('Product', $id))->toArray(),
        ]);

        return collect($response['nodes'])->map(fn ($node) => $this->setAttributes($node));
    }

    public function create(array $input, ?array $mediaData = null): Product
    {
        $variables = [
            'input' => $input,
        ];

        if ($mediaData) {
            $variables['media'] = $mediaData;
        }

        $response = $this->graphQlRequest(Schema::create(), $variables);

        return $this->setAttributes($response['productCreate']['product']);
    }

    public function retrieve(string|int $id): Product
    {
        $id = Str::createShopifyGqlResourceId('Product', $id);

        $response = $this->graphQlRequest(Schema::retrieve($id));

        return $this->setAttributes($response['product']);
    }

    public function deleteAsync(int $id)
    {
        $this->graphQlRequest(Schema::deleteAsync(), [
            'productId' => Str::createShopifyGqlResourceId('Product', $id)
        ]);
    }
}
