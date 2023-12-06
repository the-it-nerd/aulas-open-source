<?php

namespace TheITNerd\EAV\Ui\DataProvider\Form\Modifier;


use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Api\ProductAttributeGroupRepositoryInterface;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Catalog\Model\Attribute\ScopeOverriddenValue;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as EavAttribute;
use Magento\Catalog\Model\ResourceModel\Eav\AttributeFactory as EavAttributeFactory;
use Magento\Catalog\Ui\DataProvider\CatalogEavValidationRules;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Eav\CompositeConfigProcessor;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeGroupInterface;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory as AttributeCollectionFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory as GroupCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filter\Translit;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Form\Element\Wysiwyg as WysiwygElement;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\DataProvider\Mapper\FormElement as FormElementMapper;
use Magento\Ui\DataProvider\Mapper\MetaProperties as MetaPropertiesMapper;

/**
 * Class Eav data provider for product editing form
 *
 * @api
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @since 101.0.0
 */
class Eav extends AbstractModifier
{

    public const SORT_ORDER_MULTIPLIER = 10;

    /**
     * @var LocatorInterface
     * @since 101.0.0
     */
    protected $locator;

    /**
     * @var Config
     * @since 101.0.0
     */
    protected $eavConfig;

    /**
     * @var CatalogEavValidationRules
     * @since 101.0.0
     */
    protected $catalogEavValidationRules;

    /**
     * @var RequestInterface
     * @since 101.0.0
     */
    protected $request;

    /**
     * @var GroupCollectionFactory
     * @since 101.0.0
     */
    protected $groupCollectionFactory;

    /**
     * @var StoreManagerInterface
     * @since 101.0.0
     */
    protected $storeManager;

    /**
     * @var FormElementMapper
     * @since 101.0.0
     */
    protected $formElementMapper;

    /**
     * @var MetaPropertiesMapper
     * @since 101.0.0
     */
    protected $metaPropertiesMapper;

    /**
     * @var ProductAttributeGroupRepositoryInterface
     * @since 101.0.0
     */
    protected $attributeGroupRepository;

    /**
     * @var SearchCriteriaBuilder
     * @since 101.0.0
     */
    protected $searchCriteriaBuilder;

    /**
     * @var ProductAttributeRepositoryInterface
     * @since 101.0.0
     */
    protected $attributeRepository;

    /**
     * @var SortOrderBuilder
     * @since 101.0.0
     */
    protected $sortOrderBuilder;

    /**
     * @var EavAttributeFactory
     * @since 101.0.0
     */
    protected $eavAttributeFactory;

    /**
     * @var Translit
     * @since 101.0.0
     */
    protected $translitFilter;

    /**
     * @var ArrayManager
     * @since 101.0.0
     */
    protected $arrayManager;
    /**
     * @var array
     * @since 101.0.0
     */
    protected $attributesToEliminate;
    /**
     * @var DataPersistorInterface
     * @since 101.0.0
     */
    protected $dataPersistor;
    /**
     * @var ScopeOverriddenValue
     */
    private $scopeOverriddenValue;
    /**
     * @var array
     */
    private $attributesToDisable;
    /**
     * @var EavAttribute[]
     */
    private $attributes = [];

    /**
     * @var AttributeGroupInterface[]
     */
    private $attributeGroups = [];

    /**
     * @var array
     */
    private $canDisplayUseDefault = [];

    /**
     * @var array
     */
    private $bannedInputTypes = ['media_image'];

    /**
     * @var array
     */
    private $prevSetAttributes;

    /**
     * @var array
     */
    private $attributesCache = [];

    /**
     * @var AttributeCollectionFactory
     */
    private $attributeCollectionFactory;

    /**
     * @var CompositeConfigProcessor
     */
    private $wysiwygConfigProcessor;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var AuthorizationInterface
     */
    private $auth;

