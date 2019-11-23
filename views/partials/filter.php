   <?php
use yii\helpers\Url;
use yii\widgets\LinkPager;  

use yii\db\ActiveRecord;
?>
    <div class="col-md-4 " >
                <div class="primary-sidebar">
                    
                    <div class="filter">

                       <div class=" filter-title"></div>
                        <div class="filter-date col-md-8 popular-img"><h5>Date </h5>
                        <form method="get"  action="<?= Url::toRoute(['site/search']);?>" >
                        <input type="date" class="form-control" id="date"  name="dater" placeholder="Дата" >
                       <h5> Author </h5>
                        <input type="search"  name="q"   placeholder="Введите автора"> 
                         <input  type="submit" class="btn btn-success"  value="Найти"></p>
                      
                         <p>
                         </form>
  

                        </div>
                            

                      

                    </div>
                  
                 
                </div>
            </div> 