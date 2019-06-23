<?php

namespace backend\components;

use yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class Controller extends yii\web\Controller
{
    public $saveRedirectUrl = [

    ];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => ['site'],
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     * @throws yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!Yii::$app->request->isAjax && !Yii::$app->request->isPost) {
                Yii::$app->user->setReturnUrl(Url::current());
            }

            return true;
        }

        return false;
    }

    /**
     * @param array $options
     * @return yii\web\Response
     */
    protected function modelSuccess($options)
    {
        $refreshAction = ArrayHelper::remove($options, 'refreshAction', Url::current());
        $createAction = ArrayHelper::remove($options, 'createAction', [$this->action->uniqueId]);

        $previousAction = ArrayHelper::remove($options, 'previousAction', $this->uniqueId . '/index');
        $previousAction = $this->previousUrl($previousAction);

        $afterSave = Yii::$app->request->post('afterSave');

        switch ($afterSave) {
            case 'saveAndClose':
                $redirectUrl = $previousAction;
                break;
            case 'saveAndCreate':
                $redirectUrl = $createAction;
                break;
            default:
                $redirectUrl = $refreshAction;
                break;
        }

        if (Yii::$app->request->isAjax) {
            $responseData = ArrayHelper::merge([
                'status' => 'success',
                'redirect' => Url::to($redirectUrl),
            ], $options);

            $response = $this->asJson($responseData);
        } else {
            $response = $this->redirect($redirectUrl);
        }

        return $response;
    }

    /**
     * @param null $message
     */
    protected function modelError($message = null)
    {
        if ($message === null) {
            $message = 'Перевірте форму на помилки!';
        }

        if (Yii::$app->request->isAjax) {
            $response = $this->asJson([
                'status' => 'error',
                'message' => $message,
            ]);

            Yii::$app->end(0, $response);
        }

        Yii::$app->session->addFlash('error', $message);
    }

    /**
     * @param string $action
     * @return string
     */
    protected function rememberKey($action)
    {
        return '__returnTo{' . $action . '}';
    }

    /**
     * Remember current url
     */
    protected function remember()
    {
        Url::remember(Url::current(), $this->rememberKey($this->action->uniqueId));
    }

    /**
     * @param string $action
     * @return array|null|string
     */
    protected function previousUrl($action)
    {
        $action = $this->normalizeRoute($action);

        if (($previous = Url::previous($this->rememberKey($action))) === null) {
            $previous = [$action];
        }

        return $previous;
    }

    /**
     * @param string $action
     * @return yii\web\Response
     */
    protected function previous($action)
    {
        return $this->redirect($this->previousUrl($action));
    }

    /**
     * @param string $route
     * @return string
     */
    protected function normalizeRoute($route)
    {
        if (strpos($route, '/') === false) {
            $route = $this->uniqueId . '/' . $route;
        }

        return $route;
    }
}