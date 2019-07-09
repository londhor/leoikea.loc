<?php

use yii\db\Migration;

/**
 * Class m190623_044757_shop_reviews
 */
class m190623_044757_shop_reviews extends Migration
{
    protected $reviews = '{{%reviews}}';

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

        $this->createTable($this->reviews, [
            'id' => $this->primaryKey()->unsigned(),
            'image' => $this->string(255)->notNull(),
            'active' => $this->boolean(),
            'sort_order' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('idx_reviews__sort_order', $this->reviews, 'sort_order');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_reviews__sort_order', $this->reviews);

        $this->dropTable($this->reviews);
    }
}
