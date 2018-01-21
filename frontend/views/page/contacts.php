<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 * @var $contactForm \frontend\models\ContactForm
 * @var $employers \common\models\Employee[]
 */

use yii\helpers\Url;

$this->params['breadcrumbs'] = $model->breadcrumbs();
$this->params['activeMenu'] = ['route'=>'page/view', 'slug' => $model->slug];
$this->title = $model->metatitle ?: $model->name;
$this->registerMetaTag(['name' => 'description', 'content' => $model->metadesc ?: $model->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->metakeys ?: $model->name]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
?>

<div class="container">
    <section class="g-map">
        <div class="row">
            <div class="col-md-12">
                <div class="google-map">
                    <div id="map-canvas"></div>
                </div>
            </div>
        </div>
    </section>

    <a class='get-route btn btn-black' href="https://www.google.com.ua/maps/dir/Current+Location/<?= Yii::$app->appSettings->settings->google_location ?>" target="_blank">
        <?=Yii::t('site', 'How to get there?')?>
    </a>

    <section class="contact-address bg-white">
        <div class="row">

            <div class="col-md-4 col-xs-12">
                <div class="address-info">
                    <div class="row">
                        <div class="col-md-3 col-xs-3">
                            <div class="address-info-icon text-center center-block bg-light-gray">
                                <i class="fa fa-map-marker"></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-xs-9 address-info-desc">
                            <h3><?= Yii::t('site', 'Office Address') ?></h3>
                            <p>
                               <?= Yii::$app->appSettings->settings->address ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <div class="address-info">
                    <div class="row">
                        <div class="col-md-3 col-xs-3">
                            <div class="address-info-icon text-center center-block bg-light-gray">
                                <i class="fa fa-phone"></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-xs-9 address-info-desc">
                            <h3><?= Yii::t('site', 'Phone Number') ?></h3>
                            <p>
                                <?= Yii::$app->appSettings->settings->phone ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <div class="address-info">
                    <div class="row">
                        <div class="col-md-3 col-xs-3">
                            <div class="address-info-icon text-center center-block bg-light-gray">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-xs-9 address-info-desc">
                            <h3><?= Yii::t('site', 'Email Address') ?></h3>
                            <p>
                                <?= Yii::$app->appSettings->settings->email ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="contact-form">
        <div class="headline text-center">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="section-title"><?= Yii::t('site', 'Contact Us') ?></h2>
                    <p class="section-sub-title">
                        <?= Yii::t('site', ' If you have any questions or comments
                        <br/>please complete this form')?>
                    </p>
                </div>
            </div>
        </div>
        <?=$this->render('/contact/contact-us', ['contactForm' => $contactForm, 'status' => false])?>
    </section>

</div>


<?php
$x = Yii::$app->appSettings->settings->coordinate_x;
$y = Yii::$app->appSettings->settings->coordinate_y;
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyATQWKgCLGyp6RIpaQRRAwFUd-mb99fEL8&callback=initMap', ['async' => true, 'defer' => true]);
$this->registerJs(<<<JS
function initMap() {
        var uluru = {lat: {$x}, lng: {$y}};
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
          zoom: 16,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
    }
JS
, \yii\web\View::POS_HEAD);
?>



