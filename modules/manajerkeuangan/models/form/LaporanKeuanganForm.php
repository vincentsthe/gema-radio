<?php
namespace app\modules\manajerkeuangan\models\form;

use Yii;

use yii\base\Model;

class LaporanKeuanganForm extends Model
{
    public $tanggal_awal; //user id
    public $tanggal_akhir;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            //[['tanggal_awal','tanggal_akhir'], 'required'],
            [['tanggal_awal','tanggal_akhir'],'date','format'=>'yyyy-MM-dd'],

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
        ];
    }

}

?>