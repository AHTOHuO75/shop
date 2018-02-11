<?php

use yii\db\Migration;

/**
 * Class m171126_135151_change_user_fields_requirements
 */
class m171126_135151_change_user_fields_requirements extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('{{%user}}', 'username', $this->string());
        $this->alterColumn('{{%user}}', 'password_hash', $this->string());
        $this->alterColumn('{{%user}}', 'email', $this->string());
    }


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('{{%user}}', 'username', $this->string()->notNull());
        $this->alterColumn('{{%user}}', 'password_hash', $this->string()->notNull());
        $this->alterColumn('{{%user}}', 'email', $this->string()->notNull());
    }


}
