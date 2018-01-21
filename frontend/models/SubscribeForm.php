<?php

namespace frontend\models;

use Yii;
use common\models\Contact;
use common\commands\SendEmailCommand;
/**
 * Class SubscribeForm
 * This is the model class for table "{{%contact}}".
 *
 * @property string $email
 * @package frontend\models
 */
class SubscribeForm extends \yii\base\Model
{
    /**
     * @var
     */
    public $email;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('site', 'Email address'),
        ];
    }

    /**
     * @return string
     */
    public function handle()
    {
        Yii::$app->db->createCommand()->delete('contact', ['email' => 'cool.kneu@gmail.com'])->execute();
        if($this->findEmail($this->email)){
            return Yii::t('site', 'You are already subscribed.');
        }

        $contact = new Contact();
        $contact->email = $this->email;
        $contact->type = Contact::TYPE_SUBSCRIBE;
        $contact->status = Contact::STATUS_WAITED;

        if (!$contact->save()){
            return Yii::t('site', 'Some error was occurred. May be you have send too many requests. Please, try later.');
        }


        Yii::$app->commandBus->handle(new SendEmailCommand([
            'subject' => Yii::t('user', 'Subscribe'),
            'view' => 'subscribe',
            'to' => $contact->email,
            'params' => [
                'siteName' => Yii::$app->name,
            ],
        ]));
        Yii::$app->commandBus->handle(new SendEmailCommand([
            'subject' => Yii::t('user', 'Subscribe'),
            'view' => 'subscribe',
            'to' => env('ADMIN_EMAIL'),
            'params' => [
                'siteName' => Yii::$app->name,
            ],
        ]));

        return Yii::t('site', 'Congratulations! You are subscribed from our news');
    }

    /**
     * @param $email
     * @return mixed
     */
    public function findEmail($email)
    {
        return Contact::findOne(['email' => $email, 'type' => Contact::TYPE_SUBSCRIBE]);
    }
}