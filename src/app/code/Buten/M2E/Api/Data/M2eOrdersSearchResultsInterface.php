<?php
declare(strict_types=1);

namespace Buten\M2E\Api\Data;

interface M2eOrdersSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get m2e_orders list.
     * @return \Buten\M2E\Api\Data\M2eOrdersInterface[]
     */
    public function getItems();

    /**
     * Set id list.
     * @param \Buten\M2E\Api\Data\M2eOrdersInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

