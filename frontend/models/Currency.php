<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $currencyId
 * @property string|null $currencyName
 * @property string|null $currencyCode
 *
 * @property Deposit[] $deposits
 * @property Profile[] $profiles
 * @property Wallet[] $wallets
 * @property Withdrawal[] $withdrawals
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currencyName'], 'string', 'max' => 64],
            [['currencyCode'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'currencyId' => 'Currency ID',
            'currencyName' => 'Currency Name',
            'currencyCode' => 'Currency Code',
        ];
    }

    /**
     * Gets query for [[Deposits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(Deposit::className(), ['currencyId' => 'currencyId']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['currencyId' => 'currencyId']);
    }

    /**
     * Gets query for [[Wallets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallets()
    {
        return $this->hasMany(Wallet::className(), ['currencyId' => 'currencyId']);
    }

    /**
     * Gets query for [[Withdrawals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWithdrawals()
    {
        return $this->hasMany(Withdrawal::className(), ['currencyId' => 'currencyId']);
    }
}
