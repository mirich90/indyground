<?php

namespace App\Models;

use App\Model;

class Content extends Model
{
    const TABLE = 'contents';

    public $attributes = [
        'html' => '',
        'tag' => '',
        'lang' => '',
        'src' => '',
        'alt' => '',
        'article_id' => '',
    ];

    public function getContent($id)
    {
        $table = static::TABLE;
        $sql = "SELECT * FROM $table WHERE article_id = :id
                GROUP BY id ORDER BY id ASC";
        return $this->pdo->query(
            $sql,
            [':id' => $id],
            static::class,
            true
        );
    }

    public function delete()
    {
        $table = static::TABLE;
        $article_id = $this->attributes["article_id"];

        $sql = "DELETE FROM $table WHERE article_id = :article_id";
        return $this->pdo->execute($sql, [':article_id' => $article_id]);
    }
}
