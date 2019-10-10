<?php

namespace App\Http\Controllers;
use App\Tools\Tools;
use Illuminate\Http\Request;
use DB;
use App\model\Openid;
class AdminController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {

        $this->tools=$tools;
    }

    public function login(){
        return view('Admin.login');
    }

    public function index(){
        return view('Admin.index');
    }

    public function bangding(){
        return view('Admin.bangding');
    }

    public function do_bangding(Request $request)
    {

        $data=$request->all();
//        dd($data);
        $name=$data['name'];
        $password=$data['password'];
        $openid=Openid::getOpenid();
        DB::table('admin')->where(['name'=>$name,'password'=>$password])->update([
            'openid'=>$openid
        ]);

    }


    public function do_code(Request $request){
//        $code=rand(1000,9999);  //8613
//        $this->tools->redis->set('code',$code,180);
//        echo $code;
//        die;
        $data=$request->all();
//        dd($data);
        $db_info=DB::table('admin')->where(['name'=>$data['name'],'password'=>$data['password']])->first();
//        dd($db_info);
        $openid=$db_info->openid;
//        $user=$db_info->name;
//        echo $user;
//        dd($name);
//        if(!$db_info->name){
//            $result=DB::table('user_info')->where(['openid'=>$openid])->update([
//                'name'=>$data['name'],'password'=>$data['password'],'reg_time'=>time(),'tel'=>$data['tel']
//            ]);
//            if($result){
//                echo json_encode(['status'=>1,'content'=>'添加成功']);
//            }else{
//                echo json_encode(['status'=>0,'content'=>'添加失败']);
//            }
//        }
        $code=rand(1000,9999);
        if($db_info){
            $this->tools->redis->set('code',$code,180);
            $this->send_template_message($code,$openid);
        }else{
            return json_encode(['ret'=>0,'content'=>'数据错误']);
        }

    }

    public function send_code(Request $request){
        $data=$request->all();
        $code=$data['code'];
//        dd($data);
        $db=$this->tools->redis->get('code');
//        dd($db);
        if($code==$db){
            return json_encode(['ret'=>1,'content'=>'登陆成功']);
        }else{
            return json_encode(['ret'=>0,'content'=>'登陆失败']);
        }
    }


    public function send_template_message($code,$openid){
        $oid=$openid;
        $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
        $data=[
            'touser'=>$oid,
            'template_id'=>'9QgLcwp5G2Zd1889Ek0g6pa8QQK1MtkKbC3BNonbkiM',
            'url'=>'www.blog.com',
            'data' => [
                'code' => [
                    'value' => $code,
                    'color' => '',
                ],
                'name' => [
                    'value' => '',
                    'color' => '',
                ],
                'time' => [
                    'value' => date('Y-m-d:H:i:s',time()),
                    'color' => '',
                ],
            ],
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }

    public function test(){

        $openid = Openid::getOpenid();
        var_dump($openid);
        $host = $_SERVER['HTTP_HOST'];  //域名
        $uri = $_SERVER['REQUEST_URI']; //路由参数
        $redirect_uri = urlencode($host.$uri);
//
        dd($redirect_uri);
    }
}
