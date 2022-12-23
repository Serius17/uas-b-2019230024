<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        $itemCount = Item::all()->count();
        $orderCount = Order::all()->count();
        return view('index', compact('itemCount', 'orderCount'));
    }
}
