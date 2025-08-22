<?php
class AuthController {
    private $userModel;

    public function __construct() {
        require_once APP_DIR . '/models/User.php';
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Busca un usuario en la base de datos según el correo usando el método findByEmail() del modelo.
            $user = $this->userModel->findByEmail($email);

            // Verificar si existe y si la contraseña coincide
            if ($user && password_verify($password, $user['contrasena'])) {

                $_SESSION['user'] = $user;

                Router::redirect('user/index');
                return;
            } else {
                $error = "Credenciales incorrectas";
            }
        }

        require_once APP_DIR . '/views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        Router::redirect('auth/login');
    }
}
