<?php
namespace backend\controllers\actions;

use yii\base\Action;
use yii\db\ActiveRecord;
use yii\web\Response;

/**
 * Action to handle calls from ImageAttachmentWidget,
 * and apply changes to model with ImageBehave
 *
 * @example
 *
 *    public function actions()
 *    {
 *        'remove-image' => [
 *        'class' => Yii2imagesRemoveImageAction::className(),
 *        'model' => new YouModel(),
 *        ],
 *    }
 */
class Yii2imagesRemoveImageAction extends Action
{
    /**
     * @var ActiveRecord
     */
    public $_model;

    /**
     * Deletes an existing Image for Owner model.
     * @param int $id
     * @return Response
     */
    public function run($id)
    {
        $model = $this->_model;
        if ($item = $model::findOne($id)){
            $item->removeImageByName('image');
        }
        return $this->controller->redirect(['update', 'id' => $item->id]);
    }

    /**
     * @param ActiveRecord $model
     */
    public function setModel(ActiveRecord $model)
    {
        $this->_model = $model;
    }
}