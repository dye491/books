<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\Book;
use app\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($point_id, $user_id)
    {
        $model = new Book();
        $model->point_id = $point_id;
        $model->user_id = $user_id;

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($imagePath = $model->upload()) {
                $model->imagePath = $imagePath;
            }
            if ($model->save(true, $model->attributes())) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Book model.
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
     * Changes book status and user_id
     * @param $id
     * @return string
     */
    public function actionTake($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->user->getIsGuest()) {
            /**
             * @var $user User
             */
            $user = User::findIdentity(Yii::$app->user->id);
            if ($model->status != Book::STATUS_FREE) {
                Yii::$app->session->setFlash('warning', 'Нельзя взять, книга на руках!');
            } elseif (($count = count($user->books)) >= Yii::$app->params['maxBookCount']) {
                Yii::$app->session->setFlash('warning', "Нельзя взять, у Вас на руках уже $count книг!");
            } else {
                if ($model->take($user->id)) {
                    Yii::$app->session->setFlash('success', 'Вы взяли эту книгу!');
                } else {
                    Yii::$app->session->setFlash('error',
                        'Ошибка! Книгу взять не удалось, повторите попытку или обратитесь в техподдержку');
                }
            }
        }

        return $this->redirect(['/book/view', 'id' => $model->id]);
        /*        return $this->render('view', [
                    'model' => $model,
                ]);*/
    }

    public function actionFree($id)
    {
        $model = $this->findModel($id);

        /**
         * @var $user User
         */
        if ($user = User::findIdentity(Yii::$app->user->id)) {
            if ($model->user_id == $user->id) {
                if ($model->free()) {
                    Yii::$app->getSession()->setFlash('success', 'Книга возвращена!');
                } else {
                    Yii::$app->getSession()->setFlash('error',
                        'Ошибка! Книга не возвращена, повторите попытку или обратитесь в техподдержку');
                }
            } else {
                Yii::$app->getSession()->setFlash('warning', 'Вы не брали эту книгу!');
            }
        }

        return $this->redirect(['/book/view', 'id' => $model->id]);
        /*        return $this->render('view', [
                    'model' => $model,
                ]);*/
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
