<?php

namespace TheITNerd\SizeGuide\Model\SizeGuide;


use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Category\FileInfo;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use TheItNerd\SizeGuide\Model\SizeGuide;

/**
 * Class Image
 * @package TheITNerd\SizeGuide\Model\SizeGuide
 */
class Image
{
    private const ATTRIBUTE_NAME = 'image';

    /**
     * Initialize dependencies.
     *
     * @param FileInfo $fileInfo
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private readonly FileInfo              $fileInfo,
        private readonly StoreManagerInterface $storeManager
    )
    {
    }

    /**
     * Resolve Size Guide image URL
     *
     * @param SizeGuide $sizeGuide
     * @param string $attributeCode
     * @return string
     * @throws LocalizedException
     */
    public function getUrl(SizeGuide $sizeGuide, string $attributeCode = self::ATTRIBUTE_NAME): string
    {
        $url = '';
        $image = $sizeGuide->getData($attributeCode);
        if ($image) {
            if (is_string($image)) {
                $store = $this->storeManager->getStore();
                $mediaBaseUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                if ($this->fileInfo->isBeginsWithMediaDirectoryPath($image)) {
                    $relativePath = $this->fileInfo->getRelativePathToMediaDirectory($image);
                    $url = rtrim($mediaBaseUrl, '/') . '/' . ltrim($relativePath, '/');
                } elseif (substr($image, 0, 1) !== '/') {
                    $url = rtrim($mediaBaseUrl, '/') . '/' . ltrim(FileInfo::ENTITY_MEDIA_PATH, '/') . '/' . $image;
                } else {
                    $url = $image;
                }
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}
