<?php
declare(strict_types=1);

namespace Buten\M2E\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class M2eOrders extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('buten_m2e_orders', 'm2e_orders_id');
    }
}

