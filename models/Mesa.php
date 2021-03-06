<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mesa".
 *
 * @property integer $idMesa
 * @property string $numeroDaMesa
 * @property integer $disponivel
 * @property integer $alerta
 * @property string $qrcode
 * @property string $chave
 * @property integer $cont
 *
 * @property Comanda[] $comandas
 */
class Mesa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mesa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['numeroDaMesa', 'disponivel', 'alerta', 'qrcode', 'chave'], 'required'],

            [['alerta', 'cont'], 'integer'],
            [['numeroDaMesa', 'chave'], 'string', 'max' => 45],
            [['qrcode'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idMesa' => 'Identificador da Mesa',
            'numeroDaMesa' => 'Número da Mesa',

            'alerta' => 'Alerta',
            'qrcode' => 'Qrcode',
            'chave' => 'Chave',
            'cont' => 'Cont',
        ];
    }

}
