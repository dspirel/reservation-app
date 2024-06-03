<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showLogin() 
    {   
        $this->render("login");
    }

    public function login() {
        $data = $_POST;
        //validation ????
        $user = $this->userModel->findByEmail($data["email"]);

        if (!$user || !password_verify($data["password"], $user["password"])) {
            $this->redirect("/login");
        }

        $_SESSION["user"] = $user["id"];
        $this->redirect("/");
    }

    public function logout() {
        session_destroy();
        $this->redirect("/login");
    }

    public function showRegister() 
    {   
        $this->render("register");
    }

    public function register() {
        $data = $_POST;
        $inputErrors = $this->validateRegisterInput($data);
        if (empty($inputErrors)) {
            $this->userModel->createUser($data);
            $this->redirect("/login");
        } else {
            $this->render("register", $inputErrors);
        }
    }

    private function validateRegisterInput($data){
        $inputErrors = [];
        extract($data);
        //check if email used
        if ($this->userModel->findByEmail($email)) $inputErrors["email"] = "Invalid email or already used";

        //email
        if (empty($email)) $inputErrors["email"] = "Invalid email or already used";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $inputErrors["email"] = "Invalid email or already used";
        //password
        if (strlen($password) < 6 || strlen($password) > 50) $inputErrors["password"] = "Invalid password";
        
        if (!empty($inputErrors)) return $inputErrors;
        // //username
        // if (empty($username)) $inputErrors["username"] = "Invalid username";
        // if (strlen($username) < 4 || strlen($username) > 50) $inputErrors["username"] = "Invalid username";
        // $username = htmlspecialchars($username);
        // if (!preg_match("/^[- '\p{L}]+$/u", $username)) $inputErrors["username"] = "Invalid username";
    }
}