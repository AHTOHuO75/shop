<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/26/17
 * Time: 8:44 PM
 */

namespace shop\entities\User;


use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

/**
 * @property integer $user_id
 * @property string $identity
 * @property string $network
 */

class Network extends ActiveRecord
{

    public static function create($network, $identity): self
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $item = new static();
        $item->network = $network;
        $item->identity = $identity;
        return $item;
    }

    public function isFor($network, $identity): bool
    {
        return $this->network === $network && $this->identity === $identity;
    }


    public static function tableName()
    {
        return '{{%user_networks}}';
    }
}