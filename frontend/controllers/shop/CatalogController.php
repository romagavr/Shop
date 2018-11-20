<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 11/16/18
 * Time: 5:42 PM
 */

namespace frontend\controllers\shop;

use shop\entities\Shop\Product\Product;
use shop\forms\shop\AddToCartForm;
use shop\forms\shop\ReviewForm;
use shop\readModels\Shop\BrandReadRepository;
use shop\readModels\Shop\CategoryReadRepository;
use shop\readModels\Shop\ProductReadRepository;
use shop\readModels\Shop\TagReadRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use shop\forms\shop\Search\SearchForm;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    private $products;
    private $categories;
    private $brands;
    private $tags;

    public function __construct($id,  $module,
                                ProductReadRepository $products,
                                CategoryReadRepository $categories,
                                BrandReadRepository $brands,
                                TagReadRepository $tags, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->products = $products;
        $this->categories = $categories;
        $this->brands = $brands;
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->products->getAll();
        $category = $this->categories->getRoot();

        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCategory($id)
    {
        if (!$category = $this->categories->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $this->products->getAllByCategory($category);

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionBrand($id)
    {
        if (!$brand = $this->brands->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $this->products->getAllByCategory($brand);

        return $this->render('brand', [
            'brand' => $brand,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionTag($id)
    {
        if (!$tag = $this->tags->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $this->products->getAllByCategory($tag);

        return $this->render('tag', [
            'tag' => $tag,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionSearch()
    {
        $form = new SearchForm();
        $form->load(\Yii::$app->request->queryParams);
        $form->validate();

        $dataProvider = $this->products->search($form);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchForm' => $form,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionProduct($id)
    {
        if (!$product = $this->products->find($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->layout = 'blank';

        $orderForm = new AddToCartForm($product);
        $reviewForm = new ReviewForm();

        return $this->render('product', [
            'product' => $product,
            'orderForm' => $orderForm,
            'reviewForm' => $reviewForm,
        ]);
    }
}