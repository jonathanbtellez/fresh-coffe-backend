<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OrderCollection(Order::with('user')->with('products')->where('state', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->precio = $request->total;
        $order->save();

        // Get id
        $id = $order->id;

        // Get products
        $products = $request->products;

        $order_product = [];

        // Format products
        foreach ($products as $product) {
            $order_product[] = [
                'order_id' => $id,
                'product_id'=> $product['id'],
                'quantity'=> $product['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Save products the method insert allow save an array in the DB
        OrderProduct::insert($order_product);

        return [
            'message'=>'Pedido realizado correctamente estara listo en unos momentos'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->state = 1;
        $order->save();
        return [
            'order' => $order
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
