<?php


namespace app\models;


use yii\db\ActiveRecord;

class Call extends  ActiveRecord
{
    public static function tableName()
    {
        return 'user_calls';
    }

    public function rules()
    {
        return [
            ['call_id','unique']
        ];

    }
}