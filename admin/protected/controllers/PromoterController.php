<?php

// @TODO: Replace $_GET and $_POST globals

class PromoterController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/sidebar';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions'   => array('login'),
                'users'     => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'   => array('logout'),
                'users'     => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'   => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'users'     => Model::$admin_emails,
            ),
            array('deny', // deny all users
                'users'     => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $model->user->password = '********';
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $promoter = new Promoter;
        $transaction = $promoter->dbConnection->beginTransaction();

        $this->performAjaxValidation($promoter);

        if (isset($_POST['Promoter'])) {
            $promoter->attributes = $_POST['Promoter'];
            $promoter->bindRelatedParams($_POST['User']);

            $modelImage = new ModelImage($promoter);
            if ($modelImage->save()) {
                try {
                    $transaction->commit();
                    Yii::app()->user->setFlash('notification', 'New promoter have been successfully created.');
                    $this->redirect(array('view', 'id' => $promoter->id));
                } catch (CException $e) {
                    $this->render('create', array(
                        'model' => $promoter,
                    ));
                }
            } else {
                $transaction->rollback();
            }
        }

        $this->render('create', array(
            'model' => $promoter,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $promoter = $this->loadModel($id);
        $transaction = $promoter->dbConnection->beginTransaction();

        $this->performAjaxValidation($promoter);

        if (isset($_POST['Promoter'])) {
            $promoter->attributes = $_POST['Promoter'];
            $promoter->bindRelatedParams($_POST['User']);

            $modelImage = new ModelImage($promoter);
            if ($modelImage->save()) {
                $transaction->commit();
                $this->redirect(array('view', 'id' => $promoter->id));
            } else {
                $transaction->rollback();
            }
        }

        $this->render('update', array(
            'model' => $promoter,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $promoter = $this->loadModel($id);
        $transaction = $promoter->dbConnection->beginTransaction();

        $modelImage = new ModelImage($promoter);
        if ($modelImage->delete()) {
            $transaction->commit();
            if (!isset($_GET['ajax'])) $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else {
            $transaction->rollback();
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Promoter');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $promoter = new Promoter('search');
        $promoter->unsetAttributes(); // clear any default values
        if (isset($_GET['Promoter'])) {
            $promoter->attributes = $_GET['Promoter'];
        }

        $this->layout = 'index';
        $this->render('admin', array(
            'model' => $promoter,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CActiveRecord the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Promoter::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }
}
