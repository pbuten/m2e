<?php
declare(strict_types=1);

namespace Buten\M2E\Controller\Orders;

use Buten\M2E\Helper\UserCheck;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

class Ajax implements HttpPostActionInterface
{

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var Json
     */
    protected Json $serializer;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var Http
     */
    protected Http $http;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var JsonFactory
     */
    protected JsonFactory $resultJsonFactory;

    /**
     * @var UserCheck
     */
    protected UserCheck $userCheck;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     * @param Json $json
     * @param LoggerInterface $logger
     * @param Http $http
     * @param RequestInterface $request
     * @param JsonFactory $resultJsonFactory
     * @param UserCheck $userCheck
     */
    public function __construct(
        PageFactory $resultPageFactory,
        Json $json,
        LoggerInterface $logger,
        Http $http,
        RequestInterface $request,
        JsonFactory $resultJsonFactory,
        UserCheck $userCheck
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->serializer = $json;
        $this->logger = $logger;
        $this->http = $http;
        $this->request = $request;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->userCheck = $userCheck;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $class = '\User';
        $template = '/user.phtml';
        if (key_exists('scope', $_POST)) {
            if ($_POST['scope'] == 'view' || $_POST['scope'] == 'upload') {
                $class = '\Orders';
                $template = '/' . $_POST['scope'] . '.phtml';
            }
        }

        $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();
        $block = $resultPage->getLayout()
                ->createBlock('Buten\M2E\Block' . $class)
                ->setTemplate('Buten_M2E::ajax' . $template)
                ->toHtml();
        $result->setData(['result' => $block]);
        return $result;
    }
}
