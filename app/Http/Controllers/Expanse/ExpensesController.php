<?php

namespace App\Http\Controllers\Expanse;

use App\Http\Controllers\Controller;
use App\Models\Expanse;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExpensesController extends Controller
{
    private $expanses;

    public function __construct(Expense $expanses)
    {
        $this->expanses = $expanses;
    }
    public function index()
    {
        try {
            $user = Auth::user();
            $expenses = $this->expanses->findByUserId($user->id);

            return response()->json([
                'data' => $expenses
            ]);
        } catch (HttpException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            Log::error('Failed to list user expenses.');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
