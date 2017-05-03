<?php namespace Royalcms\Component\UEditor;
  

use Royalcms\Component\Support\Facades\Filesystem;

/**
 * 获取本地文件列表
 * @author royalwang
 *
 */
class FileManager
{
    protected $allowFiles;
    protected $listSize;
    protected $path;
    protected $request;
    
    public function __construct($allowFiles, $listSize, $path, $request)
    {
        $this->allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);
        $this->listSize = $listSize;
        $this->path = $path;
        $this->request = $request;
    }

    public function getList()
    {
        $size = $this->request->get('size', $this->listSize);
        $start = $this->request->get('start', 0);
        
        /* 获取文件列表 */
        $path = \RC_Upload::upload_path() . ltrim($this->path, '/');

        $files = Filesystem::disk()->filelist($path, $this->allowFiles, $start, $size);
        if (!count($files)) {
            return array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => count($files)
            );
        } else {
            /* 返回数据 */
            $result = array(
                "state" => "SUCCESS",
                "list" => $files,
                "start" => $start,
                "total" => count($files)
            );
            
            return $result;
        }
    }
}
