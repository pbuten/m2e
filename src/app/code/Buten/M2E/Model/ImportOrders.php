<?php
declare(strict_types=1);

namespace Buten\M2E\Model;

use DateTime;
use DateTimeZone;
use Exception;
use Magento\Framework\Xml\Parser;
use Buten\M2E\Model\ResourceModel\M2eOrders\CollectionFactory;
use Buten\M2E\Model\ResourceModel\M2eOrders\Collection;
use Buten\M2E\Model\M2eOrdersRepository;
use Buten\M2E\Model\M2eOrders;
use Buten\M2E\Model\M2eOrdersFactory;
use Magento\TestFramework\Eav\Model\Attribute\DataProvider\Date;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\File\Csv;

class ImportOrders
{
    /**
     * @var Parser
     */
    private Parser $xmlParser;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var M2eOrdersRepository
     */
    private M2eOrdersRepository $m2eOrdersRepository;

    /**
     * @var M2eOrdersFactory
     */
    private M2eOrdersFactory $m2eOrdersFactory;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var Csv
     */
    private Csv $csv;

    /**
     * @param Parser $xmlParser
     * @param CollectionFactory $collectionFactory
     * @param M2eOrdersRepository $m2eOrdersRepository
     * @param M2eOrdersFactory $m2eOrdersFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param Csv $csv
     */
    public function __construct(
        Parser               $xmlParser,
        CollectionFactory    $collectionFactory,
        M2eOrdersRepository  $m2eOrdersRepository,
        M2eOrdersFactory     $m2eOrdersFactory,
        ScopeConfigInterface $scopeConfig,
        Csv                  $csv
    ) {
        $this->xmlParser = $xmlParser;
        $this->collectionFactory = $collectionFactory;
        $this->m2eOrdersRepository = $m2eOrdersRepository;
        $this->m2eOrdersFactory = $m2eOrdersFactory;
        $this->scopeConfig = $scopeConfig;
        $this->csv = $csv;
    }

    /**
     * @param $filePath
     * @param $type
     * @return void
     */
    public function import($filePath, $type): void
    {
        if ($type == 'text/xml') {
            $this->proceedXml($filePath);
        }

        if ($type == 'text/csv') {
            $this->proceedCsv($filePath);
        }
    }

    /**
     * @param string $filePath
     * @return void
     */
    private function proceedXml(string $filePath): void
    {
        $ordersArray = $this->xmlParser->load($filePath)->xmlToArray();
        $ordersArray = $ordersArray['Workbook']['Worksheet']['_value']['Table']['Row'];
        $rebuiltOrdersArray = [];
        foreach ($ordersArray as $idRow => $row) {
            if ($idRow == 0) {
                continue;
            }
            $order = [];
            foreach ($row['Cell'] as $id => $value) {
                $order[$ordersArray[0]['Cell'][$id]['Data']['_value']] = $value['Data']['_value'];

            }
            $rebuiltOrdersArray[] = $order;
        }
        foreach ($rebuiltOrdersArray as $order) {
            $this->save($order);
        }
    }

    /**
     * @param $filePath
     * @return void
     * @throws Exception
     */
    private function proceedCsv($filePath): void
    {
        $csvData = $this->csv->getData($filePath);
        $rebuiltOrdersArray = [];
        foreach ($csvData as $idRow => $row) {
            if ($idRow == 0) {
                foreach ($row as $id => $value) {
                    $row[$id] = ltrim($value);
                }
                $csvData[$idRow] = $row;
                continue;
            }
            $order = [];
            foreach ($row as $id => $value) {
                $order[$csvData[0][$id]] = $value;

            }
            $rebuiltOrdersArray[] = $order;
        }
        foreach ($rebuiltOrdersArray as $order) {
            $this->save($order);
        }
    }

    /**
     * @param array $order
     * @return void
     */
    private function save(array $order): void
    {
        /** @var Collection $m2eOrdersCollection */
        $m2eOrdersCollection = $this->collectionFactory->create();
        /** @var M2eOrders $m2eOrder */
        $m2eOrder = $m2eOrdersCollection->addFieldToFilter('order_id', $order['id'])
            ->getFirstItem();
        if ($m2eOrder->getOrderId()) {
            $m2eOrder->setPurchaseDate($this->getDateTime($order['purchase date']))
                ->setShipToName($order['ship-to name'])
                ->setCustomerEmail($order['customer email'])
                ->setGrandTotal($order['grant total (purchased)'])
                ->setStatus($order['status']);
        }
        if (!$m2eOrder->getOrderId()) {
            /** @var M2eOrders $m2eOrder */
            $m2eOrder = $this->m2eOrdersFactory->create();
            $m2eOrder->setOrderId($order['id'])
                ->setPurchaseDate($this->getDateTime($order['purchase date'])->format('Y-m-d H:i:s'))
                ->setShipToName($order['ship-to name'])
                ->setCustomerEmail($order['customer email'])
                ->setGrandTotal(floatval($order['grant total (purchased)']))
                ->setStatus($order['status']);
        }
        try {
            $this->m2eOrdersRepository->save($m2eOrder);
        } catch (Exception $e) {
        }
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return (string)$this->scopeConfig->getValue('general/locale/timezone');
    }

    /**
     * @param string $date
     * @return DateTime
     */
    private function getDateTime(string $date = 'now'): DateTime
    {
        return new DateTime($date, new DateTimeZone($this->getTimezone()));
    }
}
