<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function returnError($code, $message)
	{
		return response()->json([
			'status'    => 'error',
			'code'      => $code,
			'message'   => $message,
			'data'      => []
		]);
	}
	public function returnSuccess($data = [])
	{
		return response()->json([
			'status'    => 'ok',
			'code'      => 200,
			'message'   => '',
			'data'      => $data
		]);
	}
}
