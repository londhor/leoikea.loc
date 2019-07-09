<?php

use yii\db\Migration;

/**
 * Class m190623_045239_our_clients
 */
class m190623_045239_our_clients extends Migration
{
    protected $our_clients = '{{%our_clients}}';

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

        $this->createTable($this->our_clients, [
            'id' => $this->primaryKey()->unsigned(),
            'image' => $this->string(255)->notNull(),
            'sort_order' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('idx_our_clients__sort_order', $this->our_clients, 'sort_order');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_our_clients__sort_order', $this->our_clients);

        $this->dropTable($this->our_clients);
    }
}
