<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Dependency\Client;

use Spryker\Client\Catalog\CatalogClientInterface;

class ProductDetailPageToCatalogClientBridge implements ProductDetailPageToCatalogClientInterface
{
    /**
     * @var \Spryker\Client\Catalog\CatalogClientInterface
     */
    protected $catalogClient;

    /**
     * ProductDetailPageToCatalogClientBridge constructor.
     *
     * @param \Spryker\Client\Catalog\CatalogClientInterface $catalogClient
     */
    public function __construct(CatalogClientInterface $catalogClient)
    {
        $this->catalogClient = $catalogClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function catalogSearch(string $searchString, array $requestParameters): array
    {
        return $this->catalogClient->catalogSearch($searchString, $requestParameters);
    }
}
