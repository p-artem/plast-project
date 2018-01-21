<?php
namespace backend\controllers\actions;

use Yii;
use yii\base\Action;
use yii\db\ActiveRecord;
use yii\web\Response;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * Action to handle calls from ImageAttachmentWidget,
 * and apply changes to model with ImageBehave
 *
 * @example
 *
 *    public function actions()
 *    {
 *        'remove-image' => [
 *        'class' => RemoveImageAction::className(),
 *        'model' => new YouModel(),
 *        'name' =>'column name with name.image',
 *        'path' =>'path-to-image-directory',
 *        ],
 *    }
 */
class RemoveImageAction extends Action
{
    /**
     * @var ActiveRecord
     */
    public $model;
    /**
     * @var string
     */
    public $name = 'image';
    /**
     * @var string
     */
    public $storagePath = '@images';

    /**
     * Deletes an existing Image for Owner model.
     * @param int $id
     * @param string $attribute
     * @return Response
     */
    public function run($id, $attribute)
    {
        $model = $this->model;
        if ($item = $model::findOne($id)) {
            foreach ($item->getBehaviors() as $behavior){
                if ($behavior instanceof FileUploadBehavior && $attribute == $behavior->attribute) {
                    $this->name = $behavior->attribute;
                    $behavior->cleanFiles();
                    $behavior->detach();
                    break;
                }
            }
            if (!empty($item->{$this->name})) {
                $item->{$this->name} = '';
                $item->save(false);
            }
        }
        return $this->controller->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param ActiveRecord $obj
     * @return string
     */
    protected function getShortClass($obj)
    {
        $className = get_class($obj);

        if (preg_match('@\\\\([\w]+)$@', $className, $matches)) {
            $className = $matches[1];
        }

        return $className;
    }
}