    /**
     * Eav constructor.
     * @param LocatorInterface $locator
     * @param CatalogEavValidationRules $catalogEavValidationRules
     * @param Config $eavConfig
     * @param RequestInterface $request
     * @param GroupCollectionFactory $groupCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param FormElementMapper $formElementMapper
     * @param MetaPropertiesMapper $metaPropertiesMapper
     * @param ProductAttributeGroupRepositoryInterface $attributeGroupRepository
     * @param ProductAttributeRepositoryInterface $attributeRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param EavAttributeFactory $eavAttributeFactory
     * @param Translit $translitFilter
     * @param ArrayManager $arrayManager
     * @param ScopeOverriddenValue $scopeOverriddenValue
     * @param DataPersistorInterface $dataPersistor
     * @param array $attributesToDisable
     * @param array $attributesToEliminate
     * @param CompositeConfigProcessor|null $wysiwygConfigProcessor
     * @param ScopeConfigInterface|null $scopeConfig
     * @param AttributeCollectionFactory $attributeCollectionFactory
     * @param AuthorizationInterface|null $auth
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        LocatorInterface                         $locator,
        CatalogEavValidationRules                $catalogEavValidationRules,
        Config                                   $eavConfig,
        RequestInterface                         $request,
        GroupCollectionFactory                   $groupCollectionFactory,
        StoreManagerInterface                    $storeManager,
        FormElementMapper                        $formElementMapper,
        MetaPropertiesMapper                     $metaPropertiesMapper,
        ProductAttributeGroupRepositoryInterface $attributeGroupRepository,
        AttributeRepositoryInterface             $attributeRepository,
        SearchCriteriaBuilder                    $searchCriteriaBuilder,
        SortOrderBuilder                         $sortOrderBuilder,
        EavAttributeFactory                      $eavAttributeFactory,
        Translit                                 $translitFilter,
        ArrayManager                             $arrayManager,
        ScopeOverriddenValue                     $scopeOverriddenValue,
        DataPersistorInterface                   $dataPersistor,
        protected readonly Registry              $coreRegistry,
                                                 $attributesToDisable = [],
                                                 $attributesToEliminate = [],
        protected string                         $entityType = "",
        protected string                         $entityRegistry = "",
        protected string                         $entityCode = "",
        protected string                         $entityAttributeSource = "",
        CompositeConfigProcessor                 $wysiwygConfigProcessor = null,
        ScopeConfigInterface                     $scopeConfig = null,
        AttributeCollectionFactory               $attributeCollectionFactory = null,
        ?AuthorizationInterface                  $auth = null
    )
    {
        $this->locator = $locator;
        $this->catalogEavValidationRules = $catalogEavValidationRules;
        $this->eavConfig = $eavConfig;
        $this->request = $request;
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->storeManager = $storeManager;
        $this->formElementMapper = $formElementMapper;
        $this->metaPropertiesMapper = $metaPropertiesMapper;
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->attributeRepository = $attributeRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->eavAttributeFactory = $eavAttributeFactory;
        $this->translitFilter = $translitFilter;
        $this->arrayManager = $arrayManager;
        $this->scopeOverriddenValue = $scopeOverriddenValue;
        $this->dataPersistor = $dataPersistor;
        $this->attributesToDisable = $attributesToDisable;
        $this->attributesToEliminate = $attributesToEliminate;
        $this->wysiwygConfigProcessor = $wysiwygConfigProcessor
            ?: ObjectManager::getInstance()->get(CompositeConfigProcessor::class);
        $this->scopeConfig = $scopeConfig ?: ObjectManager::getInstance()->get(ScopeConfigInterface::class);
        $this->attributeCollectionFactory = $attributeCollectionFactory
            ?: ObjectManager::getInstance()->get(AttributeCollectionFactory::class);
        $this->auth = $auth ?? ObjectManager::getInstance()->get(AuthorizationInterface::class);
    }

    /**
     * @inheritdoc
     * @since 101.0.0
     */
    public function modifyMeta(array $meta)
    {

        $collection = $this->attributeCollectionFactory->create()
            ->setEntityTypeFilter($this->eavConfig->getEntityType($this->entityCode)->getId());

        $metas = [];
        foreach ($collection as $attribute) {

            if ($attribute->getAttributeCode() === "image") continue;
            $metas[$attribute->getAttributeCode()] = $this->setupAttributeMeta($this->attributeRepository->get($this->entityCode, $attribute->getAttributeCode()));
        }

        $meta['general'] = [
            "children" => $metas
        ];


        return $meta;
    }


