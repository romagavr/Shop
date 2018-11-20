<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 11/16/18
 * Time: 7:00 PM
 */

namespace shop\readModels\Shop;


use shop\entities\Shop\Tag;

class TagReadRepository
{
    public function find($id)
    {
        return Tag::findOne($id);
    }
}