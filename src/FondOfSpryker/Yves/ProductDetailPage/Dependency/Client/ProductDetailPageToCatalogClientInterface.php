<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Dependency\Client;

interface ProductDetailPageToCatalogClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function catalogSearch(string $searchString, array $requestParameters): array;
}
