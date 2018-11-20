<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/19/18
 * Time: 5:07 PM
 */

namespace shop\entities\Shop\queries;

use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;
}