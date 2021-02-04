<?php


namespace app\models;


use yii\db\ActiveRecord;

class UserZadarma extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_accounts';
    }
}