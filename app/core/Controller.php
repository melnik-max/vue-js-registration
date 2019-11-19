<?php


namespace core;


abstract class Controller
{
    public $layout = 'index';

    public function render($filename, array $data = null)
    {
        ob_start();

        if ($data) {
            extract($data);
        }

        require ($_SERVER['DOCUMENT_ROOT'] . '/views/' . $filename . '.php');
        $content = ob_get_clean();

        if ($this->layout == false) {
            echo $content;
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . '/views/' . $this->layout . '.php');
        }

        return true;
    }
}