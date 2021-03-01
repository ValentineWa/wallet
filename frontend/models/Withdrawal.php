<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "withdrawal".
 *
 * @property int $transId
 * @property int $originatorconversationId
 * @property int $walletId
 * @property float $transAmount
 * @property string $details
 * @property int $currencyId
 * @property string $reciept
 * @property string $transDate
 * @property int $createdBy
 * @property int|null $status Status 0 represents available, status 1 represents unavailable
 *
 * @property User $createdBy0
 * @property Currency $currency
 * @property Wallet $wallet
 */
class Withdrawal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'withdrawal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['originatorconversationId', 'walletId', 'transAmount', 'details', 'currencyId', 'reciept', 'createdBy'], 'required'],
            [['originatorconversationId', 'walletId', 'currencyId', 'createdBy', 'status'], 'integer'],
            [['transAmount'], 'number'],
            [['details'], 'string'],
            [['transDate'], 'safe'],
            [['reciept'], 'string', 'max' => 100],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['currencyId'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currencyId' => 'currencyId']],
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
            'originatorconversationId' => 'Originatorconversation ID',
            'walletId' => 'Wallet ID',
            'transAmount' => 'Trans Amount',
            'details' => 'Details',
            'currencyId' => 'Currency ID',
            'reciept' => 'Reciept',
            'transDate' => 'Trans Date',
            'createdBy' => 'Created By',
            'status' => 'Status',
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
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['currencyId' => 'currencyId']);
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
