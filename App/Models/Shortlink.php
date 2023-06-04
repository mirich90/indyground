<?php

namespace App\Models;

use App\Model;

class Shortlink extends Model
{
    const TABLE = 'short_links';

    public $attributes = [
        'title' => '',
        'original_url' => '',
        'short_url' => '',
    ];

    public $rules = [
        'required' => [
            ['title'],
            ['original_url'],
            ['short_url'],

        ],
        'lengthMin' => [
            ['short_url', 4],
        ],
    ];

    public function delete()
    {
        $table = static::TABLE;
        $article = $this->attributes["article"];

        $sql = "DELETE FROM $table WHERE article = :article";
        return $this->pdo->execute($sql, [':article' => $article]);
    }
}
