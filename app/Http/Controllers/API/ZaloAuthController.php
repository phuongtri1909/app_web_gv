<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\ZaloApiService;
use App\Http\Controllers\Controller;

class ZaloAuthController extends Controller
{

    protected $zaloApiService;

    public function __construct(ZaloApiService $zaloApiService)
    {
        $this->zaloApiService = $zaloApiService;
    }

    public function redirectToZalo(Request $request)
    {
        $get_info = $request->get('get_info');
        $get_phone = $this->zaloApiService->getPhoneNumber($request->header('access_token'), $request->header('code'));

        $customer = Customer::where('id', $get_info['id'])->first();

        if ($customer) {
            if (isset($get_phone['data']['number'])) {
                $customer->phone = $get_phone['data']['number'];
            }
            $customer->save();
        }

        return response()->json([
            'customer' => $customer,
            'message'  => 'Thành công!',
        ]);
    }
}
