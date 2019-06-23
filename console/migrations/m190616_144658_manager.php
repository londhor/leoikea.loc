<?php

use yii\db\Migration;

/**
 * Class m190616_144658_manager
 */
class m190616_144658_manager extends Migration
{
    protected $manager = '{{%manager}}';

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

        $this->createTable($this->manager, [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(45)->notNull(),
            'email' => $this->string(255)->notNull(),
            'password_hash' => $this->string(60)->notNull(),
            'auth_key' => $this->string(64)->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_manager__email', $this->manager, 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_manager__email', $this->manager);

        $this->dropTable($this->manager);
    }
}
