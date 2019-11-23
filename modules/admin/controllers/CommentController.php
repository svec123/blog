<?php
namespace app\modules\admin\controllers;
use app\models\Comment;
use yii\web\Controller;
use Yii;
class CommentController extends Controller
{
    public function actionIndex()
    {

        if( Yii::$app->user->identity->isAdmin == 1) {

        $comments = Comment::find()->orderBy('id desc')->all();
        
        return $this->render('index',['comments'=>$comments]);

       } else {
        Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
            //для перестраховки вернем false
            return false;
    }
    }
    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);
        if($comment->delete())
        {
            return $this->redirect(['comment/index']);
        }
    }
    public function actionAllow($id)
    {
        $comment = Comment::findOne($id);
        if($comment->allow())
        {
            return $this->redirect(['index']);
        }
    }
    
    public function actionDisallow($id)
    {
        $comment = Comment::findOne($id);
        if($comment->disallow())
        {
            return $this->redirect(['index']);
        }
    }
}