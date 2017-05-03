<?php namespace Royalcms\Component\UEditor\Uploader;
  

use Royalcms\Component\Support\Facades\Filesystem;

/**
 * Class UploadCatch
 * 图片远程抓取
 *
 * @package Royalcms\Component\UEditor\Uploader
 */
class UploadCatch  extends UploadBase
{

    public function uploadCore()
    {
        $imgUrl = strtolower(str_replace("&amp;", "&", $this->config['imgUrl']));
        //http开头验证
        if (strpos($imgUrl, "http") !== 0) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_LINK");
            return false;
        }
        //获取请求头并检测死链
        $heads = get_headers($imgUrl);

        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK"))) {
            $this->stateInfo = $this->getStateInfo("ERROR_DEAD_LINK");
            return false;
        }

        //格式验证(扩展名验证和Content-Type验证)
        $fileType = strtolower(strrchr($imgUrl, '.'));
        if (!in_array($fileType, $this->config['allowFiles']) ) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_CONTENTTYPE");
            return false;
        }

        //打开输出缓冲区并获取远程图片
        ob_start();
        $context = stream_context_create(
            array('http' => array(
                'follow_location' => false // don't follow redirects
            ))
        );
        readfile($imgUrl, false, $context);
        $img = ob_get_contents();

        ob_end_clean();

        preg_match('/[\/]([^\/]*)[\.]?[^\.\/]*$/', $imgUrl, $m);

        $this->oriName  = $m ? $m[1] : '';
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName =  basename($this->filePath);
        $dirname = dirname($this->filePath);

        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return false;
        }
        
        $filesystem = Filesystem::disk();

        //创建目录失败
        if (! $filesystem->exists($dirname) && ! $filesystem->mkdir($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return false;
        } else if (!$filesystem->is_writable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return false;
        }

        //移动文件
        //移动失败
        if (!($filesystem->put_contents($this->filePath, $img) && $filesystem->exists($this->filePath))) { 
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
            return false;
        } 
        //移动成功
        else { 
            $this->stateInfo = $this->stateMap[0];
            return true;
        }
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    protected function getFileExt()
    {
        return strtolower(strrchr($this->oriName, '.'));
    }
}