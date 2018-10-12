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

        $nonLocalizedProductViewTransfer = $this->getFactory()
            ->getProductStorageClient()
            ->mapProductStorageData($productData, self::DEFAULT_LOCALE, $this->getSelectedAttributes($request));

        $nonLocalizedproductAbstractCategoryStorageTransfer = $this->getFactory()
            ->getProductCategoryStorageClient()
            ->findProductAbstractCategory($productViewTransfer->getIdProductAbstract(), self::DEFAULT_LOCALE);

        /** @var ProductCategoryStorageTransfer $productCategoryStorageTransfer */
        $productCategoryStorageTransfer = $productAbstractCategoryStorageTransfer->getCategories()[0];

        $crossSellingProducts = $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', ['model' => $productViewTransfer->getAttributes()['model']]);

        $modelKey = $this->safeKeyTransformer($nonLocalizedProductViewTransfer->getAttributes()['model']);
        $styleKey = $this->safeKeyTransformer($nonLocalizedProductViewTransfer->getAttributes()['style']);
        $categoryKey = $this->safeKeyTransformer(($nonLocalizedproductAbstractCategoryStorageTransfer->getCategories()[0])->getName());

        return [
            'product' => $productViewTransfer,
            'productUrl' => $this->getProductUrl($productViewTransfer),
            'crossSellingProducts' => $crossSellingProducts,
            'categoryNode' => $productCategoryStorageTransfer,
            'modelKey' => $modelKey,
            'styleKey' => $styleKey,
            'categoryKey' => $categoryKey,
        ];
    }

    protected function safeKeyTransformer(string $string): string
    {
        $search = [" "];
        $replace = ["-"];

        return str_replace($search, $replace, strtolower($string));
    }
}
