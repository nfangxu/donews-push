<?php

namespace Fangxu\DoNewsPush;

use Illuminate\Redis\RedisManager as Redis;
use Fangxu\DoNewsPush\Exceptions\PushException;

class Push
{
    private static $_config = null;
    private static $_redis = null;
    private static $_platform = null;

    const APNS = "apple";
    const XIAOMI = "mi";
    const HUAWEI = "huawei";
    const UMENG = "umeng";

    public function __construct()
    {
        if (!file_exists(config_path("push.php"))){
            throw new PushException("配置文件: ". config("push.php"). " 不存在", 500);
        }
        static::$_config = config("push");
        static::$_platform = config("push.platform");
        static::$_redis = new Redis(config("push.redis.client"), config("push.redis"));
    }

    private function getSerivce($platform)
    {
        switch($platform){
            case APNS:
                $service = "ApnsPush";
                break;
            case XIAOMI:
                $service = "MiPush";
                break;
            case HUAWEI:
                $service = "HmsPush";
                break;
            case UMENG:
                $service = "UmengPush";
                break;
            default:
                throw new PushException("platform 参数错误", 405);
                return null;
                break;
        }

        return "Fangxu\\DoNewsPush\\Services\\" . $service;
    }

    /**
     * 统一推送接口。
     *
     * @param $deviceToken
     * @param $title
     * @param $message
     * @param $platform
     * @return mixed
     */
    public function send($deviceToken, $title, $message, $platform, $type, $id)
    {
        $service = $this->getSerivce($platform);

        $push = new $service(static::$_platform[$platform]);
        if (method_exists($push, 'sendMessage')) {
            return $push->sendMessage($deviceToken, $title, $message, $type, $id);
        }
        return false;
    }

    /**
     * 设置用户token
     */
    public function setToken($platform, $app_id, $user_id, $deviceToken)
    {
        static::$_redis->set($platform . ":" . $app_id . ":" . $user_id . ":regid:", $deviceToken);
        return $this;
    }


    /**
     * 获取用户token
     */
    public function getToken($platform, $app_id, $user_id)
    {
        if(!is_array($user_id)){
            return false;
        }
        foreach ($user_id as $key => $val) {
            $keys[] = $platform . ":" . $app_id . ":" . $user_id . ":regid:";
        }
        return static::$_redis->mget($keys);
    }

    public function success()
    {
        throw new PushException("success", 200);
    }

    public function error()
    {
        throw new PushException("参数错误", 405);
    }
}