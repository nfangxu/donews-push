<?php

return [

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 2,
        ],
    ],

    "platform" => [
        "mi" => [
            "app_package_name" => env("MI_APP_PACKAGE_NAME", null),
            "app_secret" => env("MI_APP_SECRET", null),
        ],

        "umeng" => [
            "app_key" => env("UMENG_APP_KEY", null),
            "app_master_secret" => env("UMENG_APP_MASTER_SECRET", null),
        ],

        "huawei" => [
            "client_id" => env("HUAWEI_CLIENT_ID", null),
            "client_secret" => env("HUAWEI_CLIENT_SECRET", null),
        ],

        "apple" => [
            "APNS_CERTIFICATE_PATH" => env("APNS_CERTIFICATE_PATH", null),
            "APNS_CERTIFICATE_PASSPHRASE" => env("APNS_CERTIFICATE_PASSPHRASE", null),
            "APNS_ENVIRONMENT" => env("APNS_ENVIRONMENT", "sandbox"), // production
        ],
    ],

    "route" => [
        "prefix" => env("DONEWS_PUSH_ROUTE_PREFIX", "push"),
        "setToken" => env("DONEWS_PUSH_ROUTE_SET_TOKEN", "set/token"),
    ],
];