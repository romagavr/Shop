<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/19/18
 * Time: 1:10 AM
 */

namespace shop\validators;

use yii\validators\RegularExpressionValidator;

class SlugValidator extends RegularExpressionValidator
{
    public $pattern = '#^[a-z0-9_-]*$#s';
    public $message = 'Only [a-z0-9_-] symbols are allowed.';
}