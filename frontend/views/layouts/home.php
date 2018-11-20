<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\widgets\FeaturedProductsWidget;
use \frontend\assets\OwlCarouselAsset;

OwlCarouselAsset::register($this);
?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <div id="content" class="col-sm-12">
        <div id="slideshow0" class="owl-carousel owl-theme" style="opacity: 1;">
            <div class="item">
                <a href="index.php?route=product/product&amp;path=57&amp;product_id=49"><img
                            src="http://static.shop.dev:9999/cache/banners/iPhone6.jpg"
                            alt="iPhone 6" class="img-responsive"/></a>
            </div>
            <div class="item">
                <img src="http://static.shop.dev:9999/cache/banners/MacBookAir.jpg"
                     alt="MacBookAir" class="img-responsive"/>
            </div>
        </div>
        <h3>Featured</h3>
        <?= FeaturedProductsWidget::widget([
                'limit' => 4,
        ])?>


        <div id="carousel0" class="owl-carousel owl-theme">
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/nfl.png" alt="NFL"
                     class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/redbull.png"
                     alt="RedBull" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/sony.png" alt="Sony"
                     class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/cocacola.png"
                     alt="Coca Cola" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/burgerking.png"
                     alt="Burger King" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/canon.png" alt="Canon"
                     class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/harley.png"
                     alt="Harley Davidson" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/dell.png" alt="Dell"
                     class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/disney.png"
                     alt="Disney" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/starbucks.png"
                     alt="Starbucks" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="http://static.shop.dev:9999/cache/manufacturers/nintendo.png"
                     alt="Nintendo" class="img-responsive"/>
            </div>
        </div>
        <?= $content ?>
    </div>
</div>

<?php $this->registerJs('
$(\'#slideshow0\').owlCarousel({
    items: 1,
    loop: true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    nav: true,
    navText: [\'<i class="fa fa-chevron-left fa-5x"></i>\', \'<i class="fa fa-chevron-right fa-5x"></i>\'],
    dots: true
});') ?>

<?php $this->registerJs('
$(\'#carousel0\').owlCarousel({
    items: 6,
    loop: true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    nav: true,
    navText: [\'<i class="fa fa-chevron-left fa-5x"></i>\', \'<i class="fa fa-chevron-right fa-5x"></i>\'],
    dots: true
});') ?>

<?php $this->endContent() ?>