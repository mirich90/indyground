<?php

namespace App\Models;

use App\Model;

class Task extends Model
{
  const TABLE = 'tasks';


  public $attributes = [
    'author' => 0,
    'description' => '',
    'priority' => '',
    'state' => 1,
    'status' => '',
    // 'subtasks' => '',
    'title' => '',
    'worker_id' => 0,
  ];

  public function findAllByAuthor($author)
  {
    $table = static::TABLE;

    $sql = "SELECT t.*, 
      GROUP_CONCAT(s.title ORDER BY s.id SEPARATOR '||') AS subtasks,
      GROUP_CONCAT(s.status ORDER BY s.id SEPARATOR '||') AS subtask_statuses,
      GROUP_CONCAT(s.id ORDER BY s.id SEPARATOR '||') AS subtask_ids
      FROM `tasks` AS t
      LEFT JOIN subtasks s ON s.task_id = t.id
      WHERE author = :author
      GROUP BY t.id ORDER BY t.id DESC";

    $data = $this->pdo->query(
      $sql,
      [':author' => $author],
      static::class,
      true
    );

    return $data ? json_encode($data, JSON_UNESCAPED_UNICODE) :  json_encode(array(), JSON_UNESCAPED_UNICODE);
  }

  // public function edit()
  // {
  //   $table = static::TABLE;
  //   $id = $this->attributes["id"];
  //   $author = $this->attributes["author"];
  //   $description = $this->attributes["description"];
  //   $description = $this->attributes["description"];
  //   $user = $this->attributes["user"];

  //   $sql = "INSERT INTO $table
  //     SET name_table=:name_table, user=:user, article_id=:article_id, `state`=1 
  //     ON DUPLICATE KEY UPDATE `state` = not `state`, datetime=CURRENT_TIMESTAMP";

  //   $this->pdo->execute(
  //     $sql,
  //     [':name_table' => $name_table, ':article_id' => $article_id, ':user' => $user]
  //   );

  //   return $this->pdo->getLastId();
  // }
}
