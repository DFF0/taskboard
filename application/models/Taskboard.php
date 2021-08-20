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
     */
    public function setComplete( $id )
    {
        $this->db->query("UPDATE `tasks` SET `is_completed` = 1 WHERE `id` = :id", ['id' => $id]);
    }

    /**
     * @param $data
     */
    public function update( $data )
    {
        $this->db->query(
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
    }

    public function getTasks( $page, $limit, $sort = 'id', $dir = 'asc' )
    {
        $start = ($page - 1) * $limit;
        $end = $page * $limit;
        $stmt = $this->db->query("SELECT * FROM `tasks` ORDER BY {$sort} {$dir} LIMIT {$start},{$end}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountTasks()
    {
        $stmt = $this->db->query("SELECT count(*) FROM `tasks`");
        return $stmt->fetchColumn();
    }
}