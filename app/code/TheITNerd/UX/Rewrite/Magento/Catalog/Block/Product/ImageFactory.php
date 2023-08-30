<?php

namespace TheITNerd\UX\Rewrite\Magento\Catalog\Block\Product;


use Magento\Catalog\Block\Product\Image as ImageBlock;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Gallery\ReadHandler;
use Magento\Catalog\Model\Product\Image\ParamsBuilder;
use Magento\Catalog\Model\View\Asset\ImageFactory as AssetImageFactory;
use Magento\Catalog\Model\View\Asset\PlaceholderFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\ConfigInterface;

/**
 * Class ImageFactory
 * @package TheITNerd\UX\Rewrite\Magento\Catalog\Block\Product
 */
class ImageFactory extends \Magento\Catalog\Block\Product\ImageFactory
{
    /**
     * @var ConfigInterface
     */
    protected $presentationConfig;

    /**
     * @var AssetImageFactory
     */
    protected $viewAssetImageFactory;

    /**
     * @var ParamsBuilder
     */
    protected $imageParamsBuilder;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var PlaceholderFactory
     */
    protected $viewAssetPlaceholderFactory;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param ConfigInterface $presentationConfig
     * @param AssetImageFactory $viewAssetImageFactory
     * @param PlaceholderFactory $viewAssetPlaceholderFactory
     * @param ParamsBuilder $imageParamsBuilder
     * @param ReadHandler $galleryReadHandler
     */
    public function __construct(
        ObjectManagerInterface                                                $objectManager,
        ConfigInterface                                                       $presentationConfig,
        AssetImageFactory                                                     $viewAssetImageFactory,
        PlaceholderFactory                                                    $viewAssetPlaceholderFactory,
        ParamsBuilder                                                         $imageParamsBuilder,
        protected readonly ReadHandler $galleryReadHandler,
        protected readonly \TheITNerd\UX\Helper\Product                       $productHelper
    )
    {
        $this->objectManager = $objectManager;
        $this->presentationConfig = $presentationConfig;
        $this->viewAssetPlaceholderFactory = $viewAssetPlaceholderFactory;
        $this->viewAssetImageFactory = $viewAssetImageFactory;
        $this->imageParamsBuilder = $imageParamsBuilder;

        parent::__construct($objectManager, $presentationConfig, $viewAssetImageFactory, $viewAssetPlaceholderFactory, $imageParamsBuilder);
    }

    /**
     * @param Product $product
     * @param string $imageId
     * @param array|null $attributes
     * @return ImageBlock
     * @throws LocalizedException
     */
    public function create(Product $product, string $imageId, array $attributes = null): ImageBlock
    {

        if (!$this->productHelper->canShowPLPSecondImage()) {
            return parent::create($product, $imageId, $attributes);
        }

        $viewImageConfig = $this->presentationConfig->getViewConfig()->getMediaAttributes(
            'Magento_Catalog',
            ImageHelper::MEDIA_TYPE_CONFIG_NODE,
            $imageId
        );

        $secondViewImageConfig = $viewImageConfig;

        if ($secondViewImageConfig['type'] === 'small_image') {
            $secondViewImageConfig['type'] = 'thumbnail';
        }

        $imageMiscParams = $this->imageParamsBuilder->build($viewImageConfig);
        $originalFilePath = $product->getData($imageMiscParams['image_type']);

        $secondImageMiscParams = $this->imageParamsBuilder->build($secondViewImageConfig);

        $imageAsset = [];

        if ($originalFilePath === null || $originalFilePath === 'no_selection') {
            $imageAsset[] = $this->viewAssetPlaceholderFactory->create(
                [
                    'type' => $imageMiscParams['image_type']
                ]
            );
        } else {
            $imageAsset[] = $this->viewAssetImageFactory->create(
                [
                    'miscParams' => $imageMiscParams,
                    'filePath' => $originalFilePath,
                ]
            );

            $images = $this->galleryReadHandler->execute($product);

            if (isset($images->getMediaGallery()['images'])) {
                foreach ($images->getMediaGallery()['images'] as $image) {
                    if ($image['file'] === $originalFilePath) {
                        continue;
                    }

                    $secondOriginalFilePath = $image['file'];
                    break;
                }

                $imageAsset[] = $this->viewAssetImageFactory->create(
                    [
                        'miscParams' => $secondImageMiscParams,
                        'filePath' => $secondOriginalFilePath,
                    ]
                );
            }
        }

        $attributes = $attributes === null ? [] : $attributes;

        $data = [
            'data' => [
                'template' => 'TheITNerd_UX::Magento/Catalog/product/image_with_borders.phtml',
                'image_url' => $imageAsset[0]->getUrl(),
                'second_image_url' => (isset($imageAsset[1])) ? $imageAsset[1]->getUrl() : $imageAsset[0]->getUrl(),
                'width' => $imageMiscParams['image_width'],
                'height' => $imageMiscParams['image_height'],
                'label' => $this->getLabel($product, $imageMiscParams['image_type'] ?? ''),
                'ratio' => $this->getRatio($imageMiscParams['image_width'] ?? 0, $imageMiscParams['image_height'] ?? 0),
                'custom_attributes' => $this->filterCustomAttributes($attributes),
                'class' => $this->getClass($attributes),
                'product_id' => $product->getId()
            ],
        ];

        return $this->objectManager->create(ImageBlock::class, $data);
    }

    /**
     * Get image label
     *
     * @param Product $product
     * @param string $imageType
     * @return string
     */
    protected function getLabel(Product $product, string $imageType): string
    {
        $label = $product->getData($imageType . '_' . 'label');
        if (empty($label)) {
            $label = $product->getName();
        }
        return (string)$label;
    }

    /**
     * Calculate image ratio
     *
     * @param int $width
     * @param int $height
     * @return float
     */
    protected function getRatio(int $width, int $height): float
    {
        if ($width && $height) {
            return $height / $width;
        }
        return 1.0;
    }

    /**
     * Remove class from custom attributes
     *
     * @param array $attributes
     * @return array
     */
    protected function filterCustomAttributes(array $attributes): array
    {
        if (isset($attributes['class'])) {
            unset($attributes['class']);
        }
        return $attributes;
    }

    /**
     * Retrieve image class for HTML element
     *
     * @param array $attributes
     * @return string
     */
    protected function getClass(array $attributes): string
    {
        return $attributes['class'] ?? 'product-image-photo';
    }
}
