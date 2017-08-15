<?php

namespace app\modules\users\models;

use app\models\Settings;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property integer $user_id
 * @property integer $group_id
 * @property string $username
 * @property string $password
 * @property string $password_input
 * @property string $email
 * @property string $authKey
 * @property string $accessToken
 */
class Users extends ActiveRecord
{

    public static $passwordSalt = 'my_salt784121$$%_';
    public $password_repeat;
    public $password_input;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id'], 'integer'],
            [['group_id'], 'default','value'=>Settings::get('core','default_group')],
            [['email'],'email'],
            [['email','username'],'unique'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password_input'],
            [['username', 'password_input','email','password_repeat'], 'required'],
            [['username'], 'string', 'max' => 25],
            [['password','accessToken','authKey','email','password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'   => Yii::t('app', 'User ID'),
            'group_id'  => Yii::t('app', 'Group ID'),
            'username'  => Yii::t('app', 'Username'),
            'password'  => Yii::t('app', 'Password'),
            'accessToken' => Yii::t('app', 'accessToken'),
            'authKey'   => Yii::t('app', 'authKey'),
        ];
    }

    /**
     * @inheritdoc
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function getUserById($id)
    {
        $user = Yii::$app->db->createCommand('SELECT * FROM {{%users}} p  where p.user_id=:id', [':id' =>$id])->queryOne();
        if($user)
            return self::generateOutputArray($user);
        else
            return null;
    }


    /**
     * @inheritdoc
     */
    public static function getUserByToken($accessToken)
    {
        $user = Yii::$app->db->createCommand('SELECT * FROM {{%users}} p  where p.accessToken=:accessToken', [':accessToken' =>$accessToken])->queryOne();
        if($user)
            return self::generateOutputArray($user);
        else
            return null;
    }


    /**
     * @inheritdoc
     */
    public static function getUserByEmail($email)
    {
        $user = Yii::$app->db->createCommand('SELECT * FROM {{%users}} p  where p.email=:email', [':email' =>$email])->queryOne();
        if($user)
            return self::generateOutputArray($user);
        else
            return null;
    }

    /**
     * @inheritdoc
     */
    public static function getUserByUsername($username)
    {
        $user = Yii::$app->db->createCommand('SELECT * FROM {{%users}} p  where p.username=:username', [':username' =>$username])->queryOne();
        if($user)
            return self::generateOutputArray($user);
        else
            return null;
    }


    private static function generateOutputArray($user){
        return [
            'id' => $user['user_id'],
            'username' => $user['username'],
            'group' => $user['group'],
            'password' => $user['password'],
            'authKey' => $user['authKey'],
            'accessToken' => $user['accessToken'],
            'email' => $user['email'],
        ];
    }
}
