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
    }
    /**
     * Revert migration
     * @return void
     */
    public function down()
    {
        $this->dropTable($this->table);
    }

}