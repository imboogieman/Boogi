<?php

class SiteController extends Controller
{
    /**
     * This is the action to handle external exceptions.
     */
    public function actionIndex()
    {
        $this->layout = 'index';
        $this->render('index');
    }

    public function actionApi()
    {
        $this->layout = 'api';
        $this->render('api');
    }

    public function actionError()
    {
        $this->renderJSON(array(
            'result'    => 'error',
            'message'   => Yii::app()->errorHandler->error
        ));
    }
}
