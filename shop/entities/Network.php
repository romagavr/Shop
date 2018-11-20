<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/6/18
 * Time: 12:56 AM
 */

namespace shop\entities;

use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

/**
 * @property integer $user_id
 * @property string $identity
 * @property string $network
 */

class Network extends ActiveRecord
{
    public static function create($network, $identity): self
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $item = new static();
        $item->network = $network;
        $item->identity = $identity;
        return $item;
    }

    public static function tableName()
    {
        return '{{%user_networks}}';
    }

}