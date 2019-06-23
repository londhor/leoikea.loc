<?php
namespace backend\forms;

use Yii;
use yii\base\Model;
use backend\models\Manager;

/**
 * Форма входа для админов
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильний логін або пароль');
            }
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * @return Manager|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Manager::findByEmail($this->username);
        }

        return $this->_user;
    }
}
