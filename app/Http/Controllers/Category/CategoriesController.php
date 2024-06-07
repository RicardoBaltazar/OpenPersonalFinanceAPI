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

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Categories listing",
     *     description="Endpoint to list categories",
     *     tags={"Categories"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Categories listing successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Serviços"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to list categories",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unable to list categories")
     *         )
     *     )
     * )
     */
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
