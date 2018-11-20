<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/16/18
 * Time: 1:35 AM
 */

namespace shop\services\manage\Shop;

use shop\entities\Shop\Tag;
use shop\forms\manage\Shop\TagForm;
use shop\repositories\Shop\TagRepository;

class TagManageService
{
    private $tags;

    public function __construct(TagRepository $tag)
    {
        $this->tags = $tag;
    }

    public function create(TagForm $form): Tag
    {
        $tag = Tag::create(
            $form->name,
            $form->slug
        );
        $this->tags->save($tag);
        return $tag;
    }

    public function edit($id, TagForm $form)
    {
        $tag = $this->tags->get($id);
        $tag->edit(
            $form->name,
            $form->slug
        );
        $this->tags->save($tag);
    }

    public function remove($id)
    {
        $tag = $this->tags->get($id);
        $this->tags->remove($tag);
    }
}