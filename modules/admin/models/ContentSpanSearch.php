<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ContentSpan;

/**
 * ContentSpanSearch represents the model behind the search form of `app\models\ContentSpan`.
 */
class ContentSpanSearch extends ContentSpan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sentence_position', 'position', 'translation', 'space_after', 'content_id'], 'integer'],
            [['original'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ContentSpan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'sentence_position' => $this->sentence_position,
            'position' => $this->position,
            'translation' => $this->translation,
            'space_after' => $this->space_after,
            'content_id' => $this->content_id,
        ]);

        $query->andFilterWhere(['like', 'original', $this->original]);

        return $dataProvider;
    }
}
