<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;

class OwnerController extends Controller
{
    /**
     * Halaman utama owner setelah login: ringkasan singkat + akses cepat.
     */
    public function dashboard()
    {
        $totalMenu = Menu::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        return view('owner.dashboard', compact('totalMenu', 'pendingOrders', 'completedOrders'));
    }
}