    /**
     * Initial meta setup
     *
     * @param ProductAttributeInterface $attribute
     * @param string $groupCode
     * @param int $sortOrder
     * @return array
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function setupAttributeMeta(ProductAttributeInterface $attribute)
    {
        $configPath = ltrim(static::META_CONFIG_PATH, ArrayManager::DEFAULT_PATH_DELIMITER);
        $attributeCode = $attribute->getAttributeCode();
        $meta = $this->arrayManager->set(
            $configPath,
            [],
            [
                'dataType' => $attribute->getFrontendInput(),
                'formElement' => $this->getFormElementsMapValue($attribute->getFrontendInput()),
                'required' => $attribute->getIsRequired(),
                'notice' => $attribute->getNote() === null ? null : __($attribute->getNote()),
                'default' => (!$this->entityExists()) ? $this->getAttributeDefaultValue($attribute) : null,
                'label' => __($attribute->getDefaultFrontendLabel()),
                'code' => $attributeCode,
                'source' => $this->entityAttributeSource,
                'scopeLabel' => $this->getScopeLabel($attribute),
                'globalScope' => $this->isScopeGlobal($attribute),
            ]
        );


        $attributeModel = $this->getAttributeModel($attribute);
        if ($attributeModel->usesSource()) {
            $source = $attributeModel->getSource();
            $options = $source->getAllOptions(true, true);

            foreach ($options as &$option) {
                $option['__disableTmpl'] = true;
            }
            $meta = $this->arrayManager->merge(
                $configPath,
                $meta,
                ['options' => $this->convertOptionsValueToString($options)]
            );
        }

        if ($this->canDisplayUseDefault($attribute)) {
            $meta = $this->arrayManager->merge(
                $configPath,
                $meta,
                [
                    'service' => [
                        'template' => 'ui/form/element/helper/service',
                    ]
                ]
            );
        }

        if (!$this->arrayManager->exists($configPath . '/componentType', $meta)) {
            $meta = $this->arrayManager->merge($configPath, $meta, ['componentType' => Field::NAME]);
        }

        if (in_array($attributeCode, $this->attributesToDisable)) {
            $meta = $this->arrayManager->merge($configPath, $meta, ['disabled' => true]);
        }

        // TODO: getAttributeModel() should not be used when MAGETWO-48284 is complete
        $childData = $this->arrayManager->get($configPath, $meta, []);
        if ($rules = $this->catalogEavValidationRules->build($this->getAttributeModel($attribute), $childData)) {
            $meta = $this->arrayManager->merge($configPath, $meta, ['validation' => $rules]);
        }

        $meta = $this->addUseDefaultValueCheckbox($attribute, $meta);

        switch ($attribute->getFrontendInput()) {
            case 'boolean':
                $meta = $this->customizeCheckbox($attribute, $meta);
                break;
            case 'textarea':
                $meta = $this->customizeWysiwyg($attribute, $meta);
                break;
            case 'price':
                $meta = $this->customizePriceAttribute($attribute, $meta);
                break;
            case 'gallery':
                // Gallery attribute is being handled by "Images And Videos" section
                $meta = [];
                break;
            case 'datetime':
                $meta = $this->customizeDatetimeAttribute($meta);
                break;
        }

        return $meta;
    }

    /**
     * Retrieve form element
     *
     * @param string $value
     * @return mixed
     */
    private function getFormElementsMapValue($value)
    {
        $valueMap = $this->formElementMapper->getMappings();

        return $valueMap[$value] ?? $value;
    }

    /**
     * Check is product already new or we trying to create one
     *
     * @return bool
     */
    private function entityExists()
    {
        return $this->getEntity() && (bool)$this->getEntity()->getId();
    }

