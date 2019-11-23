<?php
       


       namespace app\modules\admin\controllers;
       use app\models\Category;
       use app\models\ImageUpload;
       use app\models\Tag;
       use Yii;
       use app\models\Article;
       use app\models\User;
       use app\models\ArticleSearch;
       use yii\helpers\ArrayHelper;
       use yii\web\Controller;
       use yii\web\NotFoundHttpException;
       use yii\filters\VerbFilter;
       use yii\web\UploadedFile;
       

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        if( Yii::$app->user->identity->isAdmin == 1) {
            
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } else {
        Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
            //для перестраховки вернем false
            return false;
    }
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $data =  Article::getAll();
        $useda =  User::getAll();
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $this->findModel($id), 
            'users' =>$useda['users'] ,
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent ,
            'categories' =>$categories
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

         
        $data =  Article::getAll();
        $useda =  User::getAll();
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'users' =>$useda['users'] ,
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent ,
            'categories' =>$categories
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionSetImage($id)
    {

    $model = new ImageUpload;

    if(Yii::$app->request->isPost)
    
    {


        $article = $this->findModel($id);
       
        $file = UploadedFile::getInstance($model,'image');
       
  
        // var_dump( );die;

        if( $article->saveImage($model->uploadFile($file  , $article->image)))
        {
            return $this->redirect(['view','id'=>$article->id]);
        }
    }


    return $this->render('image' , ['model'=>$model]);
   
}


public function actionSetCategory($id)
{

    // $category = Category::findOne(1);
    // var_dump($category->articles);die;

    $article = $this->findModel($id);
//    var_dump($article->title);

    $article = $this->findModel($id);
    $selectedCategory = $article->category->id;
    $categories =ArrayHelper::map(Category::find()->all() , 'id' , 'title');
   
    if(Yii::$app->request->isPost)
    {
        $category = Yii::$app->request->post('category');
        if ($article->saveCategory($category))
        {
           return $this->redirect(['view' , 'id'=>$article->id]);
           }
        } 


    return $this->render('category', [
        'article'=>$article,
        'selectedCategory' => $selectedCategory , 
        'categories' =>$categories
    ]);

}


public function actionSetTags($id )
{
    $article = $this->findModel($id);
    $selectedTags = $article->getSelectedTags(); //
    $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
    if(Yii::$app->request->isPost)
    {
        $tags = Yii::$app->request->post('tags');
        $article->saveTags($tags);
        return $this->redirect(['view', 'id'=>$article->id]);
    }
    
    return $this->render('tags', [
        'selectedTags'=>$selectedTags,
        'tags'=>$tags
    ]);
}
}


