<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Controller;

use Generated\Shared\Transfer\ProductViewTransfer;
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
        if (!empty($productData['id_product_abstract']) && $this->isProductAbstractRestricted($productData['id_product_abstract'])) {
            throw new NotFoundHttpException();
        }

        $productViewTransfer = $this->getFactory()
            ->getProductStorageClient()
            ->mapProductStorageData($productData, $this->getLocale(), $this->getSelectedAttributes($request));

        $productAbstractCategoryStorageTransfer = $this->getFactory()
            ->getProductCategoryStorageClient()
            ->findProductAbstractCategory($productViewTransfer->getIdProductAbstract(), $this->getLocale());

        $nonLocalizedproductAbstractCategoryStorageTransfer = $this->getFactory()
            ->getProductCategoryStorageClient()
            ->findProductAbstractCategory($productViewTransfer->getIdProductAbstract(), self::DEFAULT_LOCALE);

        /*$foo = $this->getFactory()
            ->getCategoryStorageClient()
            ->getCategoryNodeById(3, 'en_US');*/

        $category = false;
        $productCategoryStorageTransfer = false;

        /** @var \Generated\Shared\Transfer\ProductCategoryStorageTransfer $category */
        foreach($nonLocalizedproductAbstractCategoryStorageTransfer->getCategories() as $category) {
            if ($category->getCategoryNodeId() == $productViewTransfer->getCategoryNodeId()) {
                $category = $category;
            }
        }

        /** @var \Generated\Shared\Transfer\ProductCategoryStorageTransfer $category */
        foreach($productAbstractCategoryStorageTransfer->getCategories() as $category) {
            if ($category->getCategoryNodeId() == $productViewTransfer->getCategoryNodeId()) {
                $productCategoryStorageTransfer = $category;
            }
        }

        $categoryKey = str_replace([" "], ["_"], strtolower($category->getName()));
        $productViewTransfer->setCategoryKey($categoryKey);

        $crossSellingProducts = $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', ['model' => $productViewTransfer->getAttributes()['model']]);

        return [
            'product' => $productViewTransfer,
            'productUrl' => $this->getProductUrl($productViewTransfer),
            'crossSellingProducts' => $crossSellingProducts,
            'categoryNode' => $productCategoryStorageTransfer,
        ];
    }

}
