<?php

namespace App\ShopifyAPIs\REST\Helpers;

use Illuminate\Support\Collection;

class CursorBasedPagination
{
    protected Collection $collection;
    protected array $links = [];

    public function __construct(
        protected array $response,
        protected $restModelClass,
        protected ?string $resourceName = null,
    ) {
        $this->collection = collect();
        $this->links = !empty($response['link']) ? $response['link']['container'] : [];

        $this->resourceName = $this->resourceName ?? $this->restModelClass->getResourceName();
    }

    public function setCollection(Collection $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getCollection(): Collection
    {
        $items = $this->collection->isNotEmpty() ? $this->collection : collect($this->response['body']['container'][$this->resourceName]);

        return $items->setRestModelAttributes($this->restModelClass);
    }

    public function getPreviousPageInfo()
    {
        return $this->links['previous'] ?? null;
    }

    public function getNextPageInfo()
    {
        return $this->links['next'] ?? null;
    }

    public function hasNextPage(): bool
    {
        return isset($this->links['next']);
    }

    public function hasPreviousPage(): bool
    {
        return isset($this->links['previous']);
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function getResult(): array
    {
        return [
            'data' => $this->getCollection(),
            'links' => $this->links,
            'previous_page_info' => $this->getPreviousPageInfo(),
            'next_page_info' => $this->getNextPageInfo(),
            'has_previous_page' => $this->hasPreviousPage(),
            'has_next_page' => $this->hasNextPage(),
        ];
    }
}
