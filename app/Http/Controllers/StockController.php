<?php

namespace App\Http\Controllers;

use App\Services\Market\StockMarket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StockController extends Controller
{
    public function __construct(private StockMarket $market = new StockMarket()) {}

    public function subscribe(Request $r): JsonResponse
    {
        $data = $r->validate([
            'symbol'  => 'required|string|max:10',
            'channel' => ['required', Rule::in(['sms','email','dashboard'])],
        ]);
        $subs = $this->market->subscribe($data['symbol'], $data['channel']);
        return response()->json(['symbol'=>strtoupper($data['symbol']),'subscriptions'=>$subs]);
    }

    public function unsubscribe(Request $r): JsonResponse
    {
        $data = $r->validate([
            'symbol'  => 'required|string|max:10',
            'channel' => ['required', Rule::in(['sms','email','dashboard'])],
        ]);
        $subs = $this->market->unsubscribe($data['symbol'], $data['channel']);
        return response()->json(['symbol'=>strtoupper($data['symbol']),'subscriptions'=>$subs]);
    }

    public function price(Request $r): JsonResponse
    {
        $data = $r->validate([
            'symbol' => 'required|string|max:10',
            'price'  => 'required|numeric|min:0',
        ]);
        $this->market->changePrice($data['symbol'], (float)$data['price']);
        return response()->json(['ok'=>true]);
    }

    public function subscriptions(string $symbol): JsonResponse
    {
        return response()->json([
            'symbol'=>strtoupper($symbol),
            'subscriptions'=>$this->market->subscriptions($symbol),
        ]);
    }
}
