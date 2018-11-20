<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/16/18
 * Time: 12:50 AM
 */

namespace shop\entities\Shop;

use yii\db\ActiveRecord;

/**
 * Class Tag
 * @property integer $id
 * @property string $name
 * @property string $slug
 */

class Tag extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    public function edit($name, $slug)
    {
        $this->slug = $slug;
        $this->name = $name;
    }

    public static function tableName()
    {
        return '{{%shop_tags}}';
    }

}