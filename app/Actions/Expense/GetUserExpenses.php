<?php

namespace App\Actions\Expense;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class GetUserExpenses
{
    private $expanses;

    public function __construct(Expense $expanses)
    {
        $this->expanses = $expanses;
    }

    public function execute()
    {
        $user = Auth::user();
        $expenses = $this->expanses->findByUserId($user->id);

        return ['data' => $expenses];
    }
}
