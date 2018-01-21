<?php

namespace frontend\models;

use common\models\ArticleComment;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "{{%article_comment}}".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $parent_id
 * @property integer $user_id
 * @property string $text
 * @property integer $creation
 * @property integer $status
 */
class ArticleCommentForm extends Model
{
    /**
     * @var
     */
    public $article_id;
    /**
     * @var
     */
    public $parent_id;
    /**
     * @var
     */
    public $user_id;
    /**
     * @var
     */
    public $text;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['article_id','text'], 'required'],
            [['text'], 'filter', 'filter' => 'strip_tags'],
            [['text'], 'string'],
            [['parent_id'],'integer']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('site', 'Name'),
            'text' => Yii::t('site', 'Message'),
        ];
    }

    /**
     * @return bool
     */
    public function add()
    {
        $this->user_id = Yii::$app->user->id;
        $product_comment = new ArticleComment();
        $product_comment->setAttributes($this->attributes);
        if ($product_comment->save()) {
            return true;
        }
        return false;
    }
}
