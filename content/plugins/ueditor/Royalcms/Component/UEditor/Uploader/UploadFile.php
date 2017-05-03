<?php namespace Royalcms\Component\UEditor\Uploader;
  

use Royalcms\Component\Support\Facades\Filesystem;

/**
 *
 *
 * Class UploadFile
 *
 * 文件/图像普通上传
 *
 * @package Royalcms\Component\UEditor\Uploader
 */
class UploadFile  extends UploadBase
{

    public function uploadCore()
    {
        $file = $this->request->file($this->fileField);
        if (empty($file)) {
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_NOT_FOUND");
            return false;
        }
        if (!$file->isValid()) {
            $this->stateInfo = $this->getStateInfo($file->getError());
            return false;
        }
        
        $this->file = $file;
        
        $this->oriName  = $this->file->getClientOriginalName();
        $this->fileSize = $this->file->getSize();
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
        //检查是否不允许的文件格式
        if (!$this->checkType()) {
            $this->stateInfo = $this->getStateInfo("ERROR_TYPE_NOT_ALLOWED");
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
        if ($filesystem->move_uploaded_file($this->file->getPathname(), $this->filePath)) {
            $this->stateInfo = $this->stateMap[0];
        } else {
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
            return false;
        }

        /*
        try {
            $this->file->move(dirname($this->filePath), $this->fileName);
            
            $this->stateInfo = $this->stateMap[0];

        } catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $exception) {
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
            return false;
        }
        */

        return true;

    }
}
