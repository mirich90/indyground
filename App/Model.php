<?php

namespace App;

use Valitron\Validator as Validator;


abstract class Model
{

    const TABLE = '';
    protected $pdo;
    public $id;
    public $attributes = [];
    protected $pk = 'id';

    public $errors_validation = [];
    public $rules_validation = [];

    public function __construct()
    {
        $this->pdo = Db::instance();
    }

    //https://www.youtube.com/watch?v=3W3BTce8kns&list=PLD-piGJ3Dtl1gX1wh22vBeeg6gMP1VlnW&index=21
    public function validate($data)
    {

        Validator::langDir(__DIR__ . '/../vendor/vlucas/valitron/lang'); // always set langDir before lang.
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);
        if ($v->validate()) {
            return true;
        }
        $this->errors_validation = $v->errors();
        return false;
    }

    public function getErrorsValidate()
    {
        $errors = '<ul>';
        foreach ($this->errors_validation as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
        return $errors;
    }

    public function load($data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function save($field_name = null)
    {
        return $this->insert($field_name);
    }

    public function edit($field_name = null)
    {
        return $this->update($field_name);
    }
    public function query($sql)
    {
        return $this->pdo->execute($sql);
    }

    public function findAll($sort = 'DESC')
    {
        $table = static::TABLE;
        $sql = "SELECT * FROM $table ORDER BY id $sort";
        return $this->pdo->query(
            $sql,
            [':sort' => $sort],
            static::class,
            true
        );
    }

    public function countBy($field, $value)
    {
        $table = static::TABLE;
        $sql = "SELECT COUNT(*) as `count` FROM $table WHERE $field = :v";
        return $this->pdo->query(
            $sql,
            [':v' => $value],
            static::class,
            true
        )[0]['count'];
    }

    public function findAllBy($field, $value)
    {
        $table = static::TABLE;
        $sql = "SELECT * FROM $table WHERE $field = :v ORDER BY id DESC";
        return $this->pdo->query(
            $sql,
            [":v" => $value],
            static::class,
            true
        );
    }

    public function findAllByAuthor($id, $author = 'author')
    {
        $sql = 'SELECT * FROM ' . static::TABLE . " WHERE $author = ? ORDER BY id DESC";
        $data = $this->pdo->query(
            $sql,
            [$id],
            static::class,
            true
        );
        return $data;
    }

    public function findAllByTag($tag)
    {
        $sql = "SELECT a.*, u.name AS author_name,
        GROUP_CONCAT(distinct t_all.name) AS tags
        FROM tags t
        LEFT JOIN articles a ON t.article=a.id
        LEFT JOIN tags t_all ON t_all.article = a.id 
        LEFT JOIN users u ON a.author=u.id
        WHERE t.name='$tag'
        GROUP BY a.id ORDER BY id DESC";

        return $this->pdo->query(
            $sql,
            [],
            static::class
        );
    }

    public function findOne($id, $field = '')
    {
        $field = $field ?: $this->pk;
        $table = static::TABLE;
        $sql = "SELECT * FROM $table WHERE $field = :id LIMIT 1";
        return $this->pdo->query(
            $sql,
            [":id", $id],
            static::class
        );
    }


    public function findById($id)
    {
        $table = static::TABLE;

        $sql = "SELECT * FROM $table WHERE id=:id
        GROUP BY id ORDER BY id DESC";

        $data = $this->pdo->query(
            $sql,
            [':id' => $id],
            static::class,
            true
        );
        return $data ? $data[0] : null;
    }

    public function find($fields, $value, $operator = 'AND')
    {
        $attrs = '';

        foreach ($fields as $key => $field) {
            $op = ($key == 0) ? '' : $operator;
            $attrs .= "$op $field=? ";
        }


        $table = static::TABLE;
        $sql = "SELECT * FROM $table WHERE $attrs LIMIT 1";
        $data = $this->pdo->query(
            $sql,
            $value,
            static::class,
            true
        );
        return $data ? $data[0] : null;
    }

    public function insert($field_name = null)
    {
        $fields = $this->attributes;
        $cols = [];
        $data = [];

        foreach ($fields as $name => $value) {
            if ('id' == $name) {
                continue;
            }

            $cols[] = $name;
            $data[":$name"] = $value;
        }

        $name = implode(',', $cols);
        $value = implode(',', array_keys($data));
        $sql = 'INSERT INTO ' . static::TABLE . " ($name) VALUES ($value)";

        $this->pdo->execute($sql, $data);
        $this->id = $this->pdo->getLastId();
        return ($field_name) ? $data[":$field_name"] : $this->id;
    }

    public function update($field_name = null)
    {
        $fields = $this->attributes;
        $table = static::TABLE;
        $data = [];
        $sets = [];

        if ($field_name) {
            $sets[] = "$field_name = :$field_name";
            $data[":$field_name"] = $fields[$field_name];
            $data[":id"] = $fields['id'];
        } else {
            foreach ($fields as $name => $value) {
                if ('id' != $name) {
                    $sets[] = "$name = :$name";
                }
                $data[":$name"] = $value;
            }
        }

        $sets = implode(', ', $sets);
        $sql = "UPDATE $table SET $sets, datetime_update=CURRENT_TIMESTAMP, `id` = LAST_INSERT_ID(`id`) WHERE id = :id";

        $status = $this->pdo->execute($sql, $data);

        return $status;
    }
}
