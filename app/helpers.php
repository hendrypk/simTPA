<?php

if (!function_exists('responseSuccess')){
    function responseSuccess($message = '', $result = [], $statusCode = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message?: __('general.success'),
            'data' => $result,
        ];

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('responseError')){
    function responseError($message = '', $errorMessages = [], $statusCode = 400): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message?: __('general.failed'),
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('formatRupiah')){
    function formatRupiah($number, $rp=true, $dec=false): string
    {
        $negative = false;
        if ($number<0){
            $negative = true;
            $number = abs($number);
        }
        $dec = $dec?2:0;
        $rupiah = number_format($number,$dec,',','.');
        if ($rp) $rupiah = 'Rp '.$rupiah;
        if ($negative) $rupiah = '-'.$rupiah;
        return $rupiah;
    }
}

if (!function_exists('formatNumber')){
    function formatNumber($number, $decimal = 0): string
    {
        $negative = false;
        if ($number<0){
            $negative = true;
            $number = abs($number);
        }
        $number = number_format($number,$decimal,',','.');
        if ($negative) $number = '-'.$number;
        return $number;
    }
}
