<?php


namespace core;


abstract class Controller
{
    public $layout = 'main';

    public function render($filename, array $data = null)
    {
        ob_start();

        if ($data) {
            extract($data);
        }

        require (ROOT . '/views/' . $filename . '.php');
        $content = ob_get_clean();

        if ($this->layout == false) {
            echo $content;
        } else {
            require(ROOT . '/views/' . $this->layout . '.php');
        }

        return true;
    }
}