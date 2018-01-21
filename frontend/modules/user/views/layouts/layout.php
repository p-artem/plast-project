<?php

use frontend\widgets\SiteBreadcrumbs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/main.php')
?>
<div class="container">
    <?= SiteBreadcrumbs::widget(['links' => [['breadUrl' => Url::current([],true), 'label' => $this->title]]]) ?>
    <div class="top-margin"></div>
</div>
<div class="container">
    <?php echo $content ?>
</div>
<?php $this->endContent() ?>