<?php

namespace App\Models;

use App\Model;

class Comment extends Model
{
    const TABLE = 'comments';

    public $attributes = [
        'text' => '',
    ];

    public $rules = [
        'required' => [
            ['text']

        ],
        'lengthMin' => [
            ['text', 100],
        ],
    ];

    public function findAllByIdArticle($id, $sort = 'new', $where = 'article_id')
    {
        $userId = $_SESSION['user']["id"] | 0;
        switch ($sort) {
            case "new":
                $sort = "GROUP BY c.id ORDER BY id DESC";
                break;
            case "old":
                $sort = "GROUP BY c.id ORDER BY id ASC";
                break;
            case 'best':
                $sort = "GROUP BY c.id ORDER BY sum_likes DESC, id DESC";
                break;
        }

        $sql = "
            SELECT c.*, u.name AS username, u.ava AS ava,
            ANY_VALUE(l.state) AS 'is_like', ANY_VALUE(b.state) AS 'is_bookmark',
            COUNT(DISTINCT l.user) AS 'sum_likes', COUNT(DISTINCT b.user) AS 'sum_bookmarks'
            FROM comments c
            LEFT JOIN users u ON c.author = u.id
            LEFT JOIN likes l ON c.id = l.article_id AND l.name_table = 'comments' AND l.state=1
            LEFT JOIN likes is_like ON c.id = l.article_id AND l.name_table = 'comments' AND l.state=1 AND l.user=$userId
            LEFT JOIN bookmarks b ON c.id = b.article_id AND b.name_table = 'comments' AND b.state=1
            LEFT JOIN bookmarks is_bookmark ON c.id = b.article_id AND b.name_table = 'comments' AND b.state=1 AND b.user=$userId
            WHERE c.$where=$id
            $sort
        ";
        return $this->pdo->query(
            $sql,
            [],
            static::class,
            true
        );
    }
}
