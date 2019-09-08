<?php
use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190906_102505_main_table
 */
class m190906_102505_main_table extends Migration
{
    /**
     * @var string $main_table
     */
    private $table = 'main_table';
    /**
     * Apply migration
     * @return void
     */
    public function up()
    {
        $this->createTable($this->table, [
            'id' => Schema::TYPE_PK,
            'count' => Schema::TYPE_INTEGER . '(5) NOT NULL DEFAULT 0',
            'email' => Schema::TYPE_CHAR . '(255) NOT NULL DEFAULT ""',
            'fio' => Schema::TYPE_CHAR . '(255) NOT NULL DEFAULT ""',
            'create' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0',
        ]);

        $sql = "DROP PROCEDURE IF EXISTS `sp_SaveData`; 
                CREATE DEFINER=`root`@`%` PROCEDURE `sp_SaveData`(IN `count` INT, IN `email` VARCHAR(255), IN `fio` VARCHAR(255), OUT `result` INT) 
                NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN INSERT INTO `main_table` (`id`, `count`, `email`, `fio`, `create`) VALUES (NULL, count, email, fio, UNIX_TIMESTAMP()); 
                SET result = count % 2; 
                SELECT result; 
                END";
        $this->execute($sql);
    }
    /**
     * Revert migration
     * @return void
     */
    public function down()
    {
        $this->dropTable($this->table);
        $sql = "DROP PROCEDURE IF EXISTS `sp_SaveData`";
        $this->execute($sql);
    }
}