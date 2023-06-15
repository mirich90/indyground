<?php

namespace App\Models;

use App\Model;

class ShortlinkCategory extends Model
{
    const TABLE = 'short_link_categories';

    public $attributes = [
        'name' => '',
    ];

    public $rules = [
        'required' => [
            ['name'],
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
