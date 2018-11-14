<?php

namespace FondOfSpryker\Yves\ProductDetailPage;

use FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductDetailPageProductCategoryStorageClientInterface;
use FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductDetailPageToCatalogClientInterface;
use FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductDetailPageToCategoryStorageClientInterface;
use FondOfSpryker\Yves\ProductDetailPage\Mapper\ProductDetailPageKeyMapper;
use Spryker\Client\Kernel\AbstractBundleConfig;
use Spryker\Shared\Kernel\Store;
use SprykerShop\Yves\ProductDetailPage\ProductDetailPageFactory as SprykerShopProductDetailPageFactory;

class ProductDetailPageFactory extends SprykerShopProductDetailPageFactory
{
    /**
     * @return \Spryker\Client\ProductCategoryStorage\ProductCategoryStorageClientInterface
     */
    public function getProductCategoryStorageClient(): ProductDetailPageProductCategoryStorageClientInterface
    {
        return $this->getProvidedDependency(ProductDetailPageDependencyProvider::PRODUCT_CATEGORY_STORAGE_CLIENT);
    }

    /**
     * @return \FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductDetailPageToCatalogClientInterface
     */
    public function getCatalogClient(): ProductDetailPageToCatalogClientInterface
    {
        return $this->getProvidedDependency(ProductDetailPageDependencyProvider::CATALOG_CLIENT);
    }

    public function getCategoryConfig(): AbstractBundleConfig
    {
        return $this->getProvidedDependency(ProductDetailPageDependencyProvider::CATEGORY_CONFIG);
    }

    /**
     * @return \FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductDetailPageToCategoryStorageClientInterface
     */
    public function getCategoryStorageClient(): ProductDetailPageToCategoryStorageClientInterface
    {
        return $this->getProvidedDependency(ProductDetailPageDependencyProvider::CLIENT_CATEGORY_STORAGE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return $this->getProvidedDependency(ProductDetailPageDependencyProvider::STORE);
    }
}
