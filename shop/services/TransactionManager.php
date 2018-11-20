<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/30/18
 * Time: 6:41 PM
 */

namespace shop\services;

use Yii;

class TransactionManager
{
    public function wrap(callable $function)
    {
        Yii::$app->db->transaction($function);
    }
}