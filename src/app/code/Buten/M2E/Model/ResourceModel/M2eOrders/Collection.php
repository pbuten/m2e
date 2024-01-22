<?php
declare(strict_types=1);

namespace Buten\M2E\Model\ResourceModel\M2eOrders;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'm2e_orders_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Buten\M2E\Model\M2eOrders::class,
            \Buten\M2E\Model\ResourceModel\M2eOrders::class
        );
    }
}