    private function getEntity()
    {
        return $this->coreRegistry->registry($this->entityRegistry);
    }

    /**
     * Returns attribute default value, based on db setting or setting in the system configuration.
     *
     * @param ProductAttributeInterface $attribute
     * @return null|string
     */
    private function getAttributeDefaultValue(ProductAttributeInterface $attribute)
    {
        if ($attribute->getAttributeCode() === 'page_layout') {
            $defaultValue = $this->scopeConfig->getValue(
                'web/default_layouts/default_product_layout',
                ScopeInterface::SCOPE_STORE,
                $this->storeManager->getStore()
            );
            if ($defaultValue !== null) {
                $attribute->setDefaultValue($defaultValue);
            }
        }
        return $attribute->getDefaultValue();
    }

    /**
     * Retrieve attribute value
     *
     * @param ProductAttributeInterface $attribute
     * @return mixed
     */
    private function getValue(ProductAttributeInterface $attribute)
    {
        /** @var Product $product */
        $product = $this->locator->getProduct();

        return $product->getData($attribute->getAttributeCode());
    }

    /**
     * Retrieve scope label
     *
     * @param ProductAttributeInterface $attribute
     * @return Phrase|string
     */
    private function getScopeLabel(ProductAttributeInterface $attribute)
    {
        if ($this->storeManager->isSingleStoreMode()
            || $attribute->getFrontendInput() === AttributeInterface::FRONTEND_INPUT
        ) {
            return '';
        }

        switch ($attribute->getScope()) {
            case ProductAttributeInterface::SCOPE_GLOBAL_TEXT:
                return __('[GLOBAL]');
            case ProductAttributeInterface::SCOPE_WEBSITE_TEXT:
                return __('[WEBSITE]');
            case ProductAttributeInterface::SCOPE_STORE_TEXT:
                return __('[STORE VIEW]');
        }

        return '';
    }

    /**
     * Check if attribute scope is global.
     *
     * @param ProductAttributeInterface $attribute
     * @return bool
     */
    private function isScopeGlobal($attribute)
    {
        return $attribute->getScope() === ProductAttributeInterface::SCOPE_GLOBAL_TEXT;
    }

    /**
     * Load attribute model by attribute data object.
     *
     * TODO: This method should be eliminated when all missing service methods are implemented
     *
     * @param ProductAttributeInterface $attribute
     * @return EavAttribute
     */
    private function getAttributeModel($attribute)
    {
        // The statement below solves performance issue related to loading same attribute options on different models
        if ($attribute instanceof EavAttribute) {
            return $attribute;
        }
        $attributeId = $attribute->getAttributeId();

        if (!array_key_exists($attributeId, $this->attributesCache)) {
            $this->attributesCache[$attributeId] = $this->eavAttributeFactory->create()->load($attributeId);
        }

        return $this->attributesCache[$attributeId];
    }

    /**
     * Convert options value to string.
     *
     * @param array $options
     * @return array
     */
    private function convertOptionsValueToString(array $options): array
    {
        array_walk(
            $options,
            function (&$value) {
                if (isset($value['value']) && is_scalar($value['value'])) {
                    $value['value'] = (string)$value['value'];
                }
            }
        );

        return $options;
    }

    /**
     * Whether attribute can have default value
     *
     * @param ProductAttributeInterface $attribute
     * @return bool
     */
    private function canDisplayUseDefault(ProductAttributeInterface $attribute)
    {
        $attributeCode = $attribute->getAttributeCode();
        $registry = $this->getEntity();


        if (isset($this->canDisplayUseDefault[$attributeCode])) {
            return $this->canDisplayUseDefault[$attributeCode];
        }

        return $this->canDisplayUseDefault[$attributeCode] = (
            ($attribute->getScope() != ProductAttributeInterface::SCOPE_GLOBAL_TEXT)
            && $registry
            && $registry->getId()
            && $registry->getStoreId()
        );
    }

