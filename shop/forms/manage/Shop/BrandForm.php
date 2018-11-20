<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/17/18
 * Time: 11:42 PM
 */

namespace shop\forms\manage\Shop;


use shop\forms\CompositeForm;
use shop\forms\manage\MetaForm;
use shop\entities\Shop\Brand;
use shop\validators\SlugValidator;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class BrandForm
 * @package shop\forms\manage\Shop
 * @property MetaForm $meta;
 */

class BrandForm extends CompositeForm
{
    public $name;
    public $slug;

    private $_brand;

    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand)
        {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->_brand = $brand;
            $this->meta =  new MetaForm($brand->meta);
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id',  $this->_brand->id] : null],
        ];
    }

    public function internalForms(): array
    {
        return ['meta'];
    }

}