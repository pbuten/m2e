<?php
declare(strict_types=1);

namespace Buten\M2E\Block;

use Buten\M2E\Helper\UserCheck;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class User extends Template
{
    /**
     * User action url
     */
    private const ACTION_URL = '/m2e/orders/user';

    /**
     * @var UserCheck
     */
    private UserCheck $userCheck;

    /**
     * Constructor
     *
     * @param Context  $context
     * @param UserCheck $userCheck
     * @param array $data
     */
    public function __construct(
        Context $context,
        UserCheck $userCheck,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->userCheck = $userCheck;
    }

    /**
     * @return bool
     */
    public function isRegistered(): bool
    {
        return $this->userCheck->isRegistered();
    }

    /**
     * @return string
     */
    public function getFormAction(): string
    {
        return self::ACTION_URL;
    }

    /**
     * @return array
     */
    public function getUserData(): array
    {
        return $this->userCheck->getUser();
    }
}
