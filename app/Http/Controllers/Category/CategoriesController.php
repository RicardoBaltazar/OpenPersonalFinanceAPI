<?php

namespace App\Http\Controllers\Category;

use App\Actions\Category\ListCategories;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CategoriesController extends Controller
{
    protected $listCategories;

    public function __construct(ListCategories $listCategories)
    {
        $this->listCategories = $listCategories;
    }

    public function index()
    {
        try {
            $response = $this->listCategories->execute();
            return response()->json(
                [

                    "categories" => $response
                ]
            );
        } catch (HttpException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
