<?php

namespace app\models\db;

use app\helpers\TimeHelper;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "transaksi".
 *
 * @property integer $id
 * @property string $nama
 * @property string $tanggal
 * @property integer $no_order
 * @property string $produk
 * @property integer $nominal
 * @property string $terbilang
 * @property integer $jumlah_siaran
 * @property integer $siaran_per_hari
 * @property string $deskripsi
 * @property string $jenis_transaksi
 * @property integer $frekuensi
 *
 * @property Rekaman[] $rekamen
 * @property Siaran[] $siarans
 */
class Transaksi extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'transaksi';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['nama', 'tanggal', 'nominal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'jenis_periode'], 'required'],
			[['nama', 'tanggal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'periode_awal', 'periode_akhir', 'no_order'], 'string'],
			[['siaran_per_hari', 'jumlah_siaran', 'frekuensi'], 'integer'],
			[['tanggal'], 'safe'],
			[['nama', 'produk'], 'string', 'max' => 100],
			[['terbilang'], 'string', 'max' => 300]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'nama' => 'Nama',
			'tanggal' => 'Tanggal',
			'no_order' => 'No Order',
			'produk' => 'Produk',
			'nominal' => 'Nominal',
			'terbilang' => 'Terbilang',
			'jumlah_siaran' => 'Jumlah Siaran',
			'siaran_per_hari' => 'Siaran Per Hari',
			'deskripsi' => 'Deskripsi',
			'jenis_transaksi' => 'Jenis Transaksi',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRekaman()
	{
		return $this->hasMany(Rekaman::className(), ['transaksi_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSiarans()
	{
		return $this->hasMany(Siaran::className(), ['transaksi_id' => 'id']);
	}

	public function haveSiaran() {
		return (($this->jenis_transaksi == "Berita Kehilangan")
				|| ($this->jenis_transaksi == "Iklan nasional")
				|| ($this->jenis_transaksi == "Iklan lokal")
				|| ($this->jenis_transaksi == "Pengumuman"));
	}

	public function haveRekaman() {
		return (($this->jenis_transaksi == "Rekaman")
				|| ($this->jenis_transaksi == "Iklan lokal")
				|| ($this->jenis_transaksi == "Iklan nasional" ));
	}

	public function fillFromSiaranForm($transaksiSiaranForm) {
		$this->nama = $transaksiSiaranForm->nama;
		$this->tanggal = $transaksiSiaranForm->tanggal;
		$this->nominal = $transaksiSiaranForm->nominal;
		$this->terbilang = $transaksiSiaranForm->terbilang;
		$this->deskripsi = $transaksiSiaranForm->deskripsi;
		$this->no_order = $transaksiSiaranForm->no_order;
		$this->jenis_periode = $transaksiSiaranForm->jenis_periode;
		$this->jenis_transaksi = $transaksiSiaranForm->jenis_transaksi;
		$this->jumlah_siaran = $transaksiSiaranForm->jumlah_siaran;
	}

	public function fillFromPeriodeForm($transaksiPeriodeForm) {
		$this->nama = $transaksiPeriodeForm->nama;
		$this->tanggal = $transaksiPeriodeForm->tanggal;
		$this->nominal = $transaksiPeriodeForm->nominal;
		$this->terbilang = $transaksiPeriodeForm->terbilang;
		$this->deskripsi = $transaksiPeriodeForm->deskripsi;
		$this->no_order = $transaksiPeriodeForm->no_order;
		$this->jenis_periode = $transaksiPeriodeForm->jenis_periode;
		$this->jenis_transaksi = $transaksiPeriodeForm->jenis_transaksi;
		$this->siaran_per_hari = $transaksiPeriodeForm->siaran_per_hari;
		$this->frekuensi = $transaksiPeriodeForm->frekuensi;
		$this->periode_awal = $transaksiPeriodeForm->periode_awal;
		$this->periode_akhir = $transaksiPeriodeForm->periode_akhir;
	}

	public function getSerialNumber() {
		return (new Query())->select(['COUNT(*) AS cnt'])
							->from('transaksi')
							->andWhere('id<' . $this->id)
							->andWhere('tanggal>=' . TimeHelper::getBeginningYear($this->tanggal))
							->all()[0]['cnt'] + 1;
	}

	public function getTransactionNumber() {
		return preg_replace("/-/", "/", $this->tanggal) . "-" . $this->getSerialNumber();
	}
}
