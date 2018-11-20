<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/19/18
 * Time: 5:32 PM
 */

namespace shop\repositories\Shop;


use BaconQrCode\Exception\RuntimeException;
use shop\entities\Shop\Category;
use shop\repositories\NotFoundException;

class CategoryRepository
{
    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new NotFoundException('Category is not found');
        }
        return $category;
    }

    public function save(Category $category)
    {
        if (!$category->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function remove(Category $category)
    {
        if (!$category->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }

}