<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "main_table".
 *
 * @property int $id
 * @property int $count
 * @property string $email
 * @property string $fio
 * @property int $create
 */
class MainTable extends \yii\db\ActiveRecord
{
    /**
     * @return string table name
     */
    public static function tableName()
    {
        return 'main_table';
    }
    /**
     * @return array rules for fields
     */
    public function rules()
    {
        return [
            [['count', 'create'], 'integer'],
            [['email', 'fio'], 'string', 'max' => 255],
        ];
    }
    /**
     * @return array field names of table
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => 'Count',
            'email' => 'Email',
            'fio' => 'Fio',
            'create' => 'Create',
        ];
    }
}
