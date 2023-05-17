<?php

namespace App\Models;

use App\Model;

class Image extends Model
{
    const TABLE = 'images';

    public $attributes = [
        'name' => '',
        'original_name' => '',
        'src' => '',
        'filetype' => '',
        'author' => '',
    ];

    public $rules = [
        'required' => [
            ['original_name'],
            ['author'],
        ],
    ];

    
    // public function edit()
    // {
        // $table = static::TABLE;
        // $name_table = $this->attributes["name_table"];
        // $article_id = $this->attributes["article_id"];
        // $user = $this->attributes["user"];

        // $sql = "UPDATE $table SET price=500 WHERE id=5";
        // $sql = "INSERT INTO $table
        // SET name_table=:name_table, user=:user, article_id=:article_id, `state`=1 
        // ON DUPLICATE KEY UPDATE `state` = not `state`, datetime=CURRENT_TIMESTAMP";
    
        // $this->pdo->execute(
        // $sql,
        // [':name_table' => $name_table, ':article_id' => $article_id, ':user' => $user]
        // );

        // return $this->pdo->getLastId();
    // }
}