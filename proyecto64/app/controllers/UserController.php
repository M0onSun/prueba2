<?php
class UserController {
    private $userModel;
    private $roleModel;

    public function __construct() {
        require_once APP_DIR . '/models/User.php';
        require_once APP_DIR . '/models/Role.php';
        $this->userModel = new User();
        $this->roleModel = new Role();

        $this->checkAuth(); //verifica que el usuario haya iniciado sesion
    }

    private function checkAuth() { 
        if (!isset($_SESSION['user'])) {  //si no hay una sesion activa, redirige al login
            Router::redirect('auth/login');
            exit;
        }
    }

    public function index() {
        $users = $this->userModel->getAll(); //obtiene todos los usuarios y los carga a la vista index
        require_once APP_DIR . '/views/users/index.php';
    }

    //Carga la vista para crear un nuevo usuario y envía la lista de roles.
    public function create() {
        $roles = $this->roleModel->getAll();
        require_once APP_DIR . '/views/users/create.php';
    }

    // Solo permite peticiones POST. Si es otro método, da error y redirige.
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Método no permitido';
            Router::redirect('users/create');
            return;
        }

        //Limpia y valida los datos del formulario.
        try {
            $data = $this->sanitizeInput($_POST);
            $error = $this->validateUserData($data);

            //Si hay errores, los guarda en $_SESSION y redirige para mostrarlos en la vista.
            if ($error) {
                $_SESSION['error'] = $error;
                $_SESSION['old_input'] = $data;
                Router::redirect('users/create');
                return;
            }

            //Si no se puede guardar, lanza una excepción.
            if (!$this->userModel->save($data)) {
                throw new Exception('Error al guardar en base de datos');
            }

            //Si todo va bien, muestra mensaje de éxito.
            $_SESSION['success'] = 'Usuario registrado correctamente';
            Router::redirect('users/index');
       
            //Captura cualquier error inesperado y redirige con mensaje.
        } catch (Exception $e) {
            error_log('EXCEPCION: '. $e->getMessage());
            $_SESSION['error'] = 'Error interno del servidor';
            Router::redirect('users/create');
        }
    }

    private function sanitizeInput($input) {
        $correo = trim($input['correo']);
        $correoValidado = filter_var($correo, FILTER_VALIDATE_EMAIL);

        return [
            'nombres' => trim($input['nombres']),
            'apaterno' => trim($input['apaterno']),
            'amaterno' => trim($input['amaterno']),
            'correo' => $correoValidado ? $correoValidado : $correo,
            'contrasena' => $input['contrasena'], 
            'contrasena_confirm' => $input['contrasena_confirm'] ?? '',
            'id_rol' => (int)$input['id_rol']
        ];
    }

    private function validateUserData($data) {
        if (empty($data['nombres']) || empty($data['apaterno']) || empty($data['correo'])) {
            return 'Todos los campos requeridos deben estar completos';
        }

        if ($data['contrasena'] !== $data['contrasena_confirm']) {
            return 'Las contraseñas no coinciden';
        }

        if ($this->userModel->emailExists($data['correo'])) {
            return 'El correo electrónico ya está registrado';
        }

        if (!$this->validarContrasena($data['contrasena'])) {
            return 'La contraseña debe tener al menos 8 caracteres, incluyendo mayúsculas, minúsculas, números y caracteres especiales';
        }

        return null;
    }

    private function validarContrasena($password) {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);

    }

    public function edit($id) {
        $user = $this->userModel->findById($id);
        $roles = $this->roleModel->getAll();
        require_once APP_DIR . '/views/users/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = $this->sanitizeInput($_POST);

                // Validación básica para update
                if (empty($data['nombres']) || empty($data['apaterno']) || empty($data['correo'])) { 
                    $_SESSION['error'] = 'Todos los campos requeridos deben estar completos';
                    Router::redirect('user/edit/'.$id);
                    return;
                }

                if ($this->userModel->emailExists($data['correo'], $id)) {
                    $_SESSION['error'] = 'El correo electrónico ya está registrado';
                    Router::redirect('user/edit/'.$id);
                    return;
                }

                if ($this->userModel->save($data, $id)) {
                    $_SESSION['success'] = 'Usuario actualizado correctamente';
                    Router::redirect('user/index');
                }
            } catch (Exception $e) {
                error_log('EXCEPCION: '. $e->getMessage());
                $_SESSION['error'] = 'Error al actualizar el usuario';
                Router::redirect('user/edit/'.$id);
            }
        }
    }

    public function delete($id) {
        try {
            $this->userModel->delete($id);
            $_SESSION['success'] = 'Usuario eliminado correctamente';
        } catch (Exception $e) {
            error_log('EXCEPCION: '. $e->getMessage());
            $_SESSION['error'] = 'Error al eliminar el usuario';
        }
        Router::redirect('user/index');
    }
}