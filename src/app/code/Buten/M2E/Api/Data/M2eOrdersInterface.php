<?php
declare(strict_types=1);

namespace Buten\M2E\Api\Data;

interface M2eOrdersInterface
{

    const PURCHASE_DATE = 'purchase_date';
    const ORDER_ID = 'order_id';
    const GRAND_TOTAL = 'grand_total';
    const SHIP_TO_NAME = 'ship_to_name';
    const STATUS = 'status';
    const M2E_ORDERS_ID = 'm2e_orders_id';
    const CUSTOMER_EMAIL = 'customer_email';

    /**
     * Get m2e_orders_id
     * @return string|null
     */
    public function getM2eOrdersId();

    /**
     * Set m2e_orders_id
     * @param string $m2eOrdersId
     * @return \Buten\M2E\M2eOrders\Api\Data\M2eOrdersInterface
     */
    public function setM2eOrdersId($m2eOrdersId);

    /**
     * Get id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set id
     * @param string $id
     * @return \Buten\M2E\M2eOrders\Api\Data\M2eOrdersInterface
     */
    public function setOrderId($orderId);

    /**
     * Get purchase_date
     * @return string|null
     */
    public function getPurchaseDate();

    /**
     * Set purchase_date
     * @param string $purchaseDate
     * @return \Buten\M2E\M2eOrders\Api\Data\M2eOrdersInterface
     */
    public function setPurchaseDate($purchaseDate);

    /**
     * Get ship_to_name
     * @return string|null
     */
    public function getShipToName();

    /**
     * Set ship_to_name
     * @param string $shipToName
     * @return \Buten\M2E\M2eOrders\Api\Data\M2eOrdersInterface
     */
    public function setShipToName($shipToName);

    /**
     * Get customer_email
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set customer_email
     * @param string $customerEmail
     * @return \Buten\M2E\M2eOrders\Api\Data\M2eOrdersInterface
     */
    public function setCustomerEmail($customerEmail);

    /**
     * Get grand_total
     * @return string|null
     */
    public function getGrandTotal();

    /**
     * Set grand_total
     * @param string $grandTotal
     * @return \Buten\M2E\M2eOrders\Api\Data\M2eOrdersInterface
     */
    public function setGrandTotal($grandTotal);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Buten\M2E\M2eOrders\Api\Data\M2eOrdersInterface
     */
    public function setStatus($status);
}

