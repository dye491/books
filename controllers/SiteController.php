<?php

namespace app\controllers;

use app\models\RegistrationForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->register()) {
                try {
                    $email = \Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                        ->setSubject('Подтверждение регистрации')
                        ->setHtmlBody('Ссылка для подтверждения регистрации: ' . Html::a('Подтвердить',
                                Yii::$app->urlManager->createAbsoluteUrl(
                                    ['site/confirm', 'id' => $user->id, 'key' => $user->authKey]
                                ))
                        )
                        ->send();

                    if ($email) {
                        Yii::$app->getSession()->setFlash('success', 'На ваш электронный адрес выслано письмо для подтверждения регистрации');
                    }
                } catch (\Exception $exception) {
                    Yii::$app->getSession()->setFlash('warning', 'Ошибка регистрации. Попробуйте ещё раз или обратитесь в службу поддержки.');
                    User::deleteAll(['id' => $user->id]);
                }
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionConfirm($id, $key)
    {
        $user = User::find()->where([
            'id'       => $id,
            'authKey' => $key,
            'status'   => 0,
        ])->one();

        if (!empty($user)) {
            $user->status = User::STATUS_ACTIVE;
            $user->save();
            \Yii::$app->getSession()->setFlash('success', 'Вы успешно активировали ваш аккаунт');
        } else {
            \Yii::$app->getSession()->setFlash('warning', 'Ошибка подтверждения');
        }

        return $this->goHome();
    }
}
