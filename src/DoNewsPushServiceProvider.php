<?php

namespace Fangxu\DoNewsPush;

use Illuminate\Support\ServiceProvider;

class DoNewsPushServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->publishes([
	        __DIR__.'/config/push.php' => config_path('push.php'),
	    ]);

	    $this->loadRoutesFrom(__DIR__.'/Routes.php');
	}

	public function register()
	{
		
	}
}