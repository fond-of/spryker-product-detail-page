<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Controller;

use SprykerShop\Yves\ProductDetailPage\Controller\ProductController as SprykerShopProductController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \FondOfSpryker\Yves\ProductDetailPage\ProductDetailPageFactory getFactory()
 */
class ProductController extends SprykerShopProductController
{
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

        $idCategoryNode = $this->getFactory()
            ->getCategoryConfig()
            ->getCategoryIdByModelName($productViewTransfer->getAttributes()['model']);

        $categoryNode = $this->getFactory()
            ->getCategoryStorageClient()
            ->getCategoryNodeById($idCategoryNode, $this->getLocale());

        $crossSellingProducts = $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', ['category' => $idCategoryNode]);

        return [
            'product' => $productViewTransfer,
            'productUrl' => $this->getProductUrl($productViewTransfer),
            'crossSellingProducts' => $crossSellingProducts,
            'category' => $categoryNode,
        ];
    }
}
