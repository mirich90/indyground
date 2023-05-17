<?php

namespace App\Models;

use App\Model;

class Tag extends Model
{
    const TABLE = 'tags';

    public $attributes = [
        'name' => '',
        'article' => '',
        'author' => '',
    ];

    public function delete()
    {
        $table = static::TABLE;
        $article = $this->attributes["article"];

        $sql = "DELETE FROM $table WHERE article = :article";
        return $this->pdo->execute($sql, [':article' => $article]);
    }
}
