<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use frontend\components\ContentSettings;
use frontend\components\MetaFieldsSettings;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        ];
    }


    public function beforeAction($action) {
        if($action->id == 'index' && isset($_GET['payment_status']) && isset($_POST['order_status'])) {

            Yii::$app->request->enableCsrfValidation = false;

            include '../web/js/ajax/bootstrap.php';
            updatePaymentStatus($_POST);
        }
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var MetaFieldsSettings $metaFieldsSettings */
        $this->enableCsrfValidation = false;
        $metaFieldsSettings = Yii::$app->metaFieldsSettings;
        $metaFieldsSettings->generateForHome();

        return $this->render('index');
    }

    /**
     * @return mixed
     */
    public function actionContacts()
    {
        /** @var MetaFieldsSettings $metaFieldsSettings */
        $metaFieldsSettings = Yii::$app->metaFieldsSettings;
        $metaFieldsSettings->generateForContacts();

        $addresses = $this->contentSettings()->getAddresses();
        $phones = $this->contentSettings()->getPhones();
        $emails = $this->contentSettings()->getEmails();
        $socialLinks = $this->contentSettings()->getSocials();
        $articles = $this->contentSettings()->getFooterArticles();

        return $this->render('contacts', [
            'addresses' => $addresses,
            'phones' => $phones,
            'emails' => $emails,
            'socials' => $socialLinks,
            'articles' => $articles,
        ]);
    }

    /**
     * @return ContentSettings
     */
    protected function contentSettings()
    {
        return Yii::$app->contentSettings;
    }

    /**
     * Displays blog page.
     */
  public function actionBlog()
    {
        return $this->render('blog');
    }
}
