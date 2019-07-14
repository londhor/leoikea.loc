<?php

/** @var $this \yii\web\View */
/** @var $article \common\models\Article */

use yii\helpers\Html;

?>
<article class="article page-article">
    <div class="container page-container">
        <h1 class="container-header"><?= Html::encode($article->titleLang) ?></h1>
        <div class="content page-content">
            <?= $article->bodyLang ?>
        </div>
    </div>
</article>