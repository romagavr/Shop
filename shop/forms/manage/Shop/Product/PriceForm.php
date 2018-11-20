<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/19/18
 * Time: 10:43 PM
 */

namespace shop\forms\manage\Shop\Product;


use shop\entities\Shop\Product\Product;
use shop\forms\manage\MetaForm;
use shop\forms\manage\Shop\TagForm;
use yii\base\Model;

/**
 * Class PriceForm
 * @package shop\forms\manage\Shop\Product
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property TagForm $tag
 * @property ValueForm[] $values
 */

class PriceForm extends Model
{
    public $old;
    public $new;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product) {
            $this->new = $product->price_new;
            $this->old = $product->price_old;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['new'], 'required'],
            [['old', 'new'], 'integer', 'min' => 0],
        ];
    }

}