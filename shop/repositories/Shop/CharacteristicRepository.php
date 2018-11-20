<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/19/18
 * Time: 9:12 PM
 */

namespace shop\repositories\Shop;


use BaconQrCode\Exception\RuntimeException;
use shop\entities\Shop\Characteristic;
use shop\repositories\NotFoundException;

class CharacteristicRepository
{
    public function get($id): Characteristic
    {
        if (!$category = Characteristic::findOne($id)) {
            throw new NotFoundException('Characteristic is not found');
        }
        return $category;
    }

    public function save(Characteristic $characteristic)
    {
        if (!$characteristic->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function remove(Characteristic $characteristic)
    {
        if (!$characteristic->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }
}