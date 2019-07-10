<?php

namespace App\Admin\Controllers;

use App\Model\VideoModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Storage;

class VideoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\VideoModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VideoModel);

        $grid->column('id', __('Id'));
        $grid->column('path', __('Path'));
        $grid->column('name', __('Name'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(VideoModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('path', __('Path'));
        $show->field('name', __('Name'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new VideoModel);
        $form->text('name', __('Name'));
        $form->file('path', __('Path'))->uniqueName();

        return $form;
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
                $key = $k;
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
}
