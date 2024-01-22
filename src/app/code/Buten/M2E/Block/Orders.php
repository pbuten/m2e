<?php
declare(strict_types=1);

namespace Buten\M2E\Block;

use Buten\M2E\Helper\UserCheck;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Buten\M2E\Model\ResourceModel\M2eOrders\CollectionFactory;
use Buten\M2E\Model\ResourceModel\M2eOrders\Collection;

class Orders extends Template
{
    /**
     * File upload action URL
     */
    private const ACTION_URL = '/m2e/orders/upload';

    /**
     * @var UserCheck
     */
    private UserCheck $userCheck;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * Constructor
     *
     * @param Context  $context
     * @param UserCheck $userCheck
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        UserCheck $userCheck,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->userCheck = $userCheck;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return string
     */
    public function getUploadFormAction(): string
    {
        return self::ACTION_URL;
    }

    /**
     * @return bool
     */
    public function isRegistered(): bool
    {
        return $this->userCheck->isRegistered();
    }

    /**
     * @return Collection
     */
    public function getOrdersCollection(): Collection
    {
        return $this->collectionFactory->create()->load();
    }
}

