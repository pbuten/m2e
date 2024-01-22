<?php
declare(strict_types=1);

namespace Buten\M2E\Model;

use Buten\M2E\Api\Data\M2eOrdersInterface;
use Buten\M2E\Api\Data\M2eOrdersInterfaceFactory;
use Buten\M2E\Api\Data\M2eOrdersSearchResultsInterfaceFactory;
use Buten\M2E\Api\M2eOrdersRepositoryInterface;
use Buten\M2E\Model\ResourceModel\M2eOrders as ResourceM2eOrders;
use Buten\M2E\Model\ResourceModel\M2eOrders\CollectionFactory as M2eOrdersCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class M2eOrdersRepository implements M2eOrdersRepositoryInterface
{

    /**
     * @var M2eOrdersCollectionFactory
     */
    protected $m2eOrdersCollectionFactory;

    /**
     * @var M2eOrdersInterfaceFactory
     */
    protected $m2eOrdersFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var M2eOrders
     */
    protected $searchResultsFactory;

    /**
     * @var ResourceM2eOrders
     */
    protected $resource;


    /**
     * @param ResourceM2eOrders $resource
     * @param M2eOrdersInterfaceFactory $m2eOrdersFactory
     * @param M2eOrdersCollectionFactory $m2eOrdersCollectionFactory
     * @param M2eOrdersSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceM2eOrders $resource,
        M2eOrdersInterfaceFactory $m2eOrdersFactory,
        M2eOrdersCollectionFactory $m2eOrdersCollectionFactory,
        M2eOrdersSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->m2eOrdersFactory = $m2eOrdersFactory;
        $this->m2eOrdersCollectionFactory = $m2eOrdersCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(M2eOrdersInterface $m2eOrders)
    {
        try {
            $this->resource->save($m2eOrders);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the m2eOrders: %1',
                $exception->getMessage()
            ));
        }
        return $m2eOrders;
    }

    /**
     * @inheritDoc
     */
    public function get($m2eOrdersId)
    {
        $m2eOrders = $this->m2eOrdersFactory->create();
        $this->resource->load($m2eOrders, $m2eOrdersId);
        if (!$m2eOrders->getM2eOrdersId()) {
            throw new NoSuchEntityException(__('m2e_orders with id "%1" does not exist.', $m2eOrdersId));
        }
        return $m2eOrders;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->m2eOrdersCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(M2eOrdersInterface $m2eOrders)
    {
        try {
            $m2eOrdersModel = $this->m2eOrdersFactory->create();
            $this->resource->load($m2eOrdersModel, $m2eOrders->getM2eOrdersId());
            $this->resource->delete($m2eOrdersModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the m2e_orders: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($m2eOrdersId)
    {
        return $this->delete($this->get($m2eOrdersId));
    }
}

