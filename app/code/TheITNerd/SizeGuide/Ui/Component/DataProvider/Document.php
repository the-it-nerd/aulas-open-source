<?php

namespace TheITNerd\SizeGuide\Ui\Component\DataProvider;


/**
 * Class Document
 * @package TheITNerd\SizeGuide\Ui\Component\DataProvider
 */
class Document extends \Magento\Framework\View\Element\UiComponent\DataProvider\Document
{

    protected $_idFieldName = 'entity_id';

    public function getIdFieldName()
    {
        return $this->_idFieldName;
    }
}

