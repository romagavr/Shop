<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/20/18
 * Time: 7:30 PM
 */

namespace shop\entities\Shop\Product;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use shop\entities\Shop\Brand;
use shop\entities\Shop\Category;
use shop\entities\Shop\Product\queries\ProductQuery;
use shop\entities\Shop\Tag;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Product
 * @package shop\entities\Shop\Product
 * @property integer $id
 * @property integer $created_at
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $category_id
 * @property integer $brand_id
 * @property integer $price_old
 * @property integer $price_new
 * @property integer $rating
 * @property integer $status
 *
 * @property Meta $meta
 * @property Brand $brand
 * @property Category $category
 * @property Category[] $categories
 * @property CategoryAssignment[] $categoryAssignments
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 * @property RelatedAssignment[] $relatedAssignments
 * @property Modification[] $modifications
 * @property Value[] $values
 * @property Photo[] $photos
 * @property Photo $mainPhoto
 * @property Review[] $reviews
 */

class Product extends ActiveRecord
{
    public $meta;

    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($brandId, $categoryId, $code, $description, $name, Meta $meta): self
    {
        $product = new static();
        $product->brand_id = $brandId;
        $product->category_id = $categoryId;
        $product->code = $code;
        $product->name = $name;
        $product->meta = $meta;
        $product->status = self::STATUS_DRAFT;
        $product->description = $description;
        $product->created_at = time();
        return $product;
    }

    public function activate()
    {
        if ($this->isActive()){
            throw new \DomainException('Product is already activate.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()){
            throw new \DomainException('Product is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function setPrice($new, $old)
    {
        $this->price_new = $new;
        $this->price_old = $old;
    }

    public function edit($brandId, $code, $name, $description, Meta $meta)
    {
        $this->brand_id = $brandId;
        $this->code = $code;
        $this->name = $name;
        $this->meta = $meta;
        $this->description = $description;
    }

    public function setValue($id, $value)
    {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                return;
            }
        }
        $values[] = Value::create($id, $value);
        $this->values = $values;
    }

    public function getValue($id): Value
    {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                return $val;
            }
        }
        return Value::blank($id);
    }

    public function getModification($id): Modification
    {
        foreach ($this->modifications as $modification) {
            if ($modification->isIdEqualTo($id)) {
                return $modification;
            }
        }
        throw new \DomainException('Modification is not found.');
    }


    public function addModification($code, $name, $price)
    {
        $modifications = $this->modifications;
        foreach ($modifications as $modification) {
            if ($modification->isCodeEqualTo($code)) {
                throw new \DomainException('Modification already exists.');
            }
        }
        $modifications[] = Modification::create($code, $name, $price);
        $this->modifications = $modifications;
    }

    public function editModification($id, $code, $name, $price)
    {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification) {
            if ($modification->isIdEqualTo($id)) {
                $modification->edit($code, $name, $price);
                $this->modifications = $modifications;
                return;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    public function removeModification($id): void
    {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification) {
            if ($modification->isIdEqualTo($id)) {
                unset($modifications[$i]);
                return;
            }
        }
        throw new \DomainException('Modification is not found.');
    }


    public function changeMainCategory($categoryId)
    {
        $this->category_id = $categoryId;
    }

    public function assignCategory($id)
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForCategory($id)) {
                return;
            }
        }
        $assignment[] = CategoryAssignment::create($id);
        $this->categoryAssignments = $assignment;
    }

    public function revokeCategory($id)
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForCategory($id)) {
                unset($assignments[$i]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeCategories()
    {
        $this->categoryAssignments = [];
    }

    public function assignRelatedProduct($id)
    {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForProduct($id)) {
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->relatedAssignments = $assignments;
    }

    public function revokeRelatedProduct($id)
    {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForProduct($id)) {
                unset($assignments[$i]);
                $this->relatedAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function addPhoto(UploadedFile $file)
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
    }

    public function removePhoto($id)
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function movePhotoUp($id)
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id) && $prev = $photos[$i - 1] ?? null) {
                $photos[$i] = $prev;
                $photos[$i-1] = $photo;
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function movePhotoDown($id)
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id) && $next = $photos[$i + 1] ?? null) {
                $photos[$i] = $next;
                $photos[$i+1] = $photo;
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function removePhotos()
    {
        $this->updatePhotos([]);
    }

    private function updatePhotos(array $photos)
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    public function assignTag($id)
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id)
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function addReview($userId, $vote, $text)
    {
        $reviews = $this->reviews;
        $reviews[] = Review::create($userId, $vote, $text);
        $this->updateReviews($reviews);
    }

    public function editReview($id, $vote, $text)
    {
        $this->doWithReview($id, function (Review $review) use ($vote, $text) {
            $review->edit($vote, $text);
        });
    }

    public function activateReview($id)
    {
        $this->doWithReview($id, function (Review $review) {
            $review->activate();
        });
    }

    public function draftReview($id)
    {
        $this->doWithReview($id, function (Review $review) {
            $review->draft();
        });
    }

    private function doWithReview($id, callable $callback)
    {
        $reviews = $this->reviews;
        foreach ($reviews as $review) {
            if ($review->isIdEqualTo($id)) {
                $callback($review);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    public function removeReview($id)
    {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                unset($reviews[$i]);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    private function updateReviews(array $reviews)
    {
        $amount = 0;
        $total = 0;

        foreach ($reviews as $review) {
            if ($review->isActive()) {
                $amount++;
                $total += $review->getRating();
            }
        }

        $this->reviews = $reviews;
        $this->rating = $amount ? $total / $amount : null;
    }

    public function revokeTags()
    {
        $this->tagAssignments = [];
    }

    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getValues(): ActiveQuery
    {
        return $this->hasMany(Value::class, ['product_id' => 'id']);
    }

    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['product_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id'])->orderBy('sort');
    }
    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['product_id' => 'id']);
    }
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    public function getModifications(): ActiveQuery
    {
        return $this->hasMany(Modification::class, ['product_id' => 'id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssignments');
    }

    public static function tableName(): string
    {
        return '{{%shop_products}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['categoryAssignments', 'values', 'photos',
                    'tagAssignments', 'relatedAssignments', 'modifications'],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->photos as $photo) {
                $photo->delete();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }

}