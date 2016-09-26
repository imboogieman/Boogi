<?php

// @TODO: Consider refactoring to keep number of methods under 10
// @TODO: Replace $_GET and $_POST globals

class GigController extends Controller
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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'   => array('index', 'view', 'create', 'update', 'admin', 'delete', 'bookings'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Gig;
        $transaction = $model->dbConnection->beginTransaction();

        $this->performAjaxValidation($model);

        if (isset($_POST['Gig'])) {
            $model->attributes = $_POST['Gig'];
            $model->bindRelatedParams($_POST['ArtistGig']);

            $modelImage = new ModelImage($model);
            if ($modelImage->save()) {
                $transaction->commit();
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                $transaction->rollback();
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $transaction = $model->dbConnection->beginTransaction();

        $this->performAjaxValidation($model);

        if (isset($_POST['Gig'])) {
            $model->attributes = $_POST['Gig'];
            $model->bindRelatedParams($_POST['ArtistGig']);

            $modelImage = new ModelImage($model);
            if ($modelImage->save()) {
                $transaction->commit();
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                $transaction->rollback();
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $transaction = $model->dbConnection->beginTransaction();

        $modelImage = new ModelImage($model);
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
        $dataProvider = new CActiveDataProvider('Gig');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionBookings()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('ds_type', DataSource::STARWAY);

        $dataProvider = new CActiveDataProvider('Gig', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            )
        ));
        $this->render('bookings', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Gig('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Gig'])) {
            $model->attributes = $_GET['Gig'];
        }

        $this->layout = 'index';
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Gig the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Gig::model('Gig')->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Gig $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gig-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
