<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/19/18
 * Time: 9:14 PM
 */

namespace shop\services\manage\Shop;


use shop\entities\Shop\Characteristic;
use shop\forms\manage\Shop\CharacteristicForm;
use shop\repositories\Shop\CharacteristicRepository;

class CharacteristicManageService
{
    private $characteristics;

    public function __construct(CharacteristicRepository $characteristics)
    {
        $this->characteristics = $characteristics;
    }

    public function create(CharacteristicForm $form): Characteristic
    {
        $characteristic = Characteristic::create(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
        );
        $this->characteristics->save($characteristic);
        return $characteristic;
    }

    public function edit($id, CharacteristicForm $form)
    {
        $characteristic = $this->characteristics->get($id);
        $characteristic->edit(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
        );
        $this->characteristics->save($characteristic);
    }

    public function remove($id)
    {
        $characteristic = $this->characteristics->get($id);
        $this->characteristics->remove($characteristic);
    }
}