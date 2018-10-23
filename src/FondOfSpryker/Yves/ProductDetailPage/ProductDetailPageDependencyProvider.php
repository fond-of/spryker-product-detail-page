<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace FondOfSpryker\Yves\ProductDetailPage;

use FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductDetailPageProductCategoryStorageClientBridge;
use FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductDetailPageToCatalogClientBridge;
use FondOfSpryker\Yves\ProductDetailPage\Dependency\Client\ProductDetailPageToCategoryStorageClientBridge;
use Pyz\Shared\Category\CategoryConfig;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ProductDetailPage\ProductDetailPageDependencyProvider as SprykerShopProductDetailPageDependencyProvider;

class ProductDetailPageDependencyProvider extends SprykerShopProductDetailPageDependencyProvider
{
    const PRODUCT_CATEGORY_STORAGE_CLIENT = 'PRODUCT_CATEGORY_STORAGE_CLIENT';
    const CATALOG_CLIENT = 'CATALOG_CLIENT';
    const CATEGORY_CONFIG = 'CATEGORY_CONFIG';
    const CLIENT_CATEGORY_STORAGE = 'CLIENT_CATEGORY_STORAGE';
    const STORE = 'STORE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addProductStorageClient($container);
        $container = $this->addProductDetailPageWidgetPlugins($container);
        $container = $this->addProductCategoryStorageClient($container);
        $container = $this->addCatalogClient($container);
        $container = $this->addCategoryConfig($container);
        $container = $this->addCategoryStorageClient($container);
        $container = $this->addStore($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductCategoryStorageClient(Container $container): Container
    {
        $container[self::PRODUCT_CATEGORY_STORAGE_CLIENT] = function (Container $container) {
            return new ProductDetailPageProductCategoryStorageClientBridge(
                $container->getLocator()->productCategoryStorage()->client()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCatalogClient(Container $container): Container
    {
        $container[self::CATALOG_CLIENT] = function (Container $container) {
            return new ProductDetailPageToCatalogClientBridge(
                $container->getLocator()->catalog()->client()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCategoryConfig(Container $container): Container
    {
        $container[self::CATEGORY_CONFIG] = function () {
            return new CategoryConfig();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCategoryStorageClient(Container $container): Container
    {
        $container[static::CLIENT_CATEGORY_STORAGE] = function (Container $container) {
            return new ProductDetailPageToCategoryStorageClientBridge(
                $container->getLocator()->categoryStorage()->client()
            );
        };

        return $container;
    }

    protected function addStore(Container $container): Container
    {
        $container[static::STORE] = function (Container $container) {
            return Store::getInstance();
        };

        return $container;
    }
}
