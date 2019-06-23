<?php

use yii\db\Migration;

/**
 * Class m190617_224829_article
 */
class m190617_224829_article extends Migration
{
    protected $article = '{{%article}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        } else {
            $tableOptions = null;
        }

        $this->createTable($this->article, [
            'id' => $this->primaryKey()->unsigned(),
            'slug' => $this->string(100),
            'title' => $this->string(255)->notNull(),
            'meta_title' => $this->string(255)->null(),
            'meta_description' => $this->string(500)->null(),
            'body' => $this->text()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_article__slug', $this->article, 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_article__slug', $this->article);

        $this->dropTable($this->article);
    }
}
