<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexander.Chajka
 * Date: 4/15/14
 * Time: 12:59 PM
 * To change this template use File | Settings | File Templates.
 */

class Logger extends CFileLogRoute
{
    private $_log_files = array(
        'frontend'      => 'front_error.log',
        'application'   => 'app_error.log',
    );

    /**
     * Saves log messages in files.
     * @param array $logs list of log messages
     */
    protected function processLogs($logs)
    {
        $messages = array(
            'frontend'      => '',
            'application'   => '',
        );

        foreach ($logs as $log) {
            foreach ($this->_log_files as $category => $file) {
                if ($log[2] == $category) {
                    $messages[$category] .= $this->formatLogMessage($log[0], $log[1], $log[2], $log[3]);
                } else {
                    $messages['application'] .= $this->formatLogMessage($log[0], $log[1], $log[2], $log[3]);
                }
            }
        }

        foreach ($this->_log_files as $category => $file) {
            $text = $messages[$category];
            $frontLogFile = $this->getLogPath() . DS . $file;
            $fp = @fopen($frontLogFile, 'a');
            @flock($fp, LOCK_EX);

            if (@filesize($frontLogFile) > $this->getMaxFileSize() * 1024) {
                $this->rotateFiles();
                @flock($fp, LOCK_UN);
                @fclose($fp);
                @file_put_contents($frontLogFile, $text, FILE_APPEND | LOCK_EX);
            } else {
                @fwrite($fp, $text);
                @flock($fp, LOCK_UN);
                @fclose($fp);
            }
        }
    }

    /**
     * Rotates log files.
     */
    protected function rotateFiles()
    {
        foreach ($this->_log_files as $file) {
            $file = $this->getLogPath() . DS . $file;
            $max = $this->getMaxLogFiles();

            for ($i = $max; $i > 0; --$i) {
                $rotateFile = $file . '.' . $i;
                if (is_file($rotateFile)) {
                    // suppress errors because it's possible multiple processes enter into this section
                    if ($i === $max)
                        @unlink($rotateFile);
                    else
                        @rename($rotateFile, $file . '.' . ($i + 1));
                }
            }
            if (is_file($file)) {
                // suppress errors because it's possible multiple processes enter into this section
                if ($this->rotateByCopy) {
                    @copy($file, $file . '.1');
                    if ($fp = @fopen($file, 'a')) {
                        @ftruncate($fp, 0);
                        @fclose($fp);
                    }
                } else
                    @rename($file, $file . '.1');
            }
        }
    }
}