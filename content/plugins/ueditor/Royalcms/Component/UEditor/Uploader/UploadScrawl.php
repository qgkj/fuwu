<?php namespace Royalcms\Component\UEditor\Uploader;
  

use Royalcms\Component\Support\Facades\Filesystem;

/**
 * Class UploadScrawl
 * 涂鸦上传
 * @package Royalcms\Component\UEditor\Uploader
 */
class UploadScrawl extends UploadBase
{

    public function uploadCore()
    {

        $base64Data = $this->request->get($this->fileField);
        $img = base64_decode($base64Data);
        if (!$img) {
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_NOT_FOUND");
            return false;
        }

        // $this->file = $file;

        $this->oriName = $this->config['oriName'];

        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();

        $this->fullName = $this->getFullName();


        $this->filePath = $this->getFilePath();

        $this->fileName = basename($this->filePath);
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