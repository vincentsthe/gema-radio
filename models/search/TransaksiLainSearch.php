<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\db\TransaksiLain;

/**
 * TransaksiLainSearch represents the model behind the search form about `app\models\db\TransaksiLain`.
 */
class TransaksiLainSearch extends TransaksiLain
{
    public $tanggal_awal;
    public $tanggal_akhir;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'akun_id', 'nominal'], 'integer'],
            [['kegiatan', 'jenis_transaksi', 'tanggal', 'terbilang'], 'safe'],
            [['tanggal','tanggal_awal','tanggal_akhir'],'date'],
            ['tanggal_awal','compare','compareAttribute' => 'tanggal_akhir','operator' => '<='],
        ];
    }

    /**
     * @inheritdoc
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
        $query = TransaksiLain::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'akun_id' => $this->akun_id,
            'tanggal' => $this->tanggal,
            'nominal' => $this->nominal,
        ]);

        $query->andFilterWhere(['like', 'kegiatan', $this->kegiatan])
            ->andFilterWhere(['like', 'jenis_transaksi', $this->jenis_transaksi])
            ->andFilterWhere(['like', 'terbilang', $this->terbilang]);

        return $dataProvider;
    }
}
