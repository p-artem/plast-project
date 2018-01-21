<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */
/* @var $searchModel \frontend\models\search\OrderSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->context->layout = 'layout';

$this->title = Yii::t('user', 'User Profile')
?>





































<!-- Old code -->
<div class="hidden">

	<div class="header-title-box">
		<h1 class="page-header"><?= Html::encode($this->title) ?></h1>
	</div>

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-0">
<!--            --><?//= DatePicker::widget([
//                'name' => 'asd',
//                'options' => [
//                    'class'=>false,
//                    'placeholder'=>'             /                 /',
//                ],
//                'size'=>'lg',
//                'layout'=>'{input}{picker}',
//                'convertFormat' => true,
//                'pluginOptions' => [
//                    'displayFormat' => 'php:d-F-Y',
//                    'todayHighlight' => true,
//                    'todayBtn' => true,
//                    'autoclose' => true,
//                    'endDate'=> date('Y-m-d', time()),
//                    'format' => 'yyyy-M-d',
//                ],
//            ]) ?>

<div class="pers-data">
	<span class="order-log"><?= Yii::t('user', 'Personal Information') ?></span>

	<?php $form = ActiveForm::begin([
		'id'=>'profile-form',
		'options'=>['class'=>'profile-form'],
		'fieldConfig'=>[
		'inputOptions'=>['class'=>false],
		'options'=>[
		'tag'=>'label',
		'class'=>'cust-inp',
		],
		'template'=>'<span>{labelTitle}</span>{input}{error}',
		],
		]); ?>

		<?= $form->field($model->getModel('account'), 'username') ?>

		<?= $form->field($model->getModel('account'), 'email')->textInput(['disabled'=>true]) ?>

		<?= $form->field($model->getModel('account'), 'phone_input')->widget(\borales\extensions\phoneInput\PhoneInput::className(), [
			'jsOptions' => [
			'allowExtensions' => true,
//                    'onlyCountries' => ['ua'],
			'preferredCountries' => ['ua'],
			'separateDialCode'=> true,
			'nationalMode'=> true
			]
			]); ?>
		<?= $form->field($model->getModel('account'), 'phone', ['template'=>'{input}','options'=>['tag'=>false]
		])->hiddenInput() ?>

<!--                --><?//= $form->field($model->getModel('profile'), 'birthday',
//                    ['template'=>'<span>{labelTitle}</span>{input}{error}','options'=>['tag'=>'label']]
//                )->widget(\common\widgets\DatePicker::className(),[
//                    'options' => [
//                        'class'=>false,
//                        'placeholder'=>'             /                 /',
//                    ],
//                    'size'=>'lg',
//                    'layout'=>'{input}{picker}',
//                    'convertFormat' => true,
//                    'pluginOptions' => [
//                        'displayFormat' => 'php:d-F-Y',
//                        'todayHighlight' => true,
//                        'todayBtn' => true,
//                        'autoclose' => true,
//                        'endDate'=> date('Y-m-d', time()),
//                        'format' => 'yyyy-M-d',
//                    ],
//                ]) ?>

<?= $form->field($model->getModel('profile'), 'birthday',
	['template'=>'<span>{labelTitle}</span>{input}{error}','options'=>['tag'=>'label']]
	)->widget(\common\widgets\DatePicker::className(),[
	'options' => [
	'class'=>false,
	'placeholder'=>'                /                      /',
	],
//                    'type' => DatePicker::TYPE_INPUT,
	'size'=>'lg',
	'layout'=>'{input}{picker}',
//                    'convertFormat'=>true,
	'pluginOptions'=>[
//                        'todayHighlight' => true,
//                        'todayBtn' => true,
//                        'autoclose'=>true,
	'startDate'=> date('d-m-Y', strtotime('')),
	'endDate'=> date('d-m-Y', time()),
//                        'yearRange'=> "1900:".date('Y', time()),
//                        'format' => 'yyyy MM d',
	]
	]) ?>

	<?= $form->field($model->getModel('profile'), 'city') ?>

	<?= $form->field($model->getModel('account'), 'password')->passwordInput() ?>

	<?= $form->field($model->getModel('account'), 'password_confirm')->passwordInput() ?>

	<div class="reminder">
		<p><?= Yii::t('user', 'Check the correctness of filling the cells, before you press "Save Changes"') ?></p>
	</div>
	<div class="button-wrap">
		<?= Html::submitButton(Yii::t('user', 'Save changes'), ['class' => 'btn-accent']) ?>
	</div>

	<?php ActiveForm::end(); ?>
	<?php $this->registerJs("
		$(\"#profile-form\").on('beforeValidate', function() {
			$(\"#accountform-phone\").val($(\"#accountform-phone_input\").intlTelInput(\"getNumber\"));
		});
		$('#profile-form').on('beforeSubmit', function (e) {
			($(this).find('button[type=submit]').attr('disabled',true));
		});
		"); ?>
	</div>
</div>

<!-- Order history -->
<div class="col-sm-12 col-md-8">

	<div class="pers-tabs">
		<ul class="tabs__caption">
			<li class="active"><?= Yii::t('user', 'Order history') ?></li>
			<!--                <li><?= Yii::t('user', 'Loyalty program') ?></li>-->
		</ul>

		<div class="tabs__content active">
			<div class="order-history-wrap">

				<?php $formSearch = ActiveForm::begin([
					'id' => 'order-sort-form',
					'action' => \yii\helpers\Url::to('user'),
					'options'=>['class'=>'order-sort sorting-form'],
					'method' =>'get',
					'enableClientValidation'=>false,
					'fieldConfig'=>[
					'inputOptions'=>['class'=>false],
					'options'=>[
					'tag'=>'label',
					'class'=>'cust-sel',
					],
					'template'=>'<span>{labelTitle}</span>{input}',
					],
					]) ?>

				<?= $formSearch->field($searchModel,'word',[
					'template'=>'{input}<button class="srch-btn"></button>',
					'options'=>['tag'=>'div','class'=>'cust-inp'],
					'inputOptions'=>['placeholder'=>$searchModel->getAttributeLabel('word')
					]
					]) ?>

					<div class="sel-set">
						<?= $formSearch->field($searchModel,'status'/*,['options'=>['class'=>'sorting']]*/)
						->dropDownList($searchModel->statuses(),['prompt'=>Yii::t('filter', 'All')]) ?>

						<?= $formSearch->field($searchModel,'per_page')
						->dropDownList($searchModel->per_pages()) ?>
					</div>

					<?php ActiveForm::end() ?>

					<!-- order-history -->
					<?php $thead =
					"<thead><tr>" .
					"<td>".Yii::t('site', 'Number')."</td>" .
					"<td>".Yii::t('site', 'Data')."</td>" .
					"<td>".Yii::t('site', 'Order sum')."</td>" .
					"<td>".Yii::t('site', 'Status')."</td>" .
					"<td></td>" .
					"</tr></thead>"; ?>
					<?php Pjax::begin([
						'formSelector' => '#'.$formSearch->id,
						'linkSelector' => '.listPagination a',
						]); ?>
					<?= \frontend\widgets\SiteListView::widget([
						'layout' => "\n<table class=\"order-history hidden-xs\">\n{$thead}\n<tbody>\n{items}\n</tbody>\n</table>\n",
						'dataProvider' => $dataProvider,
						'itemView' => function ($model, $key, $index, $widget){
							/* @var $model \common\models\Order */
							return "
							<tr class=\"order-item\">
								<td><span>{$model->id}</span></td>
								<td><span>".Yii::$app->formatter->asDate($model->created_at/*, 'd.m.y'*/)."</span></td>
								<td><span>".number_format($model->sum, 0, '.', '&nbsp;').' '.Yii::t('site', 'UAH')."</span></td>
								<td><span>{$model->statusName}</span></td>
								<td><a href=\"".\yii\helpers\Url::to(['user/order', 'id'=>$model->id])."\"><i class=\"eye-ic\"></i></a>
								</td>
							</tr>
							";
						},
						'emptyText' => Yii::t('user', 'History is empty'),
						]) ?>

						<!--order-history-mobile -->
						<div class="order-history-mobile hidden-sm hidden-md hidden-lg">
							<?= \frontend\widgets\SiteListView::widget([
								'layout' => "\n<tbody>\n{items}\n</tbody>\n",
								'dataProvider' => $dataProvider,
								'itemView' => function ($model, $key, $index, $widget){
									/* @var $model \common\models\Order */
									return "
									<table class=\"order-item-mobile\">
										<tbody><tr>
											<td><span>".Yii::t('site', 'Number')."</span></td>
											<td><span>{$model->id}</span></td>
										</tr>
										<tr>
											<td><span>".Yii::t('site', 'Data')."</span></td>
											<td><span>".Yii::$app->formatter->asDate($model->created_at/*, 'd.m.y'*/)."</span></td>
										</tr>
										<tr>
											<td><span>".Yii::t('site', 'Order sum')."</span></td>
											<td><span>".number_format($model->sum, 0, '.', '&nbsp;')." ".Yii::t('site', 'UAH')."</span></td>
										</tr>
										<tr>
											<td><span>" .Yii::t('site', 'Status') ."</span></td>
											<td><span>{$model->statusName}</span></td>
										</tr>
										<tr>
											<td><span></span></td>
											<td><a href=\"".\yii\helpers\Url::to(['user/order', 'id'=>$model->id])."\"><i class=\"eye-ic\"></i></a></td>
										</tr>
									</tbody></table>
									";
								},
								'emptyText' => Yii::t('user', 'History is empty'),
								]) ?>
							</div>

							<?= \frontend\widgets\SiteLinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
							<?php Pjax::end(); ?>

						</div>
					</div>

					<!--            <div class="tabs__content">-->
					<!--                <div class="info-txt">-->
					<!--                    <div class="bonus-title">Начислено бонусов: 500</div>-->
					<!--                    <p>-->
					<!--                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.-->
					<!--                    </p>-->
					<!--                </div>-->
					<!--            </div>-->
				</div>
			</div>
		</div>

	</div>
<!-- Old code END -->