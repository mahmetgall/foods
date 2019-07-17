<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property int $uid
 * @property int $lesson_id
 * @property int $course_id
 * @property int $user_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class MainActivityRecord extends \yii\db\ActiveRecord
{

    public function init()
    {
        parent::init();

    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


}
