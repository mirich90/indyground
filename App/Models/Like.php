<?php

namespace App\Models;

use App\Model;

class Like extends Model
{
  const TABLE = 'likes';

  public $attributes = [
    'name_table' => '',
    'article_id' => '',
  ];

  public function getCount(){
    $table = static::TABLE;
    $name_table = $this->attributes["name_table"];
    $article_id = $this->attributes["article_id"];
    $user = $this->attributes["user"];

    $sql = "SELECT count(*) as sum,
      (SELECT state FROM $table WHERE user=:user AND article_id=:article_id) as is_state
      FROM $table
      WHERE article_id=:article_id and name_table=:name_table and `state`=1";

    return $this->pdo->query(
        $sql,
        [':name_table' => $name_table, ':article_id' => $article_id, ':user' => $user],
        static::class
    );
    
  }

  public function add()
  {
    $table = static::TABLE;
    $name_table = $this->attributes["name_table"];
    $article_id = $this->attributes["article_id"];
    $user = $this->attributes["user"];

    $sql = "INSERT INTO $table
      SET name_table=:name_table, user=:user, article_id=:article_id, `state`=1 
      ON DUPLICATE KEY UPDATE `state` = not `state`, datetime=CURRENT_TIMESTAMP";

    $this->pdo->execute(
      $sql,
      [':name_table' => $name_table, ':article_id' => $article_id, ':user' => $user]
    );

    return $this->pdo->getLastId();
  }
}