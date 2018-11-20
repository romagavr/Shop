<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 11/16/18
 * Time: 6:59 PM
 */

namespace shop\readModels\Shop;


use shop\entities\Shop\Brand;

class BrandReadRepository
{
    public function find($id)
    {
        return Brand::findOne($id);
    }

}