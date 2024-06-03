<?php

namespace App\Controllers;

abstract class Controller
{
    protected function render($view, array $data = []) 
    {   //if auth block from login,register
        if ($view == "register" || $view == "login") {
            if ($this->isAuth()) $this->redirect("/");
        }
        //if not auth redirect to login
        if ($view !== "register" && $view !== "login") {
            if (!$this->isAuth()) $this->redirect("/login");
        }
        //clear session var for editing reservation
        if ($view !== "edit-reservation") {
            if (isset($_SESSION["reservation_edit"])) unset($_SESSION["reservation_edit"]);
        }

        if (!empty($data)) extract($data);
        require_once APP_ROOT . "\app\Views\\$view.php";
    }

    protected function redirect($path, $param = "") {
        header("Location: " . URL_ROOT . "$path" . $param);
        exit;
    }

    protected function isAuth(): bool {
        return isset($_SESSION["user"]);
    }
}