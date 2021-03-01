<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "deposit".
 *
 * @property int $transId
 * @property string|null $merchantrequestId
 * @property int $walletId
 * @property float $transAmount
 * @property string $details
 * @property string|null $reciept
 * @property string $transDate
 * @property int $createdBy
 * @property int|null $status
 * @property int $phoneCode
 * @property int $mpesaNumber
 *
 * @property User $createdBy0
 * @property Wallet $wallet
 */
class Deposit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deposit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['walletId', 'transAmount', 'details', 'createdBy', 'phoneCode', 'mpesaNumber'], 'required'],
            [['walletId', 'createdBy', 'status', 'phoneCode', 'mpesaNumber'], 'integer'],
            [['transAmount'], 'number'],
            [['details'], 'string'],
            [['transDate'], 'safe'],
            [['merchantrequestId', 'reciept'], 'string', 'max' => 255],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['walletId'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::className(), 'targetAttribute' => ['walletId' => 'walletId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transId' => 'Trans ID',
            'merchantrequestId' => 'Merchantrequest ID',
            'walletId' => 'Wallet ID',
            'transAmount' => 'Trans Amount',
            'details' => 'Details',
            'reciept' => 'Reciept',
            'transDate' => 'Trans Date',
            'createdBy' => 'Created By',
            'status' => 'Status',
            'phoneCode' => 'Phone Code',
            'mpesaNumber' => 'Mpesa Number',
        ];
    }

    /**
     * Gets query for [[CreatedBy0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'createdBy']);
    }

    /**
     * Gets query for [[Wallet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallet()
    {
        return $this->hasOne(Wallet::className(), ['walletId' => 'walletId']);
    }
}
