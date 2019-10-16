<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;



/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['title'],'required'],
        [['title','description','content'],'string'],
        [['date'],'date','format'=>'php:Y-m-d'],
        [['date'],'default','value'=>date('Y-m-d')],
        [['title'],'string','max'=>255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }
















    //     /**
//      * @return \yii\db\ActiveQuery
//      */
//     public function getArticleTags()
//     {
//         return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
//     }

//     /**
//      * @return \yii\db\ActiveQuery
//      */
//     public function getComments()
//     {
//         return $this->hasMany(Comment::className(), ['article_id' => 'id']);
//     }


 public function saveImage($filename){

    $this->image = $filename;
    return $this->save(false) ;
 } 

 
 public function getImage()
 {
     return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
 }

 public function deleteImage(   )

 {
     $imageUploadModel = new ImageUpload();
     $imageUploadModel->deleteCurrentImage($this->image);
 }

 public function beforeDelete()
 {
     $this->deleteImage();
     return parent::beforeDelete();
 }


 public function getCategory()
 {
     return $this->hasOne(Category::className(),['id' => 'category_id']);
 }

 public function saveCategory($category_id)
{
    $category = Category::findOne($category_id);
    if($category != null){
    $this->link('category' , $category);
    return true;                     
    }
 }


    public function getTags()
    {
        return $this->hasMany(Tag::className(),['id'=>'tag_id'])
        ->viaTable('article_tag', ['article_id'=>'id']);
    }

    

    // public function actionSetTags($id)
    // {
    //     $article = $this->findModel($id);
    //     var_dump($article->id);
    // }

      
    public function getSelectedTags()
    {
         $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }


    public function saveTags($tags)
    {
        if (is_array($tags))
        {
            $this->clearCurrentTags();
            foreach($tags as $tag_id)
            {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }


    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id'=>$this->id]);
    } 

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
      
    }

    public static function getAll($pageSize = 5)
    {
        
        // $data = Article::getAll();
        // $popular = Article::getPopular();
        // $recent = Article::getRecent();
        // $categories = Category::getAll();
        
        // return $this->render('index',[
        //     'articles'=>$data['articles'],
        //     'pagination'=>$data['pagination'],
        //     'popular'=>$popular,
        //     'recent'=>$recent,
        //     'categories'=>$categories
        // ]);
            

        $query = Article::find();

        $count = $query->count();

        $pagination = new Pagination(['totalCount'=>$count , 'pageSize'=>$pageSize]);

        $articles = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

        $data['articles'] = $articles;
        $data['pagination'] = $pagination;

        return $data;
    }

    public static function getPopular()
    {
        return Article::find()->orderBy('viewed desc')->limit(3)->all();
    }

    public static function getRecent()
    {
        return Article::find()->orderBy('date asc')->limit(4)->all();
    }

}
