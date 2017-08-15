<?php

namespace app\modules\projects\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%project_links}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $alias
 * @property string $enable
 * @property integer $number
 * @property double $default_currency
 * @property float $total
 * @property int $done
 */
class ProjectLinks extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%project_links}}';
    }

    public function getMainCurrency(){
        return ProjectLinksCost::find()->where(['link_id'=>$this->id])->andWhere(['currency_id'=>$this->default_currency])->with("currencyName")->one();
    }



    public function getNotMainCurrency(){
        return ProjectLinksCost::find()->where(['link_id'=>$this->id])->andWhere('currency_id != :currency_id',[':currency_id'=>$this->default_currency])->with("currencyName")->all();
    }



    public function getRequirements() {
        return $this->hasMany(LinksRequirements::className(), ['link_id' => 'id']);
    }

/*
 *
SELECT pl.id FROM p_project_links pl JOIN p_links_requirements lr
    ON pl.id = lr.link_id AND lr.value in(0, 1, 2) AND lr.requirement_id = 1


 GROUP BY pl.id

HAVING count(1)=2

 */


    public function getAllRequirements() {

        return $this->hasMany(LinksRequirements::className(), ['id' => 'u_id1'])
            ->viaTable('{{%UserContact}}', ['u_id2' => 'id']);

        //return $this->hasMany(LinksRequirements::className(), ['link_id' => 'id']);
    }


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['project_id', 'title', 'alias', 'number', 'default_currency', 'enable'], 'required'],
            [['project_id', 'number', 'default_currency', 'enable'], 'integer', 'min' => 0],
            [['number'], 'compare', 'compareAttribute' => 'done', 'operator' => '>=', 'type' => 'number'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['enable'], 'in', 'range' => [0, 1]],
            [['number'], 'integer', 'max' => 9999],
            [['alias'], 'string', 'max' => 300],
            [['title'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('projects', 'ID'),
            'project_id' => Yii::t('projects', 'Project ID'),
            'title' => Yii::t('projects', 'Title'),
            'alias' => Yii::t('projects', 'Alias'),
            'enable' => Yii::t('projects', 'Enable'),
            'number' => Yii::t('projects', 'Number'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProjectLinksQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProjectLinksQuery(get_called_class());
    }
}
