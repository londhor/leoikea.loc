<?php
namespace metronic\widgets;

use Yii;

/**
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 */
class Alert extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - key: the name of the session flash variable
     * - value: the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'message' => ['class' => '',              'icon' => 'la la-comment'],
        'error'   => ['class' => 'alert-danger',  'icon' => 'la la-code'],
        'danger'  => ['class' => 'alert-danger',  'icon' => 'la la-close'],
        'success' => ['class' => 'alert-success', 'icon' => 'la la-check'],
        'info'    => ['class' => 'alert-info',    'icon' => 'la la-exclamation-triangle'],
        'warning' => ['class' => 'alert-warning', 'icon' => 'la la-exclamation-triangle'],
        'brand'   => ['class' => 'alert-warning', 'icon' => 'la la-check-circle'],
    ];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $flash) {
            if (!isset($this->alertTypes[$type])) {
                continue;
            }

            foreach ((array) $flash as $i => $message) {
                echo $this->render('alert', [
                    'class' => $this->alertTypes[$type]['class'],
                    'icon' => $this->alertTypes[$type]['icon'],
                    'message' => $message,
                ]);
            }

            $session->removeFlash($type);
        }
    }
}
