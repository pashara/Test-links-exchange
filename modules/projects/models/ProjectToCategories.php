<?php

namespace app\modules\projects\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%project_to_categories}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $project_id
 *
 * @property Project $project
 * @property ProjectCategories $category
 */
class ProjectToCategories extends \yii\db\ActiveRecord
{
    public $category_id_array;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project_to_categories}}';
    }

    const SCENARIO_MULTI_CREATE = 'multi_create';
    const SCENARIO_MULTI_UPDATE = 'multi_update';
    const SCENARIO_DEFAULT = 'default';


    /**
     * Unsafe
     *
     * @param $category_id_array
     * @param $project_id
     */
    public static function multiInsertUnsafe($category_id_array, $project_id){
        if(!empty($category_id_array))
        foreach($category_id_array as $category){
            $bulkInsertArray[]=[
                'project_id'=>$project_id,
                'category_id'=>$category,
            ];
        }
        if(count($bulkInsertArray)>0) {
            Yii::$app
                ->db
                ->createCommand()
                ->delete(self::tableName(), ['project_id' => $project_id])
                ->execute();

            $columnNameArray = ['project_id', 'category_id'];
            Yii::$app->db->createCommand()
                ->batchInsert(self::tableName(), $columnNameArray, $bulkInsertArray)
                ->execute();
        }
    }



    public function checkBoxFields($paramsInput = array()){

        $originalParams = [
            'template'=>'<div class="form-group field-project-categories-checkboxes {hasError}"><div class="help-block">{error}</div>{list}</div>',
            'li_template'=>'<li>{checkbox}{label}</li>',
            'list_id'=>'categories_list',
            'list_class'=>'categories_list',
            ];
        $params = array_merge ( $originalParams,$paramsInput);


        $rt = ProjectCategories::getAllCategoriesArray();
        $prev_lvl = $rt[0]->lvl;
        $field_name = 'category_id_array';
        $preStart=$field_name;

        $templateHtmlValues = [
            'hasError'=>'',
            'error'=>'',
            'list'=>'',
        ];

        if($this->hasErrors())
            if(isset($this->errors[$field_name]))
                foreach($this->errors[$field_name] as $error){
                    $templateHtmlValues['hasError']='has-error';
                    $templateHtmlValues['error'].=$error;
                }


        $templateHtmlValues['list'].= '<ul id='.$params['list_id'].' class='.$params['list_class'].'>';
        foreach ($rt as $node) {
            if($node->lvl > $prev_lvl){
                $templateHtmlValues['list'].= '<ul>';
            }

            if($node->lvl < $prev_lvl){
                $templateHtmlValues['list'].= '</ul>';
            }
            $prev_lvl = $node->lvl;

            $templateHtmlValues['list'].= str_replace(['{checkbox}','{label}'],[
                (($node->disabled)?'x':Html::checkbox($preStart.'[]', (($this->category_id_array != null && in_array($node->id,$this->category_id_array))?true:false),['id'=>$preStart.'_' . $node->id,'value'=>$node->id])),
                Html::label($node->name,$preStart.'_' . $node->id),
            ],$params['li_template']);

        }
        $templateHtmlValues['list'].= '</ul>';

        return str_replace(['{hasError}','{error}','{list}'],$templateHtmlValues,$params['template']);
    }
    public function scenarios()
    {
        return [
            self::SCENARIO_MULTI_CREATE => ['category_id_array'],
            self::SCENARIO_MULTI_UPDATE => ['category_id_array','category_id','project_id'],
            self::SCENARIO_DEFAULT => [''],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id_array'], 'each', 'rule'=>['integer'], 'on' => self::SCENARIO_MULTI_CREATE],
            //[['category_id_array'], 'each', 'rule'=>['exist', 'skipOnError' => false, 'targetClass' => ProjectCategories::className(), 'targetAttribute' => ['category_id_array' => 'id']], 'on' => self::SCENARIO_MULTI_CREATE],
            [['category_id_array'], 'validateCategory', 'on' => self::SCENARIO_MULTI_CREATE],


            [['category_id_array'], 'each', 'rule'=>['integer'], 'on' => self::SCENARIO_MULTI_UPDATE],
            //[['category_id_array'], 'each', 'rule'=>['exist', 'skipOnError' => false, 'targetClass' => ProjectCategories::className(), 'targetAttribute' => ['category_id_array' => 'id']], 'on' => self::SCENARIO_MULTI_UPDATE],
            [['category_id_array'], 'validateCategory', 'on' => self::SCENARIO_MULTI_UPDATE],
            [['project_id'], 'required', 'on' => self::SCENARIO_MULTI_UPDATE],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id'], 'on' => self::SCENARIO_MULTI_UPDATE],

            /*
            [['category_id', 'project_id'], 'required'],
            [['category_id', 'project_id'], 'integer'],

            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectCategories::className(), 'targetAttribute' => ['category_id' => 'id']],
            */
            ];
    }

    public function validateCategory($attribute, $params)
    {
        $countInSite = count($this->$attribute);
        $countInDB = (int)(new \yii\db\Query())
        ->select(['count(id) as count'])
        ->from(ProjectCategories::tableName())
        ->where(['id' => $this->$attribute])
        ->andWhere(['active'=>1])
        ->andWhere(['disabled'=>0])
        ->one()['count'];

        if($countInSite != $countInDB)
            $this->addError($attribute, Yii::t('projects','Some problems with categories'));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('projects', 'ID'),
            'category_id' => Yii::t('projects', 'Category ID'),
            'project_id' => Yii::t('projects', 'Project ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProjectCategories::className(), ['id' => 'category_id']);
    }






    /**
     * @inheritdoc
     * @return ProjectToCategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectToCategoriesQuery(get_called_class());
    }
}
