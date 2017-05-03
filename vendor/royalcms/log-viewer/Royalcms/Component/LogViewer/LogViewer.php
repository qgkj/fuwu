<?php namespace Royalcms\Component\LogViewer;

use Royalcms\Component\Support\Facades\File;
use Psr\Log\LogLevel;
use ReflectionClass;

/**
 * Class LogViewer
 * @package Royalcms\Component\LogViewer
 */
class LogViewer
{

    /**
     * @var string file
     */
    private static $file;

    private static $levels_classes = array(
        'debug'     => 'info',
        'info'      => 'info',
        'notice'    => 'info',
        'warning'   => 'warning',
        'error'     => 'danger',
        'critical'  => 'danger',
        'alert'     => 'danger',
        'emergency' => 'danger',
    );

    private static $levels_imgs = array(
        'debug'     => 'info',
        'info'      => 'info',
        'notice'    => 'info',
        'warning'   => 'warning',
        'error'     => 'warning',
        'critical'  => 'warning',
        'alert'     => 'warning',
        'emergency' => 'warning',
    );

    const MAX_FILE_SIZE = 52428800; // Why? Uh... Sorry

    /**
     * @param string $file
     */
    public static function setFile($file)
    {
        // if absolute path is given
        if (File::exists($file)) 
        {
            self::$file = $file;
        } 
        // or check if file with given filename is in storage/logs folder
        else 
        {
            $file = storage_path() . '/logs/' . $file;

            if (File::exists($file)) {
                self::$file = $file;
            }
        }
    }

    /**
     * @return string
     */
    public static function getFileName()
    {
        return basename(self::$file);
    }

    /**
     * @return array
     */
    public static function all()
    {
        $log = array();

        $log_levels = self::getLogLevels();

        $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/';

        if (!self::$file) {
            $log_file = self::getFiles();
            if(!count($log_file)) {
                return array();
            }
            self::$file = $log_file[0];
        }

        if (File::size(self::$file) > self::MAX_FILE_SIZE) return null;

        $file = File::get(self::$file);

        preg_match_all($pattern, $file, $headings);

        if (!is_array($headings)) return $log;

        $log_data = preg_split($pattern, $file);

        if ($log_data[0] < 1) {
            array_shift($log_data);
        }

        foreach ($headings as $h) {
            for ($i=0, $j = count($h); $i < $j; $i++) {
                foreach ($log_levels as $level_key => $level_value) {
                    if (strpos(strtolower($h[$i]), '.' . $level_value)) {

                        preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\].*?\.' . $level_key . ': (.*?)( in .*?:[0-9]+)?$/', $h[$i], $current);

                        if (!isset($current[2])) continue;

                        $log[] = array(
                            'level'         => $level_value,
                            'level_class'   => self::$levels_classes[$level_value],
                            'level_img'     => self::$levels_imgs[$level_value],
                            'date'          => $current[1],
                            'text'          => $current[2],
                            'in_file'       => isset($current[3]) ? $current[3] : null,
                            'stack'         => preg_replace("/^\n*/", '', $log_data[$i])
                        );
                    }
                }
            }
        }

        return array_reverse($log);
    }

    /**
     * @param bool $basename
     * @return array
     */
    public static function getFiles($basename = false)
    {
        $files = glob(storage_path() . '/logs/*');
        $files = array_reverse($files);
        $files = array_filter($files, 'is_file');
        if ($basename && is_array($files)) {
            foreach ($files as $k => $file) {
                $files[$k] = basename($file);
            }
        }
        return array_values($files);
    }

    /**
     * @return array
     */
    private static function getLogLevels()
    {
        $class = new ReflectionClass(new LogLevel);
        return $class->getConstants();
    }
}
