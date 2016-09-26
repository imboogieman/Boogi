<?php

/**
 * Console renderer mixin class for Event
 */
class EmailRenderer extends CBehavior
{
    /**
     * The root directory of view files. Defaults to 'protected/views'.
     * @return string
     */
    public function getBaseUrl()
    {
        return Yii::app()->params['baseUrl'];
    }

    /**
     * The root directory of view files. Defaults to 'protected/views'.
     * @return string
     */
    public function getBasePath()
    {
        return DOC_ROOT . DS . 'protected';
    }

    /**
     * The root directory of view files. Defaults to 'protected/views'.
     * @return string
     */
    public function getViewPath()
    {
        return $this->getBasePath() . DS . 'views';
    }

    /**
     * The default layout file.
     * @return string
     */
    public function getLayoutFile()
    {
        $layout = 'email';
        $owner = $this->getOwner();
        if (is_object($owner)) {
            $layout = property_exists($owner, 'layout') ? $owner->layout : $layout;
        }
        return  $this->getViewPath() . DS . 'layouts' . DS . $layout;
    }

    /**
     * The default layout file.
     * @param string $file
     * @return string
     */
    public function getViewFile($file)
    {
        return  $this->getViewPath() . DS . $file;
    }

    /**
     * Renders a view with a layout.
     *
     * @param string $view name of the view to be rendered.
     * @param array $data data to be extracted into PHP variables
     * @return string the rendering result
     */
    public function render($view, $data = null)
    {
        $output = $this->renderPartial($view, $data);

        if (($layoutFile = $this->getLayoutFile()) !== false) {
            $output = $this->renderFile($layoutFile, array('content' => $output));
        }

        return $output;
    }

    /**
     * Renders a view.
     *
     * @param string $view name of the view to be rendered.
     * @param array $data data to be extracted into PHP variables
     * @return string the rendering result
     * @throws CException if the view does not exist
     */
    public function renderPartial($view, $data = null)
    {
        if (($viewFile = $this->getViewFile($view)) !== false) {
            $output = $this->renderFile($viewFile, $data);
            return $output;
        } else {
            throw new CException(Yii::t(
                'yii', '{controller} cannot find the requested view "{view}".',
                array('{controller}' => get_class($this), '{view}' => $view)
            ));
        }
    }

    /**
     * Renders a file.
     *
     * @param string $viewFile name of the file to be rendered.
     * @param array $data data to be extracted into PHP variables
     * @return string the rendering result
     */
    public function renderFile($viewFile, $data = null)
    {
        extract($data, EXTR_PREFIX_SAME, 'data');
        ob_start();
        ob_implicit_flush(false);
        require $viewFile . '.php';
        return ob_get_clean();
    }

}