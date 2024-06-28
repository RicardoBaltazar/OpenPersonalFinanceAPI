<?php

namespace App\Http\Controllers\Expanse;

use App\Actions\Expense\GetUserExpenses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExpensesController extends Controller
{
    private $getUserExpenses;

    public function __construct(GetUserExpenses $getUserExpenses)
    {
        $this->getUserExpenses = $getUserExpenses;
    }
    public function index()
    {
        try {
            $response = $this->getUserExpenses->execute();
            return response()->json($response);
        } catch (HttpException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            Log::error('Failed to list user expenses.');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
