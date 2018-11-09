<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Fangxu\DoNewsPush\Push;

Route::prefix(config("push.route.prefix"))->group(function () {
	Route::post(config("push.route.setToken"), function (Push $push, Request $request){
		$app_id = $request->header("appid");
		$platform = $request->post("platform") ?: "umeng";
		$user_id = $request->post("user_id");
		$deviceToken = $request->post("device_token");

		if(!$app_id || !$user_id || !$deviceToken || !$platform)
		{
			return $push->error();
		}

		$push->setToken($platform, $app_id, $user_id, $deviceToken);

		return $push->success();
	});
});