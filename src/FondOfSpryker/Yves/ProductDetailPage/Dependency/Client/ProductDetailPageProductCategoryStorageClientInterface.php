<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer;

interface ProductDetailPageProductCategoryStorageClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     * @param string $localeName
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer|null
     */
    public function findProductAbstractCategory(
        int $idProductAbstract,
        string $localeName,
        string $storeName
    ): ?ProductAbstractCategoryStorageTransfer;
}
