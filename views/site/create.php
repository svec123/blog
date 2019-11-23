<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-content">
    <div class="container">
        <div class="row">

<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('article/_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
</div>

