<?php
use yii\helpers\Url;
use yii\widgets\LinkPager; 
?>

<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <div class="sorting">
            
         
            </div>


               

            <?php foreach($articles as $article):?>
                
                <article class="post">
                    <div class="post-thumb">
                        <a href="<?= Url::toRoute(['site/view','id'=>$article->id]); ?>"><img src="<?= $article->getImage(); ?>" alt=""></a>

                        <a href="<?= Url::toRoute(['site/view','id'=>$article->id]); ?>" class="post-thumb-overlay text-center">
                            <div class="text-uppercase text-center">View Post</div>
                        </a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute(['site/category','id'=>$article->category->id])?>"> <?= $article->category->title ?> </a></h6>

                            <h1 class="entry-title"><a href="<?= Url::toRoute(['site/view','id'=>$article->id]); ?>"><?= $article->title; ?></a></h1>


                        </header>
                        <div class="entry-content">
                            <p><?= $article->description ?>
                            </p>

                            <div class="btn-continue-reading text-center text-uppercase">
                                <a href="<?= Url::toRoute(['site/view','id'=>$article->id]); ?>" class="more-link">Continue Reading</a>
                            </div>
                        </div>  
                        <div class="social-share">
                            <span class="social-share-title pull-left text-capitalize">
                                 Author:  <?= $article->author; ?> <br>Date:  <?= $article->getDate();?> </span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li><?=(int) $article->viewed?>
                            </ul>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                
             
              <?php 
                echo LinkPager::widget([
                    'pagination' =>$pagination,
                ]);
              ?>
            </div>
        
            
            <?= $this->render('/partials/filter',[
               
            ]); ?>

            <!-- <div class="col-md-4">
                <div class="primary-sidebar">
                    
                    <div class="filter">

                       <div class=" filter-title"></div>

                        <div class="filter-date col-md-8 popular-img">Date
                        <input type="date" class="form-control" id="date" name="date" placeholder="Дата" required>
                        </div>


                        <div class="filter-author col-md-6 popular-img">
                            
                        Author
  <form>
   <p><input type="search" name="Author" placeholder="Введите автора" class=> 
   <input type="submit" value="Найти"></p>
  </form>

                        </div>
                            

                      

                    </div>
                  
                 
                </div>
            </div> -->
            <?= $this->render('/partials/sidebar',[
                'popular'=>$popular,
                'recent'=>$recent ,
                'categories' =>$categories
            ]); ?>
        </div>
    </div>
</div>
<!-- end main content-->
<!--footer start-->