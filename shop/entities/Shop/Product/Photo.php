<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/29/18
 * Time: 6:10 PM
 */

namespace shop\entities\Shop\Product;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;
use Yii;

Yii::setAlias('@static', 'http://static.shop.dev:9999');
Yii::setAlias('@staticRoot', dirname(__DIR__) . '/../static');

/**
 * Class Photo
 * @package shop\entities\Shop\Product
 * @property integer $id
 * @property string $file
 * @property integer $sort
 *
 * @mixin ImageUploadBehavior
 */

class Photo extends ActiveRecord
{
    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%shop_photos}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                ],
            ],
        ];
    }

}