<?php
namespace app\modules\admin;
use Yii;
use yii\filters\AccessControl;
/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $layout = '/admin';
    
    public $controllerNamespace = 'app\modules\admin\controllers';
    /**
     * @inheritdoc
     */
  
    public function behaviors()
    {

        if ( // Yii::$app->user->id == $article->user_id   
            1 == 1 ) {
                 

        return [
            'access'    =>  [
                'class' =>  AccessControl::className(),
                'denyCallback'  =>  function($rule, $action)
                {
                    throw new \yii\web\NotFoundHttpException();
                },
                'rules' =>  [
                    [
                        'allow' =>  true,
                        'matchCallback' =>  function($rule, $action)
                        {
                            return Yii::$app->user->identity->isAdmin;
                        }
                    ]
                ]
            ]
        ]; } else {
          echo  Yii::$app->request->get('id');  
            echo 123;
        }
    } 
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}