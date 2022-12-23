<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemss = Item::all();
        return view('order', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'status' => 'required|not_in:none'
        ];
        $validated = $request->validate($rules);
        Order::create($validated);

        // $testing = $request['id'.$i];

        // for($i=0;$i<count($request)-1;$i++){

        // }

        $itemcount = Item::all()->count();
        $orderId = Order::all()->last()->id;
        for ($i = 1; $i <= $itemcount; $i++) {
            if ($request['quantity' . $i] > 0) {
                DB::table('order_menu')->insert([
                    'order_id' => $orderId,
                    'menu_id' => $request['id' . $i],
                    'quantity' => $request['quantity' . $i],
                ]);
            }
        }
        $request->session()->flash('success', "Successfully added Order Number {$orderId}!");
        return redirect(route('main.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $datas = DB::select('SELECT oi.item_id,i.nama,i.stok,oi.quantity,i.harga FROM order_items oi LEFT JOIN items i ON oi.item_id =i.id WHERE oi.order_id = ?', [$order->id]);

        $priceList = DB::select('SELECT i.stok,oi.quantity*i.harga gross_price FROM order_items oi JOIN items i ON oi.item_id = i.id WHERE oi.order_id = ?', [$order->id]);
        $price = 0;
        $price = round($price * 1.11, 2);

        return view('orders.show', compact('order', 'datas', 'price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect(route('order.index'))->with('success', "Successfully deleted Order Number {$order['id']}!");
    }
}
