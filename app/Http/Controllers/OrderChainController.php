<?php
namespace App\Http\Controllers;

use App\Services\OrderChainResponsability\OrderPipeline;
use Illuminate\Http\Request;

class OrderChainController extends Controller {
    public function process(Request $req) {
        $data = $req->validate([
            'items'         => 'required|array|min:1',
            'items.*.sku'   => 'required|string',
            'items.*.qty'   => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.01',
        ]);

        $ctx = ['ok'=>true, 'order'=>['items'=>$data['items']], 'notes'=>[]];
        $result = OrderPipeline::build()->handle($ctx);

        return response()->json($result, $result['ok'] ? 200 : 422);
    }
}
