<?php
namespace frontend\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use common\models\Contact;
use common\commands\SendEmailCommand;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $surname;
    /**
     * @var
     */
    public $message;
    /**
     * @var bool
     */
    protected $status = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'message'], 'required', 'message' => Yii::t('site','Fill the form')],
            [['name', 'message'], 'filter', 'filter' => 'strip_tags'],
            [['name', 'message'], 'filter', 'filter' => 'trim'],
            ['email', 'email', 'message' => Yii::t('site', 'Error')]
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('site', 'Name'),
            'surname' => Yii::t('site', 'Surname'),
            'email' => Yii::t('site', 'E-mail'),
            'message' => Yii::t('site', 'Message'),
        ];
    }

    /**
     * @return bool
     */
    public function addContact()
    {
        if (!$this->validate()) {
            return false;
        }
        $model = new Contact();
        $model->setAttributes($this->attributes);
        $model->type = Contact::TYPE_CONTACT_US;
        if ($model->save()) {
            $this->status = true;
            try {
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'subject' => Yii::t('site', 'Contact us'),
                    'view' => 'contact-us',
                    'to' => Yii::$app->params['adminEmail'],
                    'params' => [
                        'model' => $model,
                    ],
                ]));
            } catch (Exception $e) {

            } finally {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getStatus(){
        return $this->status;
    }
}