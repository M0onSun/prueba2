<?php
class Role {
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

    /* Obtiene todos los roles de la base de datos */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM tbl_rol ORDER BY id_rol");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Busca un rol por su ID */
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbl_rol WHERE id_rol = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>