<?php
class User {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
                DB_USER,
                DB_PASS
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    /* Busca un usuario por su email, tambien trae el rol relacionado*/
    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT u.*, r.rol
                                    FROM tbl_usuario u
                                    JOIN tbl_rol r ON u.id_rol = r.id_rol
                                    WHERE u.correo = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Igual que el anterior, pero busca por ID de usuario.
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT u.*, r.rol
                                    FROM tbl_usuario u
                                    JOIN tbl_rol r ON u.id_rol = r.id_rol
                                    WHERE u.id_usuario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Recupera todos los usuarios, con su respectivo rol.
    public function getAll() {
        $stmt = $this->pdo->query("SELECT u.*, r.rol FROM tbl_usuario u JOIN tbl_rol r ON u.id_rol = r.id_rol");
        return $stmt->fetchAll();
    }

    //Este método sirve para guardar datos de un usuario. Puede: actualizar y crear
    public function save($data, $id = null) {
        if ($id) {
            // Actualizar usuario existente
            $sql = "UPDATE tbl_usuario SET nombre=?, apaterno=?, amaterno=?, correo=?, id_rol=?";
            $params = [
                $data['nombres'],
                $data['apaterno'],
                $data['amaterno'] ?? null,
                $data['correo'],
                $data['id_rol']
            ];
            
            if (!empty($data['contrasena'])) {
                $sql .= ", contrasena=?";
                $params[] = password_hash($data['contrasena'], PASSWORD_BCRYPT);
            }

            $sql .= " WHERE id_usuario=?";
            $params[] = $id;
        } else {
            // Insertar nuevo usuario
            // AQUI ESTA LA CORRECCION: 'nombres' cambiado a 'nombre'
            $sql = "INSERT INTO tbl_usuario (nombre, apaterno, amaterno, correo, contrasena, id_rol) VALUES (?, ?, ?, ?, ?, ?)";
            $params = [
                $data['nombres'],
                $data['apaterno'],
                $data['amaterno'] ?? null,
                $data['correo'],
                password_hash($data['contrasena'], PASSWORD_BCRYPT),
                $data['id_rol']
            ];
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("ERROR EN SAVE(): " . $e->getMessage());
            return false;
        }
    }

    //Elimina un usuario por su ID.
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tbl_usuario WHERE id_usuario = ?");
        return $stmt->execute([$id]);
    }

    /* METODO PARA EXISTENCIA DE CORREOS */
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM tbl_usuario WHERE correo = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id_usuario != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
?>