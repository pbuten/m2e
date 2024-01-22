<?php
declare(strict_types=1);

namespace Buten\M2E\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface M2eOrdersRepositoryInterface
{

    /**
     * Save m2e_orders
     * @param \Buten\M2E\Api\Data\M2eOrdersInterface $m2eOrders
     * @return \Buten\M2E\Api\Data\M2eOrdersInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Buten\M2E\Api\Data\M2eOrdersInterface $m2eOrders
    );

    /**
     * Retrieve m2e_orders
     * @param string $m2eOrdersId
     * @return \Buten\M2E\Api\Data\M2eOrdersInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($m2eOrdersId);

    /**
     * Retrieve m2e_orders matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Buten\M2E\Api\Data\M2eOrdersSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete m2e_orders
     * @param \Buten\M2E\Api\Data\M2eOrdersInterface $m2eOrders
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Buten\M2E\Api\Data\M2eOrdersInterface $m2eOrders
    );

    /**
     * Delete m2e_orders by ID
     * @param string $m2eOrdersId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($m2eOrdersId);
}

