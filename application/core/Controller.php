<?php

class Controller
{
    /** @var array $data */
    public array $data;

    protected static function getClassName()
    {
        return get_called_class();
    }

    protected function redirect($location, $code = 302)
    {
        header("Location: {$location}", true, $code);

        exit;
    }

    public function model($model)
    {
        require_once(APP_PATH . '/models/'.$model.'.php');
        return new $model();
    }

    public function view($view = 'index', $template = 'template_view', $dir = '')
    {
        if ( empty($dir) ) {
            $dir = strtolower(str_replace('Controller', '', $this::getClassName()));
        }

        $content_view = $dir . '/' . $view.'.php';

        if ( !file_exists(APP_PATH . 'views/' . $content_view) ) {
            // TODO:  редирект на страницу с ошибкой
        }

        if ( file_exists(APP_PATH . "views/{$template}.php") ) {
            require_once(APP_PATH . "views/{$template}.php");
        }

        unset($this->data);
    }

    /**
     * проверка валидности почты
     * @param string $email
     * @param int $maxLength - 0 - unlimited
     * @param bool $required
     * @return array
     */
    protected function validateEmail(string $email, $maxLength = 255, $required = true): array
    {
        if ( $email !== '' ) {
            if ( $maxLength > 0 && strlen($email) > $maxLength ) {
                $result = [
                    'success' => false,
                    'error' => [
                        'message' => "Превышена максимальная допустимая длинна в {$maxLength} символов.",
                    ]
                ];
            } else {
                // проверка наличия '@' и '.'
                $pattern = "/.+@.+\..+/i";
                if ( preg_match($pattern, $email) !== 1 ) {
                    $result = [
                        'success' => false,
                        'error' => [
                            'message' => "Некорректный E-mail.",
                        ]
                    ];
                } else {
                    $result = [
                        'success' => true,
                    ];
                }
            }
        } elseif ( $required ) {
            $result = [
                'success' => false,
                'error' => [
                    'message' => "E-mail обязателен для заполнения и не может быть пустым.",
                ]
            ];
        } else {
            $result = [
                'success' => true,
            ];
        }

        return $result;
    }

    /**
     * проверка поля
     * @param string $text
     * @param string $fieldName
     * @param int $maxLength
     * @param bool $required
     * @return array
     */
    protected function validateField(string $text, string $fieldName, $maxLength = 255, $required = true): array
    {
        if ( $text !== '' ) {
            if ( $maxLength > 0 && strlen($text) > $maxLength ) {
                $result = [
                    'success' => false,
                    'error' => [
                        'message' => "У поля {$fieldName} превышена максимальная допустимая длинна в {$maxLength} символов.",
                    ]
                ];
            } else {
                $result = [
                    'success' => true,
                ];
            }
        } elseif ( $required ) {
            $result = [
                'success' => false,
                'error' => [
                    'message' => "Поле {$fieldName} обязательно для заполнения и не может быть пустым.",
                ]
            ];
        } else {
            $result = [
                'success' => true,
            ];
        }

        return $result;
    }
}
