<?php
declare(strict_types=1);

namespace Buten\M2E\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Common extends Template
{
    /**
     * User action url
     */
    private const ACTION_URL = '/m2e/orders/user';

    /**
     * Constructor
     *
     * @param Context  $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
