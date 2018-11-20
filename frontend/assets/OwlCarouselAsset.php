<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class OwlCarouselAsset extends AssetBundle
{
    public $sourcePath = '@bower/owl.carousel/dist';
    public $css = [
        'assets/owl.carousel.css',
        'assets/owl.theme.default.css',

    ];
    public $js = [
        'owl.carousel.js',
    ];
    public $cssOptions = [
        'media' => 'screen',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
