<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/18/18
 * Time: 1:04 AM
 */

namespace shop\forms;


use BaconQrCode\Common\Mode;
use yii\base\Model;
use yii\helpers\ArrayHelper;

abstract class CompositeForm extends Model
{
    /**
     * @var Model[]
     */
    private $forms = [];

    abstract protected function internalForms(): array;

//    private function loadInternal(array $data, Model $form, $formName, $name): bool
//    {
//        return $form->load($data, $formName ? null : $name);
//    }

    public function load($data, $formName = null): bool
    {
        $success = parent::load($data, $formName);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $success = Model::loadMultiple($form, $data, $formName === null ? null : $name) && $success;
            } else {
                $success = $form->load($data, $formName !== '' ? null : $name) && $success;
            }
        }
        return $success;
    }

    public function validate($attributeNames = null, $clearErrors = null)
    {
        $parentNames = $attributeNames !== null ? array_filter((array)$attributeNames, 'is_string') : null;
        $success = parent::validate($parentNames, $clearErrors);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $success = Model::validateMultiple($form) && $success;
            } else {
                $innerNames = $attributeNames !== null ? ArrayHelper::getValue($attributeNames, $name) : null;
                $success = $form->validate($innerNames ?: null, $clearErrors) && $success;
            }
        }
        return $success;
    }

    public function __get($name)
    {
        if (isset($this->forms[$name])) {
            return $this->forms[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->internalForms(), true)) {
            $this->forms[$name] = $value;
        } else {
            return parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        return isset($this->forms[$name]) || parent::__isset($name);
    }

}