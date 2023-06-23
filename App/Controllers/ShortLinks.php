<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

use App\Models\Shortlink;
use App\Models\ShortlinkCategory;
use App\Models\User;

class Shortlinks extends Controller
{
    public function access(): bool
    {
        if (!isShield()) {
            redirect('/NotFound');
            die;
        }

        if (!isLogin()) {
            $_SESSION['error'] = "Зарегистрируйтесь, чтобы добавлять статьи!";
            redirect('/login');
            die;
        }

        return true;
    }

    protected function handle()
    {
        if (isset($_POST['add'])) {
            $this->add(
                $_POST['title'],
                $_POST['url'],
                $_POST['category_id'],
                $_POST['shortcode']
            );
            die;
        }
        if (isset($_POST['check'])) {
            $this->check(
                $_POST['check']
            );
            die;
        }
        if (isset($_POST['add-category'])) {
            $this->addCategory(
                $_POST['name']
            );
            die;
        }

        $Shortlink = new Shortlink;
        $User = new User;
        $ShortlinkCategory = new ShortlinkCategory;
        $username = $_SESSION['user']["username"];
        $this->view->user_profile = $User->findAllBy("username", $username)[0];
        $user_id = $this->view->user_profile["id"];
        $this->view->shortlinks = $Shortlink->findAllByAuthor($user_id, 'user_id');
        $this->view->shortlink_categories = parseCategories(
            $ShortlinkCategory->findAllBy('user_id', $user_id)
        );

        $this->setMeta();
        $this->view->display('short_link');
    }

    protected function check($short_url)
    {
        $check = $this->checkShortLink($short_url);
        $message = array("status" => "success", "data" => $check);
        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    private function checkShortLink($short_url)
    {
        $Shortlink = new Shortlink();
        return $Shortlink->countBy("short_url", $short_url);
    }

    private function checkCategory($name)
    {
        $ShortlinkCategory = new ShortlinkCategory();
        return $ShortlinkCategory->countBy("name", $name);
    }

    protected function addCategory($name)
    {
        if ($this->checkCategory($name) != 0) {
            $errors = array("status" => "error", "text" => "Категория уже существует");
            echo json_encode($errors, JSON_UNESCAPED_UNICODE);
            die;
        }

        $ShortlinkCategory = new ShortlinkCategory();
        $data = array();
        $data["name"] = $name;

        $ShortlinkCategory->load($data);

        if (!$ShortlinkCategory->validate($data)) {
            $errors = array("status" => "error", "text" => $ShortlinkCategory->getErrorsValidate());
            echo json_encode($errors, JSON_UNESCAPED_UNICODE);
            die;
        }

        $ShortlinkCategory->attributes['user_id'] = $_SESSION['user']["id"];
        $id = $ShortlinkCategory->save();

        if ($id) {
            $text = "Категория '$name' создана";
            $message = array("status" => "success", "text" => $text);
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
        } else {
            $errors = array("status" => "error", "text" => "Ошибка! Попробуйте позже");
            echo json_encode($errors, JSON_UNESCAPED_UNICODE);
        }
    }

    protected function add($title, $original_url, $category_id, $short_url)
    {
        if ($this->checkShortLink($short_url) != 0) {
            $errors = array("status" => "error", "text" => "Введенный короткий адрес уже существует. Придумайте другой");
            echo json_encode($errors, JSON_UNESCAPED_UNICODE);
            die;
        }

        $Shortlink = new Shortlink();
        $data = array();
        $data["title"] = $title;
        $data["category_id"] = $category_id;
        $data["original_url"] = $original_url;
        $short_url = $this->getShortCode($short_url);
        $data["short_url"] = $short_url;

        $Shortlink->load($data);

        if (!$Shortlink->validate($data)) {
            $errors = array("status" => "error", "text" => $Shortlink->getErrorsValidate());
            echo json_encode($errors, JSON_UNESCAPED_UNICODE);
            die;
        }

        $Shortlink->attributes['user_id'] = $_SESSION['user']["id"];
        $id = $Shortlink->save();

        if ($id) {
            $url = getUrl() . "/l/$short_url";
            $data = array("id" => $id, "url" => $url);
            $message = array("status" => "success", "data" => $data);
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
        } else {
            $errors = array("status" => "error", "text" => "Ошибка! Попробуйте позже");
            echo json_encode($errors, JSON_UNESCAPED_UNICODE);
        }
    }

    private function getShortCode($shortCode)
    {
        if ($shortCode === '') {
            $shortCode = randomCode(8);
        }
        return $shortCode;
    }

    protected function setMeta()
    {
        $this->meta->name_page = $this->name_page();
        $this->meta->title = $this->title();
        $this->meta->description = $this->description();
        $this->meta->keywords = $this->keywords();
        $this->meta->author = $this->author();
        $this->meta->image = '/img/static/category_code.jpg';
        $this->view->meta = $this->meta;
    }

    protected function title()
    {
        return "Создать короткую ссылку";
    }

    protected function description()
    {
        return "Indyground - сайт о создателях игр, музыки, графики и всего осталнього творчества";
    }

    protected function keywords()
    {
        return "Indyground, инди, RPG maker";
    }

    protected function author()
    {
        return "Yuryol";
    }

    protected function name_page()
    {
        return "page_short_link";
    }
}
