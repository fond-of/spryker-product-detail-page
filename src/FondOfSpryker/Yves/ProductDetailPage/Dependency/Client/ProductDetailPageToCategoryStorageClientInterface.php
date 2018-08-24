<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Dependency\Client;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;

interface ProductDetailPageToCategoryStorageClientInterface
{
    /**
     * @param int $idCategoryNode
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\CategoryNodeStorageTransfer
     */
    public function getCategoryNodeById($idCategoryNode, $localeName): CategoryNodeStorageTransfer;
}
