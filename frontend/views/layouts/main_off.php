<?php
/* @var $this \yii\web\View */
/* @var $content string*/

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->

<html class="no-js"> <!--<![endif]-->
<head>

    <title><?= Yii::$app->name ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
<div id="error-page">
    <!-- fix the height of the whole content -->
    <div id="height-fix" class="text-center">

        <!--   header section begin   -->
        <section class="header bg-light-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="row">

                            <div class="logo" style="margin-top: 80px;">
                                <img class="img-responsive center-block" src="/img/main_logo.png">
                            </div> <!-- /.logo -->
                        </div>
                    </div> <!-- /.col-md-6 col-md-offset-3 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section> <!--   header section end   -->


       <?= $content ?>

        <!--   footer section begin   -->
        <section class="footer bg-light-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="row">
                            <div class="error-page-btn">

                            </div><!-- /.error-page-btn -->
                        </div>
                    </div> <!-- .col-md-6 col-md-offset-3 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section> <!--   footer section end   -->


    </div> <!-- /#height fix -->
</div> <!-- /#error-page  -->

<script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/wow.min.js"></script>
<script type="text/javascript" src="/js/script.js"></script>

<!-- wow initialization -->
<script>
    new WOW().init();
</script>

</body>
</html>
