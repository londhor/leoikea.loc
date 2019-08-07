<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m190714_093433_articles_multilang
 */
class m190714_093433_articles_multilang extends Migration
{
    protected $article = '{{%article}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn($this->article, 'title', 'title_ua');
        $this->renameColumn($this->article, 'meta_title', 'meta_title_ua');
        $this->renameColumn($this->article, 'meta_description', 'meta_description_ua');
        $this->renameColumn($this->article, 'body', 'body_ua');

        $this->addColumn($this->article, 'title_ru', $this->string(255)->notNull()->after('title_ua'));
        $this->addColumn($this->article, 'meta_title_ru', $this->string(255)->null()->after('meta_title_ua'));
        $this->addColumn($this->article, 'meta_description_ru', $this->string(500)->null()->after('meta_description_ua'));
        $this->addColumn($this->article, 'body_ru', $this->text()->notNull()->after('body_ua'));

        $this->update($this->article, [
            'title_ru' => new Expression('title_ua'),
            'meta_title_ru' => new Expression('meta_title_ua'),
            'meta_description_ru' => new Expression('meta_description_ua'),
            'body_ru' => new Expression('body_ua'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->article, 'title_ru');
        $this->dropColumn($this->article, 'meta_title_ru');
        $this->dropColumn($this->article, 'meta_description_ru');
        $this->dropColumn($this->article, 'body_ru');

        $this->renameColumn($this->article, 'title_ua', 'title');
        $this->renameColumn($this->article, 'meta_title_ua', 'meta_title');
        $this->renameColumn($this->article, 'meta_description_ua', 'meta_description');
        $this->renameColumn($this->article, 'body_ua', 'body');
    }
}
