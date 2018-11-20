<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/18/18
 * Time: 4:41 PM
 */

namespace shop\repositories\Shop;


use BaconQrCode\Exception\RuntimeException;
use shop\entities\Shop\Brand;
use shop\repositories\NotFoundException;

class BrandRepository
{
    public function get($id): Brand
    {
        if (!$brand = Brand::findOne($id)) {
            throw new NotFoundException('Brand is not found');
        }
        return $brand;
    }

    public function save(Brand $brand)
    {
        if (!$brand->save()) {
            throw new RuntimeException('Saving Brand error');
        }
    }

    public function remove(Brand $brand)
    {
        if (!$brand->delete()) {
            throw new RuntimeException('Deleting Brand error');
        }
    }
}