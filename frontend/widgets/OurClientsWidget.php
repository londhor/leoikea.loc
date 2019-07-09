<?php

namespace frontend\widgets;

use common\models\OurClients;
use yii\base\Widget;

class OurClientsWidget extends Widget
{
    public function run()
    {
        $ourClients = OurClients::find()
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        if (!$ourClients) {
            return '';
        }

        return $this->render('our-clients', [
            'ourClients' => $ourClients,
        ]);
    }
}