<?php
namespace common\components;

use yii\base\Component;
use yii\base\UnknownClassException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class AppSettings
 * @package common\components
 *
 * @property string $modelClass
 * @property int $settingsKey
 * @property \common\models\Setting $settings
 */
class AppSettings extends Component {

    public $modelClass;
    public $settingsKey = 1;
    /**
     * @var
     */
    private $_settings;

    /**
     * @return mixed
     * @throws UnknownClassException
     */
    public function getSettings(){

        $model = Yii::createObject($this->modelClass);

        if(!($this->modelClass)){
            throw new UnknownClassException('AppSettings - modelClass not found');
        }

        if(!$this->_settings){
            $this->_settings = $model::findOne($this->settingsKey);
        }

        return $this->_settings;
    }
}