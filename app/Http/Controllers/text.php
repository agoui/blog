<?php


namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;


class text extends Controller
{
    public function index(Request $Request)
    {
        $name = session('name') ?? "";
//         dd($name);
        if ($name == "") {
            echo "您还没有登录";
            die;
        }
        $where = [
            ['name', '=', $name],
        ];
//        dd($where);
        $uid=DB::table('admin_user')->where($where)->select('id')->first();
        $uid=get_object_vars($uid)['id'];
//         dd($uid);
        $access_token=access_token();
         dd($access_token);
//        $url="https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=";
//        $re=file_get_contents($url);
//        $re=json_decode($re,1);
//         dd($re);
    }
}