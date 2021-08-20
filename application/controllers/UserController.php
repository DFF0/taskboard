<?php


class UserController extends Controller
{
    public function indexAction()
    {
        $this->redirect('/');
    }

    public function loginAction()
    {
        /** @var User $user */
        $user = $this->model('User');

        if ( $user->isAuth() ) {
            $this->redirect("/");
        }

        $resultValidateLogin = $this->validateField($_POST['login'], 'Логин', 64);
        if ( !$resultValidateLogin['success'] ) {
            $_SESSION['error_message'] = $resultValidateLogin['error']['message'];
            $this->redirect('/');
        }
        $resultValidatePass = $this->validateField($_POST['pass'], 'Пароль', 64);
        if ( !$resultValidatePass['success'] ) {
            $_SESSION['error_message'] = $resultValidatePass['error']['message'];
            $this->redirect('/');
        }

        $data = [
            'login' => $_POST['login'],
            'pass'  => $_POST['pass'],
        ];

        $result = $user->login( $data );

        if ( !$result['success'] ) {
            $_SESSION['error_message'] = $result['error']['message'];
        } else {
            $_SESSION['user_auth'] = ['login' => $result['data']['login']];
        }

        $this->redirect('/');
    }


    public function exitAction()
    {
        unset($_SESSION['user_auth']);

        $this->redirect('/');
    }
}