<?php

namespace TheITNerd\EAV\Model;


/**
 * Class EntityUseDefault
 * @package TheITNerd\EAV\Model
 */
class EntityUseDefault
{

    /**
     * Apply the changes to the model based on the given data.
     *
     * @param AbstractModel $model The model to apply the changes to.
     * @param array $data The data containing the changes to be applied.
     * @return void
     */
    public function apply(AbstractModel $model, array $data) {
        if (isset($data['use_default']) && !empty($data['use_default'])) {
            foreach ($data['use_default'] as $attributeCode => $attributeValue) {
                if ($attributeValue) {
                    $model->setData($attributeCode, null);
                }
            }
        }
    }
}
