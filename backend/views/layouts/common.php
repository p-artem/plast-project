<?php
/**
 * @var $this yii\web\View
 * @var $content string
 */
use backend\assets\BackendAsset;
use backend\widgets\Menu;
use common\models\TimelineEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\models\Contact;

$bundle = BackendAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/base.php'); ?>
    <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
        <header class="main-header">
            <a href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl('/') ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?= Yii::$app->name ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?= Yii::t('backend', 'Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li id="timeline-notifications" class="notifications-menu">
                            <a href="/admin/cache/flush-cache?id=frontendCache" title="Сбросить" data-confirm="Вы уверены, что хотите сбросить этот кеш?">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </li>
                        <li id="timeline-notifications" class="notifications-menu">
                            <a href="<?= Url::to(['/timeline-event/index']) ?>">
                                <i class="fa fa-bell"></i>
                                <span class="label label-success">
                                    <?= $timelineEventCount = TimelineEvent::find()->today()->count() ?>
                                </span>
                            </a>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <?php $logCount = \backend\models\SystemLog::find()->count() ?>
                        <?php if (Yii::$app->user->can('administrator')): ?>
                        <li id="log-dropdown" class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                            <span class="label label-danger">
                                <?= $logCount ?>
                            </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?= Yii::t('backend', 'You have {num} log items', ['num'=>$logCount]) ?></li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach(\backend\models\SystemLog::find()->orderBy(['log_time'=>SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                            <li>
                                                <a href="<?= Yii::$app->urlManager->createUrl(['/log/view', 'id'=>$logEntry->id]) ?>">
                                                    <i class="fa fa-warning <?= $logEntry->level == \yii\log\Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                                    <?= $logEntry->category ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <?= Html::a(Yii::t('backend', 'View all'), ['/log/index']) ?>
                                </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= Yii::$app->user->identity->userProfile->getImageUrl($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="user-image">
                                <span><?= Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header light-blue">
                                    <img src="<?= Yii::$app->user->identity->userProfile->getImageUrl($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?= Yii::$app->user->identity->username ?>
                                        <small>
<!--                                            --><?//= Yii::t('backend', 'Member since {0, date, short}', [Yii::$app->user->identity->created_at]) /*, dump(Yii::$app->user->identity)*/?>
                                            <?= Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                        </small>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?= Html::a(Yii::t('backend', 'Profile'), ['/sign-in/profile'], ['class'=>'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-left">
                                        <?= Html::a(Yii::t('backend', 'Account'), ['/sign-in/account'], ['class'=>'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-right">
                                        <?= Html::a(Yii::t('backend', 'Logout'), ['/sign-in/logout'], ['class'=>'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-cogs"></i>', ['/site/settings'])?>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= Yii::$app->user->identity->userProfile->getImageUrl($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="img-circle" />
                    </div>
                    <div class="pull-left info">
                        <p><?= Yii::t('backend', 'Hello, {username}', ['username'=>Yii::$app->user->identity->getPublicIdentity()]) ?></p>
                        <a href="<?= Url::to(['/sign-in/profile']) ?>">
                            <i class="fa fa-circle text-success"></i>
                            <?= Yii::$app->formatter->asDatetime(time()) ?>
                        </a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?= Menu::widget([
                    'options'=>['class'=>'sidebar-menu'],
                    'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                    'submenuTemplate'=>"\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                    'activateParents'=> true,
                    'items'=>[
                        [
                            'label'=>Yii::t('backend', 'Main'),
                            'options' => ['class' => 'header']
                        ],
                        [
                            'label'=>Yii::t('backend', 'Timeline'),
                            'icon'=>'<i class="fa fa-bar-chart-o"></i>',
                            'url'=>['/timeline-event/index'],
                            'badge'=> $timelineEventCount,
                            'badgeBgClass'=>'label-success',
                        ],
                        [
                            'label'=>Yii::t('backend', 'Shop'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-edit"></i>',
                            'options'=>['class'=>'treeview'],
                            'active' => in_array(Yii::$app->controller->id,[
                                'product', 'product-category', 'price'
                            ]),
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'Products'),
                                    'url'=>['/product'],
                                    'active' => Yii::$app->controller->id == 'product',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Product Categories'),
                                    'url'=>['/product-category'],
                                    'active' => Yii::$app->controller->id == 'product-category',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                ],
//                                [
//                                    'label'=>Yii::t('backend', 'Prices'),
//                                    'url'=>['/price'],
//                                    'active' => Yii::$app->controller->id == 'price',
//                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'
//                                ],
                            ],
                        ],
                        [
                            'label'=>Yii::t('backend', 'Content'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-edit"></i>',
                            'options'=>['class'=>'treeview'],
                            'active' => in_array(Yii::$app->controller->id,[
                                'page', 'article','article-category','employee',  'social', 'slider'
                            ]),
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'Static pages'),
                                    'url'=>['/page'],
                                    'active' => Yii::$app->controller->id == 'page',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                [
                                    'label'=>Yii::t('backend', 'Sliders'),
                                    'url'=>['/slider'],
                                    'active' => Yii::$app->controller->id == 'slider',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                [
                                    'label'=>Yii::t('backend', 'Articles'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-edit"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'active' => in_array(Yii::$app->controller->id,[
                                        'article','article-category'
                                    ]),
                                    'items'=>[
                                        [
                                            'label'=>Yii::t('backend', 'Articles'),
                                            'url'=>['/article'],
                                            'active' => Yii::$app->controller->id == 'article',
                                            'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                        ],
                                        [
                                            'label'=>Yii::t('backend', 'Article Categories'),
                                            'url'=>['/article-category'],
                                            'active' => Yii::$app->controller->id == 'article-category',
                                            'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                        ],
                                    ]
                                ],
//                                [
//                                    'label'=>Yii::t('backend','Social networks'),
//                                    'url'=>['/social'],
//                                    'active' => Yii::$app->controller->id == 'social',
//                                    'icon'=>'<i class="fa fa-vk"></i>'
//                                ],
                            ]
                        ],
                        [
                            'label'=>Yii::t('backend', 'Clients'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-edit"></i>',
                            'options'=>['class'=>'treeview'],
                            'active' => in_array(Yii::$app->controller->id,[
                                'subscribe',  'contact-us',
                            ]),
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'Subscribe'),
                                    'url'=>['/subscribe'],
                                    'active' => Yii::$app->controller->id == 'subscribe',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
                                    'badge'=> Contact::find()->byTypeSubscribe()->notActive()->count(),
                                    'badgeBgClass'=>'label-info',
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Contact Us'),
                                    'url'=>['/contact-us'],
                                    'active' => Yii::$app->controller->id == 'contact-us',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
                                    'badge'=> Contact::find()->byTypeContactUs()->notActive()->count(),
                                    'badgeBgClass'=>'label-info',
                                ],
                            ]
                        ],
                        [
                            'label'=>Yii::t('backend', 'System'),
                            'options' => ['class' => 'header']
                        ],
                        [
                            'label'=>Yii::t('backend', 'Users'),
                            'icon'=>'<i class="fa fa-users"></i>',
                            'url'=>['/user/index'],
                            'active' => Yii::$app->controller->id == 'user',
                            'visible'=>Yii::$app->user->can('administrator')
                        ],
                        [
                            'label'=>Yii::t('backend', 'Other'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-cogs"></i>',
                            'options'=>['class'=>'treeview'],
                            'active' => in_array(Yii::$app->controller->id,[
                                'key-storage','file-storage','file-manager',
                                'system-information','log','cache'
                            ]),
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'Key-Value Storage'),
                                    'url'=>['/key-storage/index'],
                                    'active' => Yii::$app->controller->id == 'key-storage',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                [
                                    'label'=>Yii::t('backend', 'File Storage'),
                                    'url'=>['/file-storage/index'],
                                    'active' => Yii::$app->controller->id == 'file-storage',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                                [
//                                    'label'=>Yii::t('backend', 'Cache'),
//                                    'url'=>['/cache/index'],
//                                    'active' => Yii::$app->controller->id == 'cache',
//                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                                [
//                                    'label'=>Yii::t('backend', 'File Manager'),
//                                    'url'=>['/file-manager/index'],
//                                    'active' => Yii::$app->controller->id == 'file-manager',
//                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                                [
//                                    'label'=>Yii::t('backend', 'System Information'),
//                                    'url'=>['/system-information/index'],
//                                    'active' => Yii::$app->controller->id == 'system-information',
//                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
//                                    'visible'=>Yii::$app->user->can('administrator')
//                                ],
                                [
                                    'label'=>Yii::t('backend', 'Logs'),
                                    'url'=>['/log'],
                                    'active' => Yii::$app->controller->id == 'log',
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
                                    'badge'=>$logCount,
                                    'badgeBgClass'=>'label-danger',
                                    'visible'=>Yii::$app->user->can('administrator')
                                ],
                            ]
                        ],
                        [
                            'label'=>Yii::t('backend', 'Settings'),
                            'icon'=>'<i class="fa fa-bar-chart-o"></i>',
                            'url'=>['/setting'],
                            'active' => Yii::$app->controller->id == 'setting',
                        ],
                        [
                            'label'=>Yii::t('backend', 'Translations'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-flag"></i>',
                            'options'=>['class'=>'treeview'],
                            'active' => Yii::$app->controller->id == 'language',
                            'items'=>[
                                [
                                    'label' => Yii::t('language', 'Language'),
                                    'url' => '#',
                                    'active' => Yii::$app->controller->id == 'language'
                                        && in_array(Yii::$app->controller->action->id,['list','create','update','translate']),
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'items' => [
                                        [
                                            'label' => Yii::t('language', 'List of languages'),
                                            'url' => ['/translatemanager/language/list'],
                                            'icon'=>'<i class="fa fa-language"></i>'],
//                                        [
//                                            'label' => Yii::t('language', 'Create'),
//                                            'url' => ['/translatemanager/language/create'],
//                                            'icon'=>'<i class="fa fa-plus"></i>'],
                                    ],
                                ],
                                [
                                    'label' => Yii::t('language', 'Scan'),
                                    'url' => ['/translatemanager/language/scan'],
                                    'icon'=>'<i class="fa fa-refresh"></i>'
                                ],
//                                [
//                                    'label' => Yii::t('language', 'Optimize'),
//                                    'url' => ['/translatemanager/language/optimizer'],
//                                    'icon'=>'<i class="fa fa-recycle"></i>'
//                                ],
//                                [
//                                    'label' => Yii::t('language', 'Im-/Export'),
//                                    'url' => '#',
//                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
//                                    'options'=>['class'=>'treeview'],
//                                    'items' => [
//                                        ['label' => Yii::t('language', 'Import'), 'url' => ['/translatemanager/language/import']],
//                                        ['label' => Yii::t('language', 'Export'), 'url' => ['/translatemanager/language/export']],
//                                    ]
//                                ]
                            ],
                        ],
//                        [
//                            'label'=>Yii::t('backend', 'i18n'),
//                            'url' => '#',
//                            'icon'=>'<i class="fa fa-flag"></i>',
//                            'options'=>['class'=>'treeview'],
//                            'items'=>[
//                                ['label'=>Yii::t('backend', 'i18n Source Message'), 'url'=>['/i18n/i18n-source-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                                ['label'=>Yii::t('backend', 'i18n Message'), 'url'=>['/i18n/i18n-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                            ],
//                        ]
                    ]
                ]) ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= $this->title ?>
                    <?php if (isset($this->params['subtitle'])): ?>
                        <small><?= $this->params['subtitle'] ?></small>
                    <?php endif; ?>
                </h1>

                <?= Breadcrumbs::widget([
                    'tag'=>'ol',
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if (Yii::$app->session->hasFlash('alert')):?>
                    <?= \yii\bootstrap\Alert::widget([
                        'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                        'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                    ])?>
                <?php endif; ?>
                <?= $content ?>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

<?php $this->endContent(); ?>