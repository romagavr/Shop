<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 11/16/18
 * Time: 6:59 PM
 */

namespace shop\readModels\Shop;


use shop\entities\Shop\Category;
use yii\helpers\ArrayHelper;

class CategoryReadRepository
{
    public function getAll(): array
    {
        return Category::find()->orderBy('sort')->all();
    }

    public function getRoot()
    {
        return Category::find()->roots()->one();
    }

    public function find($id): Category
    {
        return Category::find()->andWhere(['id' => $id])->andWhere(['>', 'depth', 0])->one();
    }


    public function findBySlug($slug): Category
    {
        return Category::find()->andWhere(['slug' => $slug])->andWhere(['>', 'depth', 0])->one();
    }

    public function getTreeWithSubsOf(Category $category = null): array
    {
        $query = Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft');

        if ($category) {
            $criteria = ['or', ['depth' => 1]];
            foreach (ArrayHelper::merge([$category], $category->parents) as $item) {
                $criteria[] = ['and', ['>', 'lft', $item->lft], ['<', 'rgt', $item->rgt], ['depth' => $item->depth + 1]];
            }
            $query->andWhere($criteria);
        } else {
            $query->andWhere(['depth' => 1]);
        }

        return $query->all();
    }
}