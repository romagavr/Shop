<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/20/18
 * Time: 11:19 PM
 */

namespace shop\repositories\Shop;


use BaconQrCode\Exception\RuntimeException;
use shop\entities\Shop\Product\Product;
use shop\repositories\NotFoundException;

class ProductRepository
{
    public function get($id): Product
    {
        if (!$product = Product::findOne($id)) {
            throw new NotFoundException('Brand is not found');
        }
        return $product;
    }

    public function save(Product $product)
    {
        if (!$product->save()) {
            throw new RuntimeException('Saving Brand error');
        }
    }

    public function remove(Product $product)
    {
        if (!$product->delete()) {
            throw new RuntimeException('Deleting Brand error');
        }
    }

    public function existsByBrand($id)
    {
        return Product::find()->andWhere(['brand_id' => $id])->exists();
    }

    public function existsByMainCategory($id)
    {
        return Product::find()->andWhere(['category_id' => $id])->exists();
    }
}