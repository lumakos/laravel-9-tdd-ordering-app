<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class SummaryController extends Controller
{
    public function index()
    {
        $order = Order::where('id', \request('order_id'))->first();
        return view('summary', compact('order'));
    }
}
