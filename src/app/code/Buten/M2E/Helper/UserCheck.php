<?php
declare(strict_types=1);

namespace Buten\M2E\Helper;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Cache\Type\Config as ConfigCache;

class UserCheck extends AbstractHelper
{
    /**
     * Config path
     */
    const CONFIG_PATH = 'm2e/orders/';

    /**
     * Config fields
     */
    const FIELDS = ['name', 'email', 'phone'];

    /**
     * @var Config
     */
    private Config $_resourceConfig;

    /**
     * @var TypeListInterface
     */
    protected TypeListInterface $cacheTypeList;

    /**
     * @param Config $_resourceConfig
     * @param Context $context
     * @param TypeListInterface $cacheTypeList
     */
    public function __construct(
        Context $context,
        Config $_resourceConfig,
        TypeListInterface $cacheTypeList
    ) {
        parent::__construct($context);
        $this->_resourceConfig = $_resourceConfig;
        $this->cacheTypeList = $cacheTypeList;
    }

    /**
     * @return bool
     */
    public function isRegistered(): bool
    {
        if ($this->getConfigValue('name')) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getUser(): array
    {
        $userData = [];
        foreach (self::FIELDS as $field) {
            $userData[$field] = $this->getConfigValue($field);
        }
        return $userData;
    }

    /**
     * @param array $userData
     * @return void
     */
    public function saveUser(array $userData): void
    {
        foreach (self::FIELDS as $field) {
            $this->setConfigValue(self::CONFIG_PATH . $field, $userData[$field]);
        }
        $this->cacheTypeList->cleanType(ConfigCache::TYPE_IDENTIFIER);
    }

    /**
     * @param string $path
     * @return mixed
     */
    private function getConfigValue(string $path = ''): mixed
    {
        return $this->scopeConfig
            ->getValue(self::CONFIG_PATH . $path, 'default');
    }

    /**
     * @param string $path
     * @param string $value
     */
    private function setConfigValue(string $path, string $value = ''): void
    {
        $this->_resourceConfig->saveConfig($path, $value);
    }
}