    /**
     * Adds 'use default value' checkbox.
     *
     * @param ProductAttributeInterface $attribute
     * @param array $meta
     * @return array
     */
    private function addUseDefaultValueCheckbox(ProductAttributeInterface $attribute, array $meta)
    {
        $canDisplayService = $this->canDisplayUseDefault($attribute);
        if ($canDisplayService) {
            $meta['arguments']['data']['config']['service'] = [
                'template' => 'ui/form/element/helper/service',
            ];

            $meta['arguments']['data']['config']['disabled'] = !$this->scopeOverriddenValue->containsValue(
                $this->entityType,
                $this->getEntity(),
                $attribute->getAttributeCode(),
                $this->getEntity()->getStoreId()
            );
        }
        return $meta;
    }

    /**
     * Customize checkboxes
     *
     * @param ProductAttributeInterface $attribute
     * @param array $meta
     * @return array
     */
    private function customizeCheckbox(ProductAttributeInterface $attribute, array $meta)
    {
        if ($attribute->getFrontendInput() === 'boolean') {
            $meta['arguments']['data']['config']['prefer'] = 'toggle';
            $meta['arguments']['data']['config']['valueMap'] = [
                'true' => '1',
                'false' => '0',
            ];
        }

        return $meta;
    }

    /**
     * Add wysiwyg properties
     *
     * @param ProductAttributeInterface $attribute
     * @param array $meta
     * @return array
     */
    private function customizeWysiwyg(ProductAttributeInterface $attribute, array $meta)
    {
        if (!$attribute->getIsWysiwygEnabled()) {
            return $meta;
        }

        $meta['arguments']['data']['config']['formElement'] = WysiwygElement::NAME;
        $meta['arguments']['data']['config']['wysiwyg'] = true;
        $meta['arguments']['data']['config']['wysiwygConfigData'] = $this->wysiwygConfigProcessor->process($attribute);

        return $meta;
    }

    /**
     * Customize attribute that has price type
     *
     * @param ProductAttributeInterface $attribute
     * @param array $meta
     * @return array
     */
    private function customizePriceAttribute(ProductAttributeInterface $attribute, array $meta)
    {
        if ($attribute->getFrontendInput() === 'price') {
            $meta['arguments']['data']['config']['addbefore'] = $this->locator->getStore()
                ->getBaseCurrency()
                ->getCurrencySymbol();
        }

        return $meta;
    }

    /**
     * Customize datetime attribute
     *
     * @param array $meta
     * @return array
     */
    private function customizeDatetimeAttribute(array $meta): array
    {
        $meta['arguments']['data']['config']['options']['showsTime'] = 1;

        return $meta;
    }

    /**
     * @inheritdoc
     * @since 101.0.0
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Setup attribute data
     *
     * @param ProductAttributeInterface $attribute
     * @return mixed|null
     */
    public function setupAttributeData(ProductAttributeInterface $attribute)
    {
        $product = $this->locator->getProduct();
        $productId = $product->getId();
        $prevSetId = $this->getPreviousSetId();
        $notUsed = !$prevSetId
            || ($prevSetId && !in_array($attribute->getAttributeCode(), $this->getPreviousSetAttributes()));

        if ($productId && $notUsed) {
            return $this->getValue($attribute);
        }

        return null;
    }

    /**
     * Return prev set id
     *
     * @return int
     */
    private function getPreviousSetId()
    {
        return (int)$this->request->getParam('prev_set_id', 0);
    }

    /**
     * Get attribute codes of prev set
     *
     * @return array
     * @throws LocalizedException
     */
    private function getPreviousSetAttributes()
    {
        if ($this->prevSetAttributes === null) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('attribute_set_id', $this->getPreviousSetId())
                ->create();
            $attributes = $this->attributeRepository->getList($searchCriteria)->getItems();
            $this->prevSetAttributes = [];
            foreach ($attributes as $attribute) {
                $this->prevSetAttributes[] = $attribute->getAttributeCode();
            }
        }

        return $this->prevSetAttributes;
    }
}
