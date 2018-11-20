<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/30/18
 * Time: 7:38 PM
 */

namespace shop\forms\manage\Shop\Product;


use shop\entities\Shop\Product\Product;
use shop\entities\Shop\Characteristic;
use shop\forms\CompositeForm;
use shop\forms\manage\MetaForm;

/**
 * Class ProductEditForm
 * @package shop\forms\manage\Shop\Product
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 * @property ValueForm[] $values
 */

class ProductEditForm extends CompositeForm
{
    public $brandId;
    public $code;
    public $name;
    public $description;

    private $_product;

    public function __construct(Product $product, array $config = [])
    {
        $this->brandId = $product->brand_id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->meta = new MetaForm($product->meta);
        $this->tags = new TagsForm($product);
        $this->categories = new CategoriesForm($product);
        $this->values = array_map(function (Characteristic $characteristic) {
            return new ValueForm($characteristic, $this->_product->getValue($characteristic->id));
        }, Characteristic::find()->orderBy('sort')->all());
        $this->_product = $product;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['brandId', 'code', 'name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['brandId'], 'integer'],
            ['description', 'string'],
            [['code'], 'unique', 'targetClass' => Product::class],
        ];
    }

    public function internalForms(): array
    {
        return ['price', 'meta', 'photos', 'categories', 'tags', 'values'];
    }
}