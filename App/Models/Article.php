<?php

namespace App\Models;

use App\Model;

class Article extends Model
{
    const TABLE = 'articles';

    public $attributes = [
        'title' => '',
        'category' => '',
        'description' => '',
        'keywords' => '',
    ];

    public $rules = [
        'required' => [
            ['title'],
            ['category'],
            ['keywords'],
            ['description']

        ],
        'lengthMin' => [
            ['title', 6],
        ],
    ];

    public function findBySrc($src)
    {
        $table = static::TABLE;
        $user = (isset($_SESSION['user'])) ? $_SESSION['user']["id"] : 0;
        $sql = "SELECT a.*,
        u.username AS username,
        u.name AS name,
        u.ava AS ava,
        c.name AS category_name,
        i.name AS image, i.filetype AS image_type,
        ANY_VALUE(l.state) AS 'like', ANY_VALUE(b.state) AS 'bookmark',
        GROUP_CONCAT(DISTINCT t.name) AS tags
        FROM (
            SELECT a.*,
            COUNT(DISTINCT l.user) AS 'sum_likes', COUNT(DISTINCT b.user) AS 'sum_bookmarks',
            COUNT(DISTINCT com.id) AS 'sum_comments'
            FROM $table a
            LEFT JOIN likes l ON a.id = l.article_id AND l.state=1
            LEFT JOIN bookmarks b ON a.id = b.article_id AND b.state=1
            LEFT JOIN comments com ON a.id = com.article_id
            WHERE a.src=:src
            GROUP BY a.id ORDER BY a.id DESC
        ) AS a
        LEFT JOIN tags t ON t.article = a.id
        LEFT JOIN users u ON a.author = u.id
        LEFT JOIN images i ON a.img = i.id
        LEFT JOIN categories c ON a.category = c.id
        LEFT JOIN likes l ON a.id = l.article_id AND l.user=$user
        LEFT JOIN bookmarks b ON a.id = b.article_id AND b.user=$user
        -- LEFT JOIN comments com ON a.id = com.article_id AND com.user=$user
        GROUP BY a.id ORDER BY a.id DESC";

        $data = $this->pdo->query(
            $sql,
            [':src' => $src],
            static::class,
            true
        );
        return $data ? $data[0] : null;
    }

    public function get()
    {
        $where_table = '';
        $table = static::TABLE;
        $tags = $_GET['tag'];

        if ($tags != '') {
            $strTags = '';
            $arrTags = explode(',', $tags);
            foreach ($arrTags as $key => $value) {
                $strTags .= " t.name='$value' ";
                if ($key === 0) {
                    $strTags .= 'OR';
                }
            }

            $where_table = "
            (
                SELECT a.* FROM tags t
				JOIN $table a ON t.article=a.id
				WHERE $strTags
            )";
        }

        $sql = "
            SELECT * FROM $where_table as a
            GROUP BY a.id ORDER BY a.id DESC
        ";

        return $this->pdo->query(
            $sql,
            [],
            static::class,
            true
        );
    }

    public function findAll($sort = 'DESC')
    {
        $table = static::TABLE;
        $user = (isset($_SESSION['user'])) ? $_SESSION['user']["id"] : 0;
        $tag =  get('tag');
        $category =  get('category');
        $bookmarks =  get('bookmarks');
        $likes =  get('likes');
        $username =  get('username');
        $where_table  = $table;
        $where_user  = '';

        if ($category != '') {
            $where_table = "
            (
                SELECT a.*, c.name AS category_name FROM categories c
				JOIN articles a ON c.id=a.category
				WHERE c.id=$category
            )";
        }
        if ($tag != '') {
            $where_table = "
            (
                SELECT a.* FROM tags t
				JOIN articles a ON t.article=a.id
				WHERE t.name='$tag'
            )";
        }
        if ($bookmarks != '') {
            $where_table = "
            (
                SELECT a.* FROM bookmarks b
				JOIN articles a ON b.article_id=a.id
				WHERE b.article_id=a.id AND b.user=$user AND b.state=1
            )";
        }
        if ($likes != '') {
            $where_table = "
            (
                SELECT a.* FROM likes l
				JOIN articles a ON l.article_id=a.id
				WHERE l.article_id=a.id AND l.user=$user AND l.state=1
            )";
        }
        if ($username != '') {
            $where_user = "WHERE u.username='$username'";
        }

        $sql = "SELECT a.*,
            u.name as name, 
            u.username as username, 
            i.name AS image,
            i.filetype AS image_type, 
            (SELECT l.state FROM likes l WHERE a.id = l.article_id AND l.user=$user AND l.name_table = 'articles') AS 'like', 
            (SELECT b.state FROM bookmarks b WHERE a.id = b.article_id AND b.user=$user AND b.name_table = 'articles') AS 'bookmark', 
            GROUP_CONCAT(DISTINCT t.name) AS tags,
            COUNT(DISTINCT l.user) AS 'sum_likes', COUNT(DISTINCT b.user) AS 'sum_bookmarks'
            FROM $where_table AS a 
            LEFT JOIN likes l ON a.id = l.article_id AND l.state=1 
            LEFT JOIN bookmarks b ON a.id = b.article_id AND b.state=1 
            LEFT JOIN tags t ON t.article = a.id 
            LEFT JOIN users u ON a.author = u.id 
            LEFT JOIN images i ON a.img = i.id 
            $where_user
            GROUP BY a.id ORDER BY a.id $sort";

        return $this->pdo->query(
            $sql,
            [':sort' => $sort],
            static::class,
            true
        );
    }
}
