<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/21/18
 * Time: 11:06 PM
 */

namespace shop\entities\Shop\Product;


use yii\db\ActiveRecord;

/**
 * @property integer $product_id
 * @property integer $category_id
 */

class CategoryAssignment extends ActiveRecord
{
    public static function create($categoryId): self
    {
        $assignment = new static();
        $assignment->category_id = $categoryId;
        return $assignment;
    }

    public function isForCategory($id): bool
    {
        return $this->category_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%shop_category_assignments}}';
    }

}