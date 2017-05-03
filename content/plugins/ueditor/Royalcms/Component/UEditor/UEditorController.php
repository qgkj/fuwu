<?php namespace Royalcms\Component\UEditor;
  

use Royalcms\Component\Routing\Controller as BaseController;
use Royalcms\Component\HttpKernel\Request;
use Royalcms\Component\UEditor\Uploader\UploadScrawl;
use Royalcms\Component\UEditor\Uploader\UploadFile;
use Royalcms\Component\UEditor\Uploader\UploadCatch;

class UEditorController extends BaseController
{
    private $config;

    public function __construct()
    {
        $this->config = \RC_Config::get('ueditor::ueditor.upload');
    }

    public function config(Request $request) 
    {
        return $this->config;
    }
    
    public function uploadimage(Request $request) 
    {
        $upConfig = array(
            "pathFormat"    => $this->config['imagePathFormat'],
            "maxSize"       => $this->config['imageMaxSize'],
            "allowFiles"    => $this->config['imageAllowFiles'],
            'fieldName'     => $this->config['imageFieldName'],
        );
        $result = with(new UploadFile($upConfig, $request))->upload();
        return $result;
    }
    
    public function uploadscrawl(Request $request)
    {
        $upConfig = array(
            "pathFormat"    => $this->config['scrawlPathFormat'],
            "maxSize"       => $this->config['scrawlMaxSize'],
            //   "allowFiles" => $config['scrawlAllowFiles'],
            "oriName"       => "scrawl.png",
            'fieldName'     => $this->config['scrawlFieldName'],
        );
        $result = with(new UploadScrawl($upConfig, $request))->upload();
        return $result;
    }
    
    public function uploadvideo(Request $request)
    {
        $upConfig = array(
            "pathFormat"    => $this->config['videoPathFormat'],
            "maxSize"       => $this->config['videoMaxSize'],
            "allowFiles"    => $this->config['videoAllowFiles'],
            'fieldName'     => $this->config['videoFieldName'],
        );
        $result = with(new UploadFile($upConfig, $request))->upload();
        return $result;
    }
    
    public function uploadfile(Request $request)
    {
        $upConfig = array(
            "pathFormat"    => $this->config['filePathFormat'],
            "maxSize"       => $this->config['fileMaxSize'],
            "allowFiles"    => $this->config['fileAllowFiles'],
            'fieldName'     => $this->config['fileFieldName'],
        );
        $result = with(new UploadFile($upConfig, $request))->upload();
        return $result;
    }
    
    /**
     * 列出图片
     * @param Request $request
     */
    public function listimage(Request $request)
    {
        $result = with(new FileManager(
                $this->config['imageManagerAllowFiles'],
                $this->config['imageManagerListSize'],
                $this->config['imageManagerListPath'],
                $request))->getList();
        return $result;
    }
    
    /**
     * 列出文件
     * @param Request $request
     */
    public function listfile(Request $request)
    {
        $result = with(new FileManager(
            $this->config['fileManagerAllowFiles'],
            $this->config['fileManagerListSize'],
            $this->config['fileManagerListPath'],
            $request))->getList();
        return $result;
    }
    
    /**
     * 抓取远程文件
     * @param Request $request
     */
    public function catchimage(Request $request)
    {
        $upConfig = array(
            "pathFormat"    => $this->config['catcherPathFormat'],
            "maxSize"       => $this->config['catcherMaxSize'],
            "allowFiles"    => $this->config['catcherAllowFiles'],
            "oriName"       => "remote.png",
            'fieldName'     => $this->config['catcherFieldName'],
        );
        
        $sources = \RC_Request::get($upConfig['fieldName']);
        $list = array();
        foreach ($sources as $imgUrl) {
            $upConfig['imgUrl'] = $imgUrl;
            $info = with(new UploadCatch($upConfig, $request))->upload();
        
            array_push($list, array(
                "state"     => $info["state"],
                "url"       => $info["url"],
                "size"      => $info["size"],
                "title"     => htmlspecialchars($info["title"]),
                "original"  => htmlspecialchars($info["original"]),
                "source"    => htmlspecialchars($imgUrl)
            ));
        }
        $result = array(
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list' => $list
        );
        return $result;
    }

    public function server()
    {
        $request = royalcms('request');
        $action = $request->get('action');

        if (method_exists($this, $action)) {
            $result = $this->$action($request);
        } else {
            $result = $this->uploadfile($request);
        }
        
        if (!defined('JSON_UNESCAPED_UNICODE')) define('JSON_UNESCAPED_UNICODE', 256);
        
        return \RC_Response::json($result, 200, array(), JSON_UNESCAPED_UNICODE);
    }

}
