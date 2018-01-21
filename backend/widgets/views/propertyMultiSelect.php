<?php
/**
 * @var $this View
 * @var $list array,
 * @var $table array,
 * @var $label string,
 * @var $id string,
 * @var $name string,
 */
use yii\helpers\Html;
use yii\web\View;

?><div class="property-multi-select" id="<?= $id; ?>">
	<label class="control-label"><?= $label; ?>
    <?= \kartik\select2\Select2::widget([
        'name' => 'properties',
        'data' => $list,
        'options' => ['class' => 'form-control list', 'id' => 'properties'],
        'pluginOptions' => [
            'width' => 400,
        ],
    ]);
    ?>
    <?= Html::dropDownList('', null, $list, ['class' => 'list-hidden hidden']); ?>
    </label>
<!--    <br>-->
    <table class="table table-striped table-bordered table-condensed">
        <tbody>
            <tr class="hidden">
                <td><label></label></td>
                <td class="value">
                    <?= Html::textInput('value', null, ['class' => 'form-control']) ?>
                </td>
                <td class="in-list">
                    <label>
                    <?= Yii::t('backend', 'Show in list'); ?>
                    <?= Html::hiddenInput('in_list', 0) ?>
                    <?= Html::checkbox('in_list') ?>
                    </label>
                </td>
                <td style="width: 30px;"><a href="#" class="remove"><i class="fa-lg fa fa-trash-o"></i></a></td>
            </tr>
            <?php foreach($table as $itemId => $item): ?>
            <tr data-id="<?= $itemId; ?>">
                <td><label>
                    <?= $item['name']; ?>
                </label></td>
                <td class="value">
                    <?= Html::textInput($name.'['.$itemId.'][value]', $item['value'], ['class' => 'form-control']) ?>
                </td>
                <td class="in-list">
                    <label>
                    <?= Yii::t('backend', 'Show in list'); ?>
                    <?= Html::hiddenInput($name.'['.$itemId.'][in_list]', 0) ?>
                    <?= Html::checkbox($name.'['.$itemId.'][in_list]', $item['in_list']) ?>
                    </label>
                </td>
                <td style="width: 30px;"><a href="#" class="remove"><i class="fa-lg fa fa-trash-o"></i></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
	</table>
</div>