<?php


class TaskboardController extends Controller
{
    public function indexAction()
    {
        $this->redirect('/');
    }

    public function addAction()
    {
        /** @var Taskboard $taskboard */
        $taskboard = $this->model('Taskboard');

        $resultValidateEmail = $this->validateEmail($_POST['email'], 64);
        if ( !$resultValidateEmail['success'] ) {
            $_SESSION['error_message'] = $resultValidateEmail['error']['message'];
            $this->redirect('/');
        }

        $resultValidateName = $this->validateField($_POST['name'], 'Имя', 64);
        if ( !$resultValidateName['success'] ) {
            $_SESSION['error_message'] = $resultValidateName['error']['message'];
            $this->redirect('/');
        }

        $resultValidateDescription = $this->validateField($_POST['description'], 'Описание', 65535);
        if ( !$resultValidateDescription['success'] ) {
            $_SESSION['error_message'] = $resultValidateDescription['error']['message'];
            $this->redirect('/');
        }

        $data = [
            'name'        => $_POST['name'],
            'email'       => $_POST['email'],
            'description' => $_POST['description'],
        ];

        $resultAdd = $taskboard->add( $data );

        if ( !$resultAdd['success'] ) {
            $_SESSION['error_message'] = $resultAdd['error']['message'];
        } else {
            $_SESSION['success_message'] = "Задача успешно создана";
        }

        $this->redirect('/');
    }

    public function editAction()
    {
        /** @var User $user */
        $user = $this->model('User');
        if ( !$user->isAuth() ) {
            $_SESSION['error_message'] = "Авторизуйтесь для данного действия";
            $this->redirect('/');
        }

        /** @var Taskboard $taskboard */
        $taskboard = $this->model('Taskboard');

        $resultValidateEmail = $this->validateEmail($_POST['email'], 64);
        if ( !$resultValidateEmail['success'] ) {
            $_SESSION['error_message'] = $resultValidateEmail['error']['message'];
            $this->redirect('/');
        }

        $resultValidateName = $this->validateField($_POST['name'], 'Имя', 64);
        if ( !$resultValidateName['success'] ) {
            $_SESSION['error_message'] = $resultValidateName['error']['message'];
            $this->redirect('/');
        }

        $resultValidateDescription = $this->validateField($_POST['description'], 'Описание', 65535);
        if ( !$resultValidateDescription['success'] ) {
            $_SESSION['error_message'] = $resultValidateDescription['error']['message'];
            $this->redirect('/');
        }

        $data = [
            'id'          => $_POST['id'],
            'name'        => $_POST['name'],
            'email'       => $_POST['email'],
            'description' => $_POST['description'],
        ];

        $taskboard->update( $data );

        $_SESSION['success_message'] = "Задача успешно отредактирована";

        $this->redirect('/');
    }

    public function completeAction()
    {
        /** @var User $user */
        $user = $this->model('User');
        if ( !$user->isAuth() ) {
            $_SESSION['error_message'] = "Авторизуйтесь для данного действия";
            $this->redirect('/');
        }

        /** @var Taskboard $taskboard */
        $taskboard = $this->model('Taskboard');

        $taskboard->setComplete( $_POST['id'] );

        $_SESSION['success_message'] = "Задача успешно завершена";

        $this->redirect('/');
    }
}