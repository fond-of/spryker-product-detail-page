<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Controller;

use FondOfSpryker\Yves\ProductDetailPage\Mapper\ProductDetailPageKeyMapper;
use Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer;
use Generated\Shared\Transfer\ProductCategoryStorageTransfer;
use SprykerShop\Yves\ProductDetailPage\Controller\ProductController as SprykerShopProductController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \FondOfSpryker\Yves\ProductDetailPage\ProductDetailPageFactory getFactory()
 */
class ProductController extends SprykerShopProductController
{
    const DEFAULT_LOCALE = 'en_US';

    /**
     * @param array $productData
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return array
     */
    protected function executeDetailAction(array $productData, Request $request): array
    {
        $productViewTransfer = $this->getFactory()
            ->getProductStorageClient()
            ->mapProductStorageData($productData, $this->getLocale(), $this->getSelectedAttributes($request));

        $this->assertProductRestrictions($productViewTransfer);

        $productAbstractCategoryStorageTransfer = $this->getFactory()
            ->getProductCategoryStorageClient()
            ->findProductAbstractCategory($productViewTransfer->getIdProductAbstract(), $this->getLocale());

        $crossSellingProducts = $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', ['model' => $productViewTransfer->getAttributes()['model']]);

        return [
            'product' => $productViewTransfer,
            'productUrl' => $this->getProductUrl($productViewTransfer),
            'crossSellingProducts' => $crossSellingProducts,
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
