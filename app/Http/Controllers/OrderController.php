<?php

namespace App\Http\Controllers;

use App\Order;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::where('is_delivered', 0)->with(['product'])->get(),200);
    }
        
    public function deliverOrder(Order $order)
    {
        $order->is_delivered = true;
        $status = $order->save();
        
        return response()->json([
            'status'    => $status,
            'data'      => Order::where('is_delivered', 0)->with(['product'])->get(),
            'message'   => $status ? 'Order Delivered!' : 'Error Delivering Order'
        ]);
    }
    
    public function store(Request $request)
    {
        $order = Order::create([
            'product_id' => $request->product,
            'user_id' => Auth::id(),
            'quantity' => $request->quantity,
            'address' => $request->address
        ]);
        
        return response()->json([
            'status' => (bool) $order,
            'data'   => $order,
            'message' => $order ? 'Order Created!' : 'Error Creating Order'
        ]);
    }

    public function show(Order $order)
    {
        return response()->json($order,200);
    }
    
    public function update(Request $request, Order $order)
    {
        $status = $order->update(
            $request->only(['quantity'])
        );
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Updated!' : 'Error Updating Order'
        ]);
    }

    public function destroy(Order $order)
    {
        $status = $order->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Deleted!' : 'Error Deleting Order'
        ]);
    }

    public function deliveredOrders()
    {
        $deliveredOrders = Order::where('is_delivered', 1)->with(['product'])->get();
        return response()->json($deliveredOrders, 200);
    }
}