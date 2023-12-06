<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model\SizeGuide;

use Magento\Catalog\Model\Category\FileInfo;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide\CollectionFactory;
use TheItNerd\SizeGuide\Model\SizeGuide;

class DataProvider extends AbstractDataProvider
{

    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param RequestInterface $request
     * @param FileInfo $fileInfo
     * @param Image $sizeGuideImage
     * @param PoolInterface $pool
     * @param array $meta
     * @param array $data
     * @throws LocalizedException
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        protected readonly RequestInterface $request,
        protected readonly FileInfo $fileInfo,
        protected readonly Image $sizeGuideImage,
        protected readonly PoolInterface $pool,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->collection->addAttributeToSelect('*');

        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $storeId = (int)$this->request->getParam('store');
        $this->collection->setStoreId($storeId);
        $items = $this->collection->getItems();

        foreach ($items as $model) {
            $model->setStoreId($storeId);
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('theitnerd_sizeguide_sizeguide');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('theitnerd_sizeguide_sizeguide');
        } else if(!$this->loadedData || count($this->loadedData) === 0) {
            return [];
        }
        return $this->prepareData($model, $this->loadedData);
    }

    private function prepareData(SizeGuide $model, $loadedData)
    {
        foreach ($model->getAttributes() as $attributeCode => $attribute) {
            if ($attribute->getBackend() instanceof \TheITNerd\SizeGuide\Model\SizeGuide\Attribute\Backend\Image) {
                unset($loadedData[$model->getId()][$attributeCode]);

                $fileName = $model->getData($attributeCode);

                if ($fileName && $this->fileInfo->isExist($fileName)) {
                    $stat = $this->fileInfo->getStat($fileName);
                    $mime = $this->fileInfo->getMimeType($fileName);

                    // phpcs:ignore Magento2.Functions.DiscouragedFunction
                    $loadedData[$model->getId()][$attributeCode][0]['name'] = basename($fileName);

                    $loadedData[$model->getId()][$attributeCode][0]['url'] = $this->sizeGuideImage->getUrl($model, $attributeCode);

                    $loadedData[$model->getId()][$attributeCode][0]['size'] = $stat['size'];
                    $loadedData[$model->getId()][$attributeCode][0]['type'] = $mime;
                }
            }
        }
        return $loadedData;
    }

    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }
}
