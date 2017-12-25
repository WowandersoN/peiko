<?php

use yii\db\Migration;

/**
 * Class m171225_190140_peiko
 */
class m171225_190140_peiko extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171225_190140_peiko cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $tableOptions_mssql = "";
        $tableOptions_pgsql = "";
        $tableOptions_sqlite = "";
        /* MYSQL */
        if (!in_array('channels', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%channels}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'url' => 'VARCHAR(255) NOT NULL',
                    'created_at' => 'INT(11) NOT NULL',
                ], $tableOptions_mysql);
            }
        }

        /* MYSQL */
        if (!in_array('news', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%news}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'short_text' => 'VARCHAR(255) NOT NULL',
                    'long_text' => 'TEXT NOT NULL',
                    'small_img' => 'VARCHAR(255) NOT NULL',
                    'img' => 'VARCHAR(255) NOT NULL',
                    'guid' => 'VARCHAR(255) NOT NULL',
                    'link' => 'TEXT NULL',
                    'type' => 'TINYINT(1) NOT NULL',
                    'created_at' => 'INT(11) NOT NULL',
                ], $tableOptions_mysql);
            }
        }


        $this->createIndex('idx_UNIQUE_url_8797_00','channels','url',1);
        $this->createIndex('idx_type_8814_01','news','type',0);
        $this->createIndex('idx_created_at_8814_02','news','created_at',0);
        $this->createIndex('idx_guid_8814_03','news','guid',0);
        $this->createIndex('idx_UNIQUE_username_4427_04','user','username',1);
        $this->createIndex('idx_UNIQUE_email_4427_05','user','email',1);
        $this->createIndex('idx_UNIQUE_password_reset_token_4427_06','user','password_reset_token',1);

        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%user}}',['id'=>'1','username'=>'admin','auth_key'=>'_zcx77RvLV8LqNpfdY6Mf_PmGQNX2m7Y','password_hash'=>'$2y$13$zCR2bVGZeiOvjqRojJ6I0umEw5ZqTD/0k9K0/deUdYSLWirAZzqVW','password_reset_token'=>'','email'=>'vvieklich@mail.ru','status'=>'10','created_at'=>'1514229200','updated_at'=>'1514229200']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `channels`');
        $this->execute('SET foreign_key_checks = 1;');
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `news`');
        $this->execute('SET foreign_key_checks = 1;');
    }

}
