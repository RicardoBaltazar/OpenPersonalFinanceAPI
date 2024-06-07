<?php

namespace App\Actions\Category;

use App\Models\Category;

class ListCategories
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function execute()
    {
        return $this->category->all('name');
    }
}
