<?php

namespace App\Actions\Category;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Log;

class ListCategories
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function execute()
    {
        try {
            return $this->category->all('name');
        } catch (\Exception $th) {
            Log::error('Error fetching categories: ' . $th->getMessage());
            throw new Exception('Unable to list categories');
        }
    }
}
