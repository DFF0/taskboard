<?php


class Taskboard extends Model
{
    /**
     * @param $data
     * @return array|bool[]
     */
    public function add( $data )
    {
        $this->db->query(
            "INSERT INTO `tasks` SET
                        `name` = :name,
                        `email` = :email,
                        `description` = :description
                        ",
            [
                'name'        => $data['name'],
                'email'       => $data['email'],
                'description' => $data['description'],
            ]
        );

        if ( empty($this->db->lastInsertId()) ) {
            return [
                'success' => false,
                'error' => [
                    'message' => 'Не удалось создать задачу',
                ]
            ];
        }

        return [ 'success' => true ];
    }

    /**
     * @param $id
     * @return array
     */
    public function setComplete( $id )
    {
        $stmt = $this->db->query("UPDATE `tasks` SET `is_completed` = 1 WHERE `id` = :id", ['id' => $id]);

        if ( $stmt === FALSE ) {
            return [
                'success' => false,
                'error' => [
                    'message' => 'Не удалось завершить задачу',
                ]
            ];
        }

        return [ 'success' => true ];
    }

    /**
     * @param $data
     * @return array
     */
    public function update( $data )
    {
        $stmt = $this->db->query(
            "UPDATE `tasks` SET 
                 `is_edited` = 1, `name` = :name, 
                 `email` = :email, `description` = :description 
            WHERE `id` = :id",
            [
                'name'          => $data['name'],
                'email'         => $data['email'],
                'description'   => $data['description'],
                'id'            => $data['id'],
            ]
        );

        if ( $stmt === FALSE ) {
            return [
                'success' => false,
                'error' => [
                    'message' => 'Не удалось обновить задачу',
                ]
            ];
        }

        return [ 'success' => true ];
    }

    /**
     * получает список задач из базы.
     * @param $page - номер текущей страницы
     * @param $limit - количество элементов на странице
     * @param string $sort - имя поля, по которому будет сортировка
     * @param string $dir - направление сортировки
     * @return array
     */
    public function getTasks( $page, $limit, $sort = 'id', $dir = 'asc' )
    {
        $start = ($page - 1) * $limit;
        $end = $page * $limit;
        $stmt = $this->db->query(
            "SELECT `id`, `name`, `email`, `description`, `is_edited`, `is_completed` 
            FROM `tasks` ORDER BY {$sort} {$dir} LIMIT {$start},{$end}"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function getCountTasks()
    {
        $stmt = $this->db->query("SELECT count(*) FROM `tasks`");
        return $stmt->fetchColumn();
    }
}