<?php

class User extends Model
{
    /**
     * @param array $data
     * @return array
     */
    public function login(array $data): array
    {
        // захардкодим данные админа
        $adminData = ['login' => 'admin', 'pass' => '123'];

        if ( $data['login'] === $adminData['login'] && $data['pass'] === $adminData['pass'] ) {
            $result = [
                'success' => true,
                'data' => $adminData,
            ];
        } else {
            $result = [
                'success' => false,
                'error' => [
                    'message' => "Неверный логин или пароль",
                ]
            ];
        }

        return $result;
    }

    /**
     * Авторизирован ли админ
     * @return bool
     */
    public function isAuth(): bool
    {
        return isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth']);
    }
}