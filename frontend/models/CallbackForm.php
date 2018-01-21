<?php

namespace frontend\models;

use Yii;
use borales\extensions\phoneInput\PhoneInputValidator;
use common\commands\SendEmailCommand;
use common\models\Contact;
use yii\base\Model;

/**
 * This is the model class for table "{{%contact}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $phone_input
 * @property string $time
 * @property string $message
 * @property integer $type
 * @property integer $status
 * @property string $created_at
 */
class CallbackForm extends Model
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */
    public $phone_input;
    /**
     * @var string
     */
    public $message;
    /**
     * @var string
     */
    public $time;
    /**
     * @var bool
     */
    public $status;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'time'], 'string', 'max' => 255],
            [['message'], 'string'],
            [['phone', 'phone_input'], 'required'],
            [['phone', 'phone_input'], 'string'],
            [['phone', 'phone_input'], PhoneInputValidator::className()],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'name' => Yii::t('site', 'Name'),
            'phone' => Yii::t('site', 'Phone'),
            'phone_input' => Yii::t('site', 'Phone'),
            'time' => Yii::t('site', 'Time'),
            'message' => Yii::t('site', 'Message'),
        ];
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $this->phone_input = $this->phone;
        if ($this->validate()) {
            $contact = new Contact();
            $contact->name = $this->name;
            $contact->phone = $this->phone;
            $contact->time = $this->time;
            $contact->message = $this->message;
            $contact->type = Contact::TYPE_CALLBACK;
            $contact->status = Contact::STATUS_WAITED;

            if ($contact->save()) {
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'subject' => Yii::t('user', 'Callback'),
                    'view' => 'callback',
                    'to' => Yii::$app->params['adminEmail'],
                    'params' => [
                        'contact' => $contact,
                    ],
                ]));
                $this->status = true;
                return true;
            }
        }
        return false;
    }
}
