<?php
namespace app\modules\admin;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\widgets\LinkPager; 
use yii\helpers\Html;
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

        if (Yii::$app->user->id == 1750266815) {
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
        ]; 

    }else {
    foreach($articles as $article):
          if ( Yii::$app->user->id == $article->getId()){
     } else {
         echo 'eror';
     }endforeach;
    }
     
    }
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}