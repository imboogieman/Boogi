<?php
/**
 * Email class file.
 */
class YUICompressor extends CApplicationComponent
{
    /**
     * @var object $instance self pointer
     */
    protected static $_instance = null;

    /**
     * @var Less directory
     */
    public $js_path;

    /**
     * @var Output css file
     */
    public $result_file;

    /**
     * @var Output css time
     */
    public $result_time;

    /**
     * @var Lock css file
     */
    public $lock_file;

    /**
     * @var Lock time
     */
    public $lock_time;

    /**
     * @var string
     */
    public $cache_path;

    /**
     * Singleton protection
     */
    protected function __construct() {
        $this->result_time = time();
        $this->result_file = DOC_ROOT . '/cache/js/index.min.' . $this->result_time . '.js';

        $this->js_path = DOC_ROOT . '/js';
        $this->cache_path = DOC_ROOT . '/cache/js';

        $this->lock_file = DOC_ROOT . '/cache/js.lock';
        if (file_exists($this->lock_file)) {
            $this->lock_time = file_get_contents($this->lock_file);
        }
    }

    /**
     * GetInstance class method
     * @return Less $instance
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new YUICompressor;
        }
        return self::$_instance;
    }

    /**
     * Get css link
     * @return string
     */
    public static function getLink()
    {
        $file = self::build();
        $file = pathinfo($file);
        return Yii::app()->request->baseUrl . '/cache/js/' . $file['basename'];
    }

    /**
     * Sends email
     */
    private static function build()
    {
        $yui = new \YUI\Compressor();
        $self = self::getInstance();

        $cached_files = array();
        if ($self->isNeedUpdate()) {
            // Remove all old files
            $directory = new DirectoryIterator($self->cache_path);
            foreach ($directory as $path) {
                if ($path->isFile()) {
                    unlink($path->getPathname());
                }
            }

            // Compile new
            $directory =  new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($self->js_path, RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($directory as $path) {
                if ($path->isFile()) {
                    $basename = $path->getBasename('.js');
                    $newfile = $basename . '.min.' . $self->result_time . '.js';

                    // Skip external libraries
                    if ($basename != 'markerclusterer' && $basename != 'markerwithlabel') {
                        $contents = file_get_contents($path);
                        $yui->setType(\YUI\Compressor::TYPE_JS);
                        $compressed = $yui->compress($contents);
                        file_put_contents($self->cache_path . '/' . $newfile, $compressed);

                        // Save result
                        $cached_files[] = "'" . $basename . "':{fullpath:'/cache/js/" . $newfile . "'}";
                    }
                }
            }

            // Compile index file
            $contents = 'YUI({combine:true,modules:{';
            $contents .= implode(',', $cached_files);
            $contents .= "}}).use('base-app',function(Y){window.app=new Y.BaseApp();window.app.render();});";
            $yui->setType(\YUI\Compressor::TYPE_JS);
            $compressed = $yui->compress($contents);

            // Save results
            file_put_contents($self->result_file, $compressed);
            file_put_contents($self->lock_file, $self->result_time);
        }

        // Return file link
        return $self->result_file;
    }

    /**
     * Check less changes
     * @var string $directory
     * @return bool $result
     */
    private function isNeedUpdate()
    {
        $current_js_file = DOC_ROOT . '/cache/js/index.min.' . $this->lock_time . '.js';

        try {
            clearstatcache();
            $directory = new RecursiveDirectoryIterator($this->js_path, RecursiveDirectoryIterator::SKIP_DOTS);
            foreach ($directory as $path) {
                if ($path->getMTime() > $this->lock_time) {
                    return true;
                }
            }
        } catch (Exception $e) {
            return true;
        }

        $this->result_file = $current_js_file;
        return false;
    }
}