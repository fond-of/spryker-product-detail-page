<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer;
use Spryker\Client\ProductCategoryStorage\ProductCategoryStorageClientInterface;

class ProductDetailPageProductCategoryStorageClientBridge implements ProductDetailPageProductCategoryStorageClientInterface
{
    /**
     * @var \Spryker\Client\ProductCategoryStorage\ProductCategoryStorageClientInterface;
     */
    protected $productCategoryStorageClient;

    /**
     * ProductDetailPageProductCategoryStorageClientBridge constructor.
     *
     * @param \FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductCategoryStorageClientInterface $productCategoryStorageClient
     */
    public function __construct(ProductCategoryStorageClientInterface $productCategoryStorageClient)
    {
        $this->productCategoryStorageClient = $productCategoryStorageClient;
    }

    public function findProductAbstractCategory(int $idProductAbstract, string $locale): ?ProductAbstractCategoryStorageTransfer
    {
        return $this->productCategoryStorageClient->findProductAbstractCategory($idProductAbstract, $locale);
    }
}
