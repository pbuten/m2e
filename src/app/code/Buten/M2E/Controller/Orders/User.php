<?php
declare(strict_types=1);

namespace Buten\M2E\Controller\Orders;

use Buten\M2E\Helper\UserCheck;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class User implements HttpPostActionInterface, HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var UserCheck
     */
    protected UserCheck $userCheck;

    /**
     * @var JsonFactory
     */
    protected JsonFactory $resultJsonFactory;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     * @param RequestInterface $request
     * @param UserCheck $userCheck
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        PageFactory $resultPageFactory,
        RequestInterface $request,
        UserCheck $userCheck,
        JsonFactory $resultJsonFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->userCheck = $userCheck;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $params = $this->request->getParams();
        if (!key_exists('name', $params) || !$params['name']) {
            return $this->resultPageFactory->create();
        }

        $this->userCheck->saveUser($params);
        return $this->resultPageFactory->create();
    }
}

