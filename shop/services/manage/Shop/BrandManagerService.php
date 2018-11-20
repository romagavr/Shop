<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/18/18
 * Time: 4:31 PM
 */

namespace shop\services\manage\Shop;


use shop\entities\Meta;
use shop\entities\Shop\Brand;
use shop\forms\manage\Shop\BrandForm;
use shop\repositories\Shop\BrandRepository;
use shop\repositories\Shop\ProductRepository;

class BrandManagerService
{
    public $brands;
    public $products;

    public function __construct(BrandRepository $brands, ProductRepository $product)
    {
        $this->brands = $brands;
        $this->products = $product;
    }

    public function create(BrandForm $form): Brand
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brands->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form)
    {
        $brand = $this->brands->get($id);
        $brand->edit(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brands->save($brand);
    }

    public function remove($id)
    {
        $brand = $this->brands->get($id);
        if ($this->products->existsByBrand($brand->id)) {
            throw new \DomainException('Unable to remove brand with products.');
        }
        $this->brands->remove($brand);
    }
}