<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Promotion;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $promotions = Promotion::where('is_active', 1)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.dashboard', [
            'promotions' => $promotions
        ]);
    }
}
