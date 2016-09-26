<?php
/**
 * Email class file.
 */
class Less extends CApplicationComponent
{
    /**
     * @var object $instance self pointer
     */
    protected static $_instance = null;

    /**
     * @var Less directory
     */
    public $less_path;

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
        $this->result_file = DOC_ROOT . '/cache/css/' . $this->result_time . '.css';

        $this->less_path = DOC_ROOT . '/less';
        $this->cache_path = DOC_ROOT . '/cache/css';

        $this->lock_file = DOC_ROOT . '/cache/css.lock';
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
            self::$_instance = new Less;
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
        return Yii::app()->request->baseUrl . '/cache/css/' . $file['basename'];
    }

    /**
     * Sends email
     */
    private static function build()
    {
        $yui = new \YUI\Compressor();
        $self = self::getInstance();

        if ($self->isNeedUpdate()) {
            // Remove all old files
            $directory = new DirectoryIterator($self->cache_path);
            foreach ($directory as $path) {
                if ($path->isFile()) {
                    unlink($path->getPathname());
                }
            }

            // Compile new
            $less = new lessc;
            $less->setImportDir($self->less_path);
            $compiled = $less->compile('@import "bootstrap";');

            $yui->setType(\YUI\Compressor::TYPE_CSS);
            $compressed = $yui->compress($compiled);

            file_put_contents($self->result_file, $compressed);
            file_put_contents($self->lock_file, $self->result_time);
        }

        return $self->result_file;
    }

    /**
     * Check less changes
     * @var string $directory
     * @return bool $result
     */
    private function isNeedUpdate()
    {
        $current_css_file = DOC_ROOT . '/cache/css/' . $this->lock_time . '.css';

        try {
            clearstatcache();
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->less_path, RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($iterator as $path) {
                if ($path->isFile() && $path->getMTime() > $this->lock_time) {
                    return true;
                }
            }
        } catch (Exception $e) {
            return true;
        }

        $this->result_file = $current_css_file;
        return false;
    }
}