<?php

namespace FondOfSpryker\Yves\ProductDetailPage\Mapper;

class ProductDetailPageKeyMapper implements ProductDetailPageKeyInterface
{
    const CATEGORY = 'category';
    const STOREKEY = 'storekey';
    const STORE = 'store';

    /**
     * @var array
     */
    protected $params;

    /**
     * ProductDetailPageKeyMapper constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function build(): array
    {
        $this->params[self::CATEGORY] = $this->getCategoryKey();
        $this->params[self::STOREKEY] = $this->getStoreKey();
        $this->params[self::STORE] = $this->getStore();

        return $this->params;
    }

    /**
     * @return null|string
     */
    protected function getCategoryKey(): ?string
    {
        if (!isset($this->params[static::CATEGORY]) or !$this->params[static::CATEGORY]) {
            return null;
        }

        return str_replace([" "], ["_"], strtolower($this->params[static::CATEGORY]));
    }

    /**
     * @return null|string
     */
    protected function getStore(): ?string
    {
        if (!isset($this->params[static::STORE]) or !$this->params[static::STORE]) {
            return null;
        }

        return strtolower($this->params[static::STORE]);
    }

    /**
     * @return null|string
     */
    protected function getStoreKey(): ?string
    {
        if (!isset($this->params[static::STOREKEY]) or !$this->params[static::STOREKEY]) {
            return null;
        }

        $arrStore = explode("_", $this->params[static::STOREKEY]);

        return strtolower($arrStore[0]);
    }
}
