<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer;

interface ProductDetailPageProductCategoryStorageClientInterface
{
    /**
     * @param int $idProductAbstract
     * @param string $locale
     *
     * @return \Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer|null
     */
    public function findProductAbstractCategory(int $idProductAbstract, string $locale): ?ProductAbstractCategoryStorageTransfer;
}
