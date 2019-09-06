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
    /**
     *
     */
    public function saveData()
    {
        $post = Yii::$app->request->post();
        if($post) {
            $json_obj = json_decode($post['json']);

            if($json_obj->email == '') {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => 3,
                    ],
                ]);
            } elseif ($json_obj->email != '' && preg_match("/^[\w\.\d-_]+@[\w\.\d-_]+\.\w{2,4}$/i", $json_obj->email)) {
                $email = $json_obj->email;
            } else {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => 4,
                    ],
                ]);
            }

            if($json_obj->fio == '') {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => 1,
                    ],
                ]);
            } elseif ($json_obj->fio != '' && preg_match("/^[A-Za-z]+\s?[A-Za-z]*\s*[A-Za-z]*$/i", $json_obj->fio)) {
                $fio = $json_obj->fio;
            } else {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => 2,
                    ],
                ]);
            }

            $test_exists = MainTable::findOne(['email' => $email]);
            if($test_exists) {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => 5,
                    ],
                ]);
            } else {
                $connection = \Yii::$app->db;
                $sql = "CALL sp_SaveData(7, '" . $email . "', '" . $fio . "', @result)";
                $result = $connection->createCommand($sql)->queryScalar();
                return json_encode([
                    'error' => false,
                    'data' => [
                        'resultErrorCode' => 0,
                        'result' => $result,
                    ],
                ]);
            }
        } else {
            return json_encode([
                'error' => true,
                'data' => [
                    'resultErrorCode' => 6,
                ],
            ]);
        }

    }






}
