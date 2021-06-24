<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;
use BBLDN\Laravel\Messenger\DispatcherPool;
use Messenger\OrderFrontHasBeenUpdatedMessage;
use Messenger\CustomerFrontHasBeenUpdatedMessage;

class MainController extends Controller
{
    /**
     * @param Request $request
     * @param DispatcherPool $dispatcherPool
     * @return JsonResponse
     */
    public function customerAction(Request $request, DispatcherPool $dispatcherPool): JsonResponse
    {
        $customerId = (int)$request->get('customerId', -1);

        try {
            if (-1 !== $customerId) {
                $dispatcherPool->send('synchronizer_ua', new CustomerFrontHasBeenUpdatedMessage($customerId));
            }
        } catch (Throwable $e) {
            return response()->json(['data' => null, 'errors' => [$e->getMessage()]]);
        }

        return response()->json(['data' => [true]]);
    }

    /**
     * @param Request $request
     * @param DispatcherPool $dispatcherPool
     * @return JsonResponse
     */
    public function orderAction(Request $request, DispatcherPool $dispatcherPool): JsonResponse
    {
        $orderId = (int)$request->get('orderId', -1);

        try {
            if (-1 !== $orderId) {
                $dispatcherPool->send('synchronizer_ua', new OrderFrontHasBeenUpdatedMessage($orderId));
            }
        } catch (Throwable $e) {
            return response()->json(['data' => null, 'errors' => [$e->getMessage()]]);
        }

        return response()->json(['data' => [true]]);
    }
}