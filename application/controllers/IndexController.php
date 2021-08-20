<?php

class IndexController extends Controller
{
    public function indexAction()
    {
        if ( isset($_SESSION['error_message']) && !empty($_SESSION['error_message']) ) {
            $this->data['error_message'] = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        if ( isset($_SESSION['success_message']) && !empty($_SESSION['success_message']) ) {
            $this->data['success_message'] = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }

        if ( isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth']) ) {
            $this->data['user_auth'] = $_SESSION['user_auth'];
        }

        /** @var Taskboard $taskboard */
        $taskboard = $this->model('Taskboard');

        $countTasks = $taskboard->getCountTasks();

        $maxPage = ceil($countTasks / LIMIT_TASKS);
        if ( $maxPage == 0 ) {
            $maxPage = 1;
        }

        if ( isset($_GET['page']) && !empty($_GET['page']) ) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        if ( $page < 1 ) {
            $page = 1;
        } else if ( $page > $maxPage ) {
            $page = $maxPage;
        }

        $this->data['sort'] = 'id';
        $this->data['dir']  = 'asc';

        $validSort = [ 'id', 'name', 'email', 'is_completed' ];
        $validDir  = [ 'asc', 'desc' ];
        if ( isset($_GET['sort']) && !empty($_GET['sort']) ) {
            if ( in_array($_GET['sort'], $validSort) ) {
                $_SESSION['sort'] = $_GET['sort'];

                if ( isset($_GET['dir']) && !empty($_GET['dir']) ) {
                    if ( in_array($_GET['dir'], $validDir) ) {
                        $_SESSION['dir'] = $_GET['dir'];
                    } else {
                        $_SESSION['dir'] = 'asc';
                    }
                } else {
                    $_SESSION['dir'] = 'asc';
                }
            }
        }

        if ( isset($_SESSION['sort']) && isset($_SESSION['dir']) ) {
            $this->data['sort'] = $_SESSION['sort'];
            $this->data['dir']  = $_SESSION['dir'];
        }

        $this->data['cur_page'] = $page;
        $this->data['max_page'] = $maxPage;
        $this->data['tasks'] = $taskboard->getTasks($page, LIMIT_TASKS, $this->data['sort'], $this->data['dir']);

        $this->view();
    }
}