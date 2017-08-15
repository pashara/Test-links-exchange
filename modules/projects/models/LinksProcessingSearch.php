<?php

namespace app\modules\projects\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\projects\models\Project;

/**
 * ProjectSearch represents the model behind the search form about `app\modules\projects\models\Project`.
 */
class LinksProcessingSearch extends LinksProcessing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','user_id'], 'integer'],


            [['link_allow_once','link_number'],'integer'],
            [['link_enable'],'in', 'range'=>[0,1]],
            [['link_title','link_alias'],'string'],
            [['date_start','date_end'],'string'],


        ];
    }




    /**
     * @param $params
     * @return ActiveDataProvider
     *
     * Ищем данные для пользователей, которые работают (фрилансеры)
     */
    public function search($params,$user_id = 0) {
        $query = LinksProcessing::find();

        $query->joinWith(['link']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  =>['attributes' => ['user_id','link.title','date_start','date_end']],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'link.allow_once' => $this->link_allow_once,
            'link.number' => $this->link_number,
            'link.enable' => $this->link_enable,
        ]);




        if($user_id == 0){
            $query->andFilterWhere([
                'user_id' => Yii::$app->user->id,
            ]);
        }else if($user_id < 0){

        }



        $query->andFilterWhere(['like', 'link.title', $this->link_title]);
        $query->andFilterWhere(['like', 'link.alias', $this->link_alias]);
        $query->andFilterWhere(['like', 'date_start', $this->date_start]);
        $query->andFilterWhere(['like', 'date_end', $this->date_end]);

        $dataProvider->sort->attributes['link_title'] = [
            'asc' => ['link.title' => SORT_ASC],
            'desc' => ['link.title' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['link_alias'] = [
            'asc' => ['link.alias' => SORT_ASC],
            'desc' => ['link.alias' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['link_allow_once'] = [
            'asc' => ['link.allow_once' => SORT_ASC],
            'desc' => ['link.allow_once' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['link_number'] = [
            'asc' => ['link.number' => SORT_ASC],
            'desc' => ['link.number' => SORT_DESC],
        ];



        return $dataProvider;
    }
}
