<?php
use yii\helpers\Html;
use common\models\Price;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<html lang="<?= Yii::$app->language ?>" class="no-js">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--	<link href="/favicon.png" rel="icon" sizes="16x16 32x32 48x48 64x64 96x96">-->

	<title><?= $this->title; ?></title>
	<?php $this->head() ?>
	<?= Html::csrfMetaTags() ?>

	<?= $this->render('_inline-style') ?>

    <?php $this->registerJsFile('/js/modernizr.custom.97074.js')?>


<!--	<script>-->
<!--		bz = {-->
<!--			cont: [],-->
<!--			pull: [],-->
<!--			ready: function(a) {-->
<!--				this.pull.push(a);-->
<!--			},-->
<!--			load: function(a) {-->
<!--				this.pull.push(a);-->
<!--			},-->
<!--			run: function() {-->
<!--				this.pull.forEach(function(item, i, arr) {-->
<!--					$(document).ready(item);-->
<!--				});-->
<!--			}-->
<!--		};-->
<!---->
<!--		var $ = function(a) {-->
<!--			bz.cont.push(a);-->
<!--			return bz;-->
<!--		};-->
<!---->
<!--		window.jQuery = $;-->
<!--	</script>-->
<!--    <script>-->
<!--        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){-->
<!--                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),-->
<!--            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)-->
<!--        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');-->
<!---->
<!--        ga('create', 'UA-42568511-9', 'earchstudio.com');-->
<!--        ga('send', 'pageview');-->
<!---->
<!--    </script>-->
</head>

<body>
	<?php $this->beginBody() ?>

<!--	<div class="loader" style="background-image: url()"></div>-->

		<?= $content ?>

	<?php $this->endBody() ?>

    <?php if(Yii::$app->appSettings->settings->price): ?>
        <div class="dws fixed">
            <div class="pulse">
                <div class="bloc" data-href="<?= \yii\helpers\Url::to(['/site/download'])?>"></div>
                <div class="phone"><i class="fa fa-download" aria-hidden="true"></i></div>
                <div class="text"><?= Yii::t('site', 'File') ?></div>
            </div>
        </div>
    <?php endif ?>
</body>

</html>
<?php $this->endPage() ?>