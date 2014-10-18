<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\db\Transaksi;

/**
 * TransaksiSearch represents the model behind the search form about `app\models\db\Transaksi`.
 */
class TransaksiSearch extends Transaksi
{
    public $tanggal_awal;
    public $tanggal_akhir;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'no_order', 'nominal', 'jumlah_siaran', 'siaran_per_hari', 'teks_spot', 'akun_id'], 'integer'],
            [['tanggal','tanggal_awal','tanggal_akhir'],'date'],
            [['nama', 'tanggal', 'produk', 'terbilang', 'deskripsi', 'jenis_transaksi'], 'safe'],
            
            [['tanggal'],'required','on' => 'edit'],
            //[['tanggal_awal','tanggal_akhir','']]
            ['tanggal_awal','compare','compareAttribute' => 'tanggal_akhir','operator' => '<='],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return [
            'edit' => ['tanggal'],
            'bukubesar' => ['tanggal_awal','tanggal_akhir','akun_id']
        ]
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
        $query = Transaksi::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'no_order' => $this->no_order,
            'nominal' => $this->nominal,
            'jumlah_siaran' => $this->jumlah_siaran,
            'siaran_per_hari' => $this->siaran_per_hari,
            'teks_spot' => $this->teks_spot,
            'akun_id' => $this->akun_id,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'produk', $this->produk])
            ->andFilterWhere(['like', 'terbilang', $this->terbilang])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'jenis_transaksi', $this->jenis_transaksi]);

        return $dataProvider;
    }
}
