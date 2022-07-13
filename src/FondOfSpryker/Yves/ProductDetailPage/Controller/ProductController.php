<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Controller;

use Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer;
use Generated\Shared\Transfer\ProductCategoryStorageTransfer;
use Spryker\Shared\Kernel\Store;
use SprykerShop\Yves\ProductDetailPage\Controller\ProductController as SprykerShopProductController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Yves\ProductDetailPage\ProductDetailPageFactory getFactory()
 */
class ProductController extends SprykerShopProductController
{
    public const DEFAULT_LOCALE = 'en_US';

    /**
     * @param array $productData
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeDetailAction(array $productData, Request $request): array
    {
        $productViewTransfer = $this->getFactory()
            ->getProductStorageClient()
            ->mapProductStorageData($productData, $this->getLocale(), $this->getSelectedAttributes($request));

        $this->assertProductRestrictions($productViewTransfer);

        $store = Store::getInstance()->getStoreName();

        $productAbstractCategoryStorageTransfer = $this->getFactory()
            ->getProductCategoryStorageClient()
            ->findProductAbstractCategory($productViewTransfer->getIdProductAbstract(), $this->getLocale(), $store);

        return [
            'product' => $productViewTransfer,
            'productUrl' => $this->getProductUrl($productViewTransfer),
            'categoryNodes' => ($productAbstractCategoryStorageTransfer instanceof ProductAbstractCategoryStorageTransfer) ? $productAbstractCategoryStorageTransfer->getCategories() : false,
        ];
    }

    /**
     * @param array $productCategoryStorageTransfer
     * @param int $searchNode
     *
     * @return \Generated\Shared\Transfer\ProductCategoryStorageTransfer|null
     */
    protected function getCategory(array $productCategoryStorageTransfer, int $searchNode): ?ProductCategoryStorageTransfer
    {
        foreach ($productCategoryStorageTransfer->getCategories() as $category) {
            if ($category->getCategoryNodeId() == $searchNode) {
                return $category;
            }
        }

        return null;
    }
}
