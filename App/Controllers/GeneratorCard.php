<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

class GeneratorCard extends Controller
{
    protected function handle()
    {
        $this->setMeta();
        $this->view->display('generator_card');
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
        return "Utilities";
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
        return "page_generator_card";
    }
}
