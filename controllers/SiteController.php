<?php


namespace app\controllers;
use app\models\Article;
use app\models\User;
use app\models\Category;
use app\models\CommentForm;
use Yii;

use app\modules\admin\Module;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm; 
use app\modules\admin\views\article\update;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
         
        $data =  Article::getAll(2);
        $users = User::getAll();
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        // $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();
        // $recent = Article::find()->orderBy('date asc')->limit(4)->all();
        // $categories = Category::find()->all();

        
      
        return $this->render('index',[
            'articles'=>$data['articles'],
            'users'=>$users['users'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent ,
            'categories' =>$categories
        ]);
    }

    public function actionModelq()
    {
         
        $data =  Article::getAll(2);

        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        // $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();
        // $recent = Article::find()->orderBy('date asc')->limit(4)->all();
        // $categories = Category::find()->all();

        
      
        return $this->render('modelq',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent ,
            'categories' =>$categories
        ]);
    }


    public function actionModule()
    {
         
        $data =  Article::getAll(2);

        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        // $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();
        // $recent = Article::find()->orderBy('date asc')->limit(4)->all();
        // $categories = Category::find()->all();

        
      
        return $this->render('/../admin/module',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent ,
            'categories' =>$categories
        ]);
    }



    /**
     * Login action.
     *
     * @return Response|string
     */
 



    public function actionCategory($id){
        
        $data = Category::getArticlesByCategory($id);
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();

        return $this->render('category',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
        'recent'=>$recent ,
        'categories' =>$categories
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */




 
 

// public function actionSearch($q ){ 
//     $q = trim(Yii::$app->request->get('q'));
//     return $this->render('search');

//    }

public function actionSearch($q){ 
    $q = trim(Yii::$app->request->get('q')); 
        
            $data =  Article::getAll();

            $popular = Article::getPopular();
            $recent = Article::getRecent();
            $categories = Category::getAll();
            // $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();
            // $recent = Article::find()->orderBy('date asc')->limit(4)->all();
            // $categories = Category::find()->all();
    
            
          
            return $this->render('search',[
                'articles'=>$data['articles'],
                'pagination'=>$data['pagination'],
                'popular'=>$popular,
                'recent'=>$recent ,
                'categories' =>$categories
            ]);

        
   }

   
   public function actionView($id)
   {
     $article = Article::findOne($id);
     $popular = Article::getPopular();
     $recent = Article::getRecent();
     $categories = Category::getAll();
     $comments = $article->getArticleComments();
     $comments = $article->comments;
   
     $commentForm = new CommentForm();
   
     $article->viewedCounter();
   
   
       return $this->render('single', [
           'article'=>$article,
           'popular'=>$popular,
           'recent'=>$recent ,
           'categories' =>$categories,
           'comments'=>$comments,
           'commentForm'=>$commentForm
       ]);
   }
   

//    public function actionUserArticle($id)
//    {
//      $data =  Article::getAll(2);

//         $popular = Article::getPopular();
//         $recent = Article::getRecent();
//         $categories = Category::getAll();
//         // $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();
//         // $recent = Article::find()->orderBy('date asc')->limit(4)->all();
//         // $categories = Category::find()->all();

        
      
//         return $this->render('index',[
//             'articles'=>$data['articles'],
//             'pagination'=>$data['pagination'],
//             'popular'=>$popular,
//             'recent'=>$recent ,
//             'categories' =>$categories
//         ]);
//    }


    public function actionBlog()
    {
          
        
        $data =  Article::getAll(2);
        $users = User::getAll();
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        // $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();
        // $recent = Article::find()->orderBy('date asc')->limit(4)->all();
        // $categories = Category::find()->all();

        
      
        return $this->render('blog',[ 
            'articles'=>$data['articles'],
            'users'=>$users['users'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent ,
            'categories' =>$categories
        ]);

        
    }

      
    public function actionCreate()
    {
        $model = new Article();
        $data =  Article::getAll(2);
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'article'=>$article,
           'popular'=>$popular,
           'recent'=>$recent ,
           'categories' =>$categories,
           'comments'=>$comments,
           'commentForm'=>$commentForm
        ]);
        

       
    }


       public function actionComment($id)
    {
        $model = new CommentForm();
        
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->saveComment($id))
            {
                Yii::$app->getSession()->setFlash('comment', 'Your comment will be added soon!');
                return $this->redirect(['site/view','id'=>$id]);
            }
        }
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
