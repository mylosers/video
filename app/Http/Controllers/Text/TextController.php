<?php

namespace App\Http\Controllers\Text;
use App\Http\Controllers\Controller;
use App\Model\VideoModel;

class TextController extends Controller
{
    public function index()
    {
        $secretId = "AKIDKZdecfKTTOQXUKoUp3NbfcO0TinRpSj5"; //"云 API 密钥 SecretId";
        $secretKey = "1za2KUWP3XLfruoh9QXTGuOkypcFhy53"; //"云 API 密钥 SecretKey";
        $region = "ap-beijing"; //设置一个默认的存储桶地域
        $cosClient = new \Qcloud\Cos\Client(
            array(
                'region' => $region,
                'schema' => 'https', //协议头部，默认为http
                'credentials'=> array(
                    'secretId'  => $secretId ,
                    'secretKey' => $secretKey)));

        /*$bucket = "video-1258120694"; //存储桶名称 格式：BucketName-APPID
        $key = "exampleobject";
        $result = $cosClient->putObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
            'Body' => 'Hello World!'));
        print_r($result);*/
        $bucket = "video-1258120694"; //存储桶名称 格式：BucketName-APPID
        $key = "图片";
        $srcPath = "http://vm.video.com/image/aaa.jpg";//本地文件绝对路径
    $result = $cosClient->Upload(
        $bucket = $bucket,
        $key = $key,
        $body = fopen($srcPath, 'rb'));
    print_r($result);
    }

    /**
     * 定时把文件上传
     */
    public function timeFile(){
        $secretId = "AKIDKZdecfKTTOQXUKoUp3NbfcO0TinRpSj5"; //"云 API 密钥 SecretId";
        $secretKey = "1za2KUWP3XLfruoh9QXTGuOkypcFhy53"; //"云 API 密钥 SecretKey";
        $region = "ap-beijing"; //设置一个默认的存储桶地域
        $cosClient = new \Qcloud\Cos\Client(
            array(
                'region' => $region,
                'schema' => 'https', //协议头部，默认为http
                'credentials'=> array(
                    'secretId'  => $secretId ,
                    'secretKey' => $secretKey)));

        $bucket = "video-1258120694"; //存储桶名称 格式：BucketName-APPID
        $data=VideoModel::all();
        if($data){
            $data=$data->toArray();
            foreach($data as $k=>$v){
                $path="http://video.myloser.club/".$v['path'];
                $key = $v['id'];
                $srcPath = $path;//本地文件绝对路径
                $result = $cosClient->Upload(
                    $bucket = $bucket,
                    $key = $key,
                    $body = fopen($srcPath, 'rb'));
                print_r($result);
            }
            foreach($data as $k=>$v){
                VideoModel::where(['id'=>$v['id']])->delete();
                unlink(storage_path('app/public/').$v['path']);
            }
        }else{

        }
    }

    /**
     * 前台播放视频▶
     */
    public function look(){
        $id=$_GET['id'];
        if($id){
            $data=VideoModel::where(['id'=>$id])->first();
            if($data){
                $data=$data->toArray();
                print_r($data);echo "<hr>";
                return view('index.video',['data'=>$data]);
            }else{
                $data=[
                    'id'=>$id,
                    'status'=>1
                ];
                return view('index.video',['data'=>$data]);
            }
        }else{
            dd('请输入查询条件');
        }
    }
}
