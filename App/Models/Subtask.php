<?php

namespace App\Models;

use App\Model;

class Subtask extends Model
{
  const TABLE = 'subtasks';

  public $attributes = [
    'user_id' => 0,
    'title' => '',
    'status' => 0,
  ];

  // public function findAllByAuthor($author)
  // {
  //   $table = static::TABLE;

  //   $sql = "SELECT t.*, 
  //     GROUP_CONCAT(DISTINCT s.title) AS subtasks,
  //     GROUP_CONCAT(DISTINCT s.id) AS subtask_ids
  //     FROM `$table` AS t LEFT JOIN subtasks s ON s.task_id = t.id
  //     WHERE author = :author
  //     GROUP BY t.id ORDER BY t.id DESC";

  //   $data = $this->pdo->query(
  //     $sql,
  //     [':author' => $author],
  //     static::class,
  //     true
  //   );

  //   return $data ? json_encode($data, JSON_UNESCAPED_UNICODE) : null;
  // }
}
