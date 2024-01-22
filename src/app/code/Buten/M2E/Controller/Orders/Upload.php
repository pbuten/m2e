<?php
declare(strict_types=1);

namespace Buten\M2E\Controller\Orders;

use Buten\M2E\Model\ImportOrders;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Upload implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var UploaderFactory
     */
    protected UploaderFactory $uploaderFactory;

    /**
     * @var AdapterFactory
     */
    protected AdapterFactory $adapterFactory;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var ManagerInterface
     */
    protected ManagerInterface $messageManager;

    /**
     * @var File
     */
    protected File $file;

    /**
     * @var DirectoryList
     */
    protected DirectoryList $directoryList;

    /**
     * @var ImportOrders
     */
    protected ImportOrders $importOrders;

    /**
     * @var JsonFactory
     */
    protected JsonFactory $resultJsonFactory;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     * @param UploaderFactory $uploaderFactory
     * @param AdapterFactory $adapterFactory
     * @param Filesystem $filesystem
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param File $file
     * @param DirectoryList $directoryList
     * @param ImportOrders $importOrders
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        PageFactory      $resultPageFactory,
        UploaderFactory  $uploaderFactory,
        AdapterFactory   $adapterFactory,
        Filesystem       $filesystem,
        RequestInterface $request,
        ManagerInterface $messageManager,
        File             $file,
        DirectoryList    $directoryList,
        ImportOrders     $importOrders,
        JsonFactory $resultJsonFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->file = $file;
        $this->directoryList = $directoryList;
        $this->importOrders = $importOrders;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        if ($this->request->getFiles()['upload_file']) {
            try {
                $this->checkMediaDirTmpDir();
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('tmp/');
                $uploader = $this->uploaderFactory->create(['fileId' => 'upload_file'])
                    ->setAllowCreateFolders(true)
                    ->setAllowedExtensions(['csv', 'xml']);
                if (!$uploader->save($destinationPath)) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: ' . $destinationPath)
                    );
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
                return $this->resultPageFactory->create();
            }
            try {
                $fileName = $this->request->getFiles()['upload_file']['name'];
                $filePath = $destinationPath . $fileName;
                $fileType = $this->request->getFiles()['upload_file']['type'];
                $this->importOrders->import($filePath, $fileType);
                $this->messageManager->addSuccessMessage(__($fileName . ' file successfully uploaded. Orders were imported.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $this->resultPageFactory->create();
    }

    /**
     * Media directory name for the temporary file storage
     * pub/media/tmp
     *
     * @return void
     */
    protected function checkMediaDirTmpDir(): void
    {
        $tmpDir = $this->directoryList->getPath(DirectoryList::MEDIA) . DIRECTORY_SEPARATOR . 'tmp/';
        $this->file->checkAndCreateFolder($tmpDir);
    }
}
