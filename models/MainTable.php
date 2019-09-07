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
     * Сохранение данных
     * @return string
     */
    public function saveData()
    {
        $post = Yii::$app->request->post();
        $error_code = Yii::$app->params['errorCodes'];
        if($post) {
            $json_obj = json_decode($post['json']);
            if($json_obj->email == '') {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => $error_code['emptyEmail'],
                    ],
                ]);
            } elseif ($json_obj->email != '' && preg_match("/^[\w\.\d-_]+@[\w\.\d-_]+\.\w{2,4}$/i", $json_obj->email)) {
                $email = $json_obj->email;
            } else {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => $error_code['wrongEmail'],
                    ],
                ]);
            }

            if($json_obj->fio == '') {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => $error_code['emptyFio'],
                    ],
                ]);
            } elseif ($json_obj->fio != '' && preg_match("/^[A-Za-z]+\s?[A-Za-z]*\s*[A-Za-z]*$/i", $json_obj->fio)) {
                $fio = $json_obj->fio;
            } else {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => $error_code['wrongFio'],
                    ],
                ]);
            }

            $test_exists = MainTable::findOne(['email' => $email]);
            if($test_exists) {
                return json_encode([
                    'error' => true,
                    'data' => [
                        'resultErrorCode' => $error_code['existsEmail'],
                    ],
                ]);
            } else {
                $connection = \Yii::$app->db;
                $sql = "CALL sp_SaveData(". $json_obj->rangeList .", '" . $email . "', '" . $fio . "', @result)";
                $result = $connection->createCommand($sql)->queryOne();
                return json_encode([
                    'error' => false,
                    'data' => [
                        'resultErrorCode' => $error_code['dataSuccess'],
                        'result' => $result['result'],
                    ],
                ]);
            }
        } else {
            return json_encode([
                'error' => true,
                'data' => [
                    'resultErrorCode' => $error_code['wrongPostData'],
                ],
            ]);
        }

    }






}
