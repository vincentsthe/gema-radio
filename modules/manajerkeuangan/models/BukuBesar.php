<?php
namespace app\modules\manajerkeuangan\models;

use Yii;

use yii\base\Model;
use app\models\db\TransaksiLain;
use yii\data\ActiveDataProvider;

class BukuBesar extends TransaksiLain
{
    public $tanggal_awal; //user id
    public $tanggal_akhir;
    public $akun_id;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            //[['tanggal_awal','tanggal_akhir','akun_id'], 'required'],
            [['akun_id'], 'integer'],
            [['tanggal_awal','tanggal_akhir'],'string'],

            ['tanggal_awal','compare','compareAttribute' => 'tanggal_akhir','operator' => '<='],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function attributeLabels()
    {
        return [
            'tanggal_awal' => 'Tanggal Awal',
            'tanggal_akhir' => 'Tanggal Akhir',
            'akun_id' => 'Akun'
        ];
    }

    public function search($params)
    {
        $query = TransaksiLain::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->load($params) && $this->validate()){
            return $dataProvider;
        }

        $query->andFilterWhere(['=','akun_id',$this->akun_id]);
        $query->andFilterWhere(['between','tanggal',$this->tanggal_awal,$this->tanggal_akhir]);
        $query->orderBy(['id' => SORT_DESC]);
        return $dataProvider;
    }

}

?>