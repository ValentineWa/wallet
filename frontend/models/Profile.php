<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $profileId
 * @property int $userId
 * @property string $fullName
 * @property int $countryId
 * @property string $idNumber
 * @property int $currencyId
 * @property int $phoneCode
 * @property string $phoneNumber
 * @property string $createdAt
 * @property int $createdBy
 *
 * @property Deposit[] $deposits
 * @property Country $country
 * @property User $createdBy0
 * @property Currency $currency
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'fullName', 'countryId', 'idNumber', 'currencyId', 'phoneCode', 'phoneNumber', 'createdBy'], 'required'],
            [['userId', 'countryId', 'currencyId', 'phoneCode', 'createdBy'], 'integer'],
            [['createdAt'], 'safe'],
            [['fullName', 'idNumber', 'phoneNumber'], 'string', 'max' => 255],
            [['countryId'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['countryId' => 'countryId']],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['currencyId'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currencyId' => 'currencyId']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profileId' => 'Profile ID',
            'userId' => 'User ID',
            'fullName' => 'Full Name',
            'countryId' => 'Country ID',
            'idNumber' => 'Id Number',
            'currencyId' => 'Currency ID',
            'phoneCode' => 'Phone Code',
            'phoneNumber' => 'Phone Number',
            'createdAt' => 'Created At',
            'createdBy' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Deposits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(Deposit::className(), ['createdBy' => 'profileId']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['countryId' => 'countryId']);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
