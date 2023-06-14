<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

use App\Models\Shortlink;

class L extends Controller
{
    public function access(): bool
    {
        return true;
    }

    protected function handle()
    {
        $Shortlink = new Shortlink;
        $short_url = basename($_SERVER['REQUEST_URI']);
        $this->view->shortlinks = $Shortlink->findOne($short_url, 'short_url');
        $original_url = ($this->view->shortlinks["original_url"]);

        $this->setMeta();
        redirect($original_url);
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
        return "page_l";
    }
}
