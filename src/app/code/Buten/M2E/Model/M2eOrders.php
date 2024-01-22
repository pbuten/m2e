<?php
declare(strict_types=1);

namespace Buten\M2E\Model;

use Buten\M2E\Api\Data\M2eOrdersInterface;
use Magento\Framework\Model\AbstractModel;

class M2eOrders extends AbstractModel implements M2eOrdersInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Buten\M2E\Model\ResourceModel\M2eOrders::class);
    }

    /**
     * @inheritDoc
     */
    public function getM2eOrdersId()
    {
        return $this->getData(self::M2E_ORDERS_ID);
    }

    /**
     * @inheritDoc
     */
    public function setM2eOrdersId($m2eOrdersId)
    {
        return $this->setData(self::M2E_ORDERS_ID, $m2eOrdersId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * @inheritDoc
     */
    public function getPurchaseDate()
    {
        return $this->getData(self::PURCHASE_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setPurchaseDate($purchaseDate)
    {
        return $this->setData(self::PURCHASE_DATE, $purchaseDate);
    }

    /**
     * @inheritDoc
     */
    public function getShipToName()
    {
        return $this->getData(self::SHIP_TO_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setShipToName($shipToName)
    {
        return $this->setData(self::SHIP_TO_NAME, $shipToName);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerEmail()
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * @inheritDoc
     */
    public function getGrandTotal()
    {
        return $this->getData(self::GRAND_TOTAL);
    }

    /**
     * @inheritDoc
     */
    public function setGrandTotal($grandTotal)
    {
        return $this->setData(self::GRAND_TOTAL, $grandTotal);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}

