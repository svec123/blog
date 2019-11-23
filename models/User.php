<?php
namespace app\models;
use Yii;
use yii\web\IdentityInterface;
use yii\data\Pagination;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $isAdmin
 * @property string $photo
 *
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
        ];
    }


    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
        ];
    }

    
    public function getAll(){
         // build a DB query to get all articles
         $query = User::find();
         // get the total number of articles (but do not fetch the article data yet)
         $count = $query->count();
         // create a pagination object with the total count
         $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);
         // limit the query using the pagination and retrieve the articles
         $users = $query->offset($pagination->offset)
             ->limit($pagination->limit)
             ->all();
        
         $data['users'] = $users;
         $useda['users'] = $users;
         $data['pagination'] = $pagination;
         
         return $useda;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    


    public static function findByEmail($email)
    {
        return User::find()->where(['email'=>$email])->one();
    }
    public function validatePassword($password)
    {
        return ($this->password == $password) ? true : false;
    }
    
    public function create()
    {
        return $this->save(false);
    }
    
    public function saveFromVk($uid, $name, $photo)
    {
        $user = User::findOne($uid);
        if($user)
        {
            return Yii::$app->user->login($user);
        }
        
        $this->id = $uid;
        $this->name = $name;
        $this->photo = $photo;
        $this->create();
        
        return Yii::$app->user->login($this);
    }
    public function getImage()
    {
        return $this->photo;
    }


    public static function getUserId($author){
        $authorArticles =  User::find()->where(['name'=>$author])->all();
        return ($authorArticles['0']->id);
    }

 
}