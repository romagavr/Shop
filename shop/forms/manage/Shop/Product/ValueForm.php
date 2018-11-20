<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/19/18
 * Time: 10:46 PM
 */

namespace shop\forms\manage\Shop\Product;

use shop\entities\Shop\Product\Value;
use shop\entities\Shop\Characteristic;
use yii\base\Model;

/**
 * Class ValueForm
 * @package shop\forms\manage\Shop\Product
 * @property integer $id
 */

class ValueForm extends Model
{
    public $value;
    private $_characteristic;

    public function __construct(Characteristic $characteristic, Value $value = null, array $config = [])
    {
        if ($value) {
            $this->value = $value->value;
        }
        $this->_characteristic = $characteristic;
        parent::__construct($config);
    }

    public function rules():array
    {
        return array_filter([
            $this->_characteristic->required ? ['value', 'required'] : false,
            $this->_characteristic->isString() ? ['value', 'string', 'max' => 255] : false,
            $this->_characteristic->isInteger() ? ['value', 'integer'] : false,
            $this->_characteristic->isFloat() ? ['value', 'number'] : false,
            ['value', 'safe'],
        ]);
    }


    public function variantsList(): array
    {
        return $this->_characteristic->variants ? array_combine($this->_characteristic->variants, $this->_characteristic->variants) : [];
    }


    public function attributeLabels(): array
    {
        return [
            'value' => $this->_characteristic->name,
        ];
    }

    public function getId(): int
    {
        return $this->_characteristic->id;
    }
}