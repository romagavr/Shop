<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/16/18
 * Time: 5:19 PM
 */

namespace shop\entities\Shop;


use shop\entities\behaviors\MetaBehavior;
use yii\db\ActiveRecord;
use shop\entities\Meta;
use yii\helpers\Json;

/**
 * Class Brand
 * @package shop\entities\Shop
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Meta $meta
 */

class Brand extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, Meta $meta): self
    {
        $brand = new static();
        $brand->name = $name;
        $brand->slug = $slug;
        $brand->meta = $meta;
        return $brand;
    }

    public function edit($name, $slug, Meta $meta)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->meta = $meta;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title;
    }

    public static function tableName()
    {
        return '{{%shop_brands}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
        ];
    }
}