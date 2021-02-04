<?php

namespace app\controllers;

use app\models\UserZadarma;
use Yii;
use app\models\Call;
use app\models\CallSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Zadarma_API\Client;

/**
 * CallController implements the CRUD actions for Call model.
 */
class CallController extends Controller
{
    protected $key = 'key';
    protected $secret = 'secret';

    public function actionGetCalls()
    {
        $params = array(
            'start' => '2020-06-02 00:00:00',
            'end' => '2020-07-01 00:00:00'
        );
        $zadarma = new Client($this->key,$this->secret);
        $answer =Json::decode($zadarma->call('/v1/statistics/', $params, 'get'));

        foreach ($answer['stats'] as $k => $v) {
            //проверить есть ли телефон в user_account
            $user = UserZadarma::findOne(['phone'=>$v['to']]);
            if (!$user) {
                //если нет, то добавить запись в user_account  и сохранить в в user_calls
                $user = new UserZadarma();
                $user->role = 'user';
                $user->phone = $v['to'];
                $user->sip_id = $v['sip'];
                $user->save();
            }
            //id ментора нужно найти в таблице users
            $menthor = UserZadarma::findOne(['role'=>'mentor','sip_id'=>$v['sip']]);
            //сохранить звонок
            $calls = new Call();
            $calls->account_id = $user->id;
            $calls->call_id = $v['id'];
            $calls->mentor_id = $menthor->id;
            $calls->sip_id = $v['sip'];
            $calls->from = $v['from'];
            $calls->to = $v['to'];
            $calls->created_at = $v['callstart'];
            $calls->save();
        }
        return $this->render('calls',compact('answer'));
    }
    public function actionClearUserCalls()
    {
        Call::deleteAll();
    }



    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Call models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CallSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Call model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id = 0)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Call model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Call();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->account_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Call model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->account_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Call model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Call model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Call the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Call::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
