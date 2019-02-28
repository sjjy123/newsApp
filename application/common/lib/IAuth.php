<?php
namespace app\common\lib;

use think\Cache;
use think\Controller;
use app\common\lib\Aes;

class IAuth extends Controller
{
    /**
     * 密码加密方法
     * @param $data
     * @return string
     * @author: Shijie
     * @date: ${DATE} ${TIME}
     */
    public static function setPassword($data)
    {
        return md5($data.config('app.password_half_pre'));
    }

    /**
     * 生成每次加密的sign
     * @param $data
     * @return HexString|string
     * @author: Shijie
     */
    public function setSign($data) {
        //字段进行排序
        ksort($data);
        //拼接字符串数据
        $string = http_build_query($data);
        //通过Aes加密
        $string = (new Aes())->encrypt($string);

        return $string;
    }

    /**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data) {

//        $str = (new Aes())->decrypt($data['sign']);
//        if(empty($str)) {
//            return false;
//        }
//
//        // diid=xx&app_type=3
//        parse_str($str, $arr);
//        if(!is_array($arr) || empty($arr['did'])
//            || $arr['did'] != $data['did']
//        ) {
//            return false;
//        }
//        if(!config('app_debug')) {
//            if ((time() - ceil($arr['time'] / 1000)) > config('app.app_sign_time')) {
//                return false;
//            }
//            //echo Cache::get($data['sign']);exit;
//            // 唯一性判定
//            if (Cache::get($data['sign'])) {
//                return false;
//            }
//        }
        return true;
    }
}