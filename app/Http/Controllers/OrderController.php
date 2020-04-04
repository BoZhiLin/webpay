<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\Pay;
use App\Services\OrderService;
use App\Jobs\SendOrderMail;
use App\Jobs\SendPushNotification;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware('auth:api', ['only' => 'store']);
    }

    public function index()
    {
        //
    }

    public function store(Pay $request)
    {
        $user = auth()->user();
        $form = $this->orderService->pay($request->validated());
        SendOrderMail::dispatch($user->email);
        SendPushNotification::dispatch([
            'title' => '訂單完成通知',
            'body' => '您的訂單已於'.now().'完成',
            'ids' => [$user->fcm_id],
            'data' => 'test data',
        ]);
        
        return response()->json(['form' => $form]);
    }

    public function show($id)
    {
        //
    }

    public function update($id)
    {
        $result = $this->orderService->adjustPayStatus(request()->TradeInfo);

        if ($result) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }

    public function destroy($id)
    {
        //
    }
}
