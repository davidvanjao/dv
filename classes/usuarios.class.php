<?php
class Usuarios {

    private $pdo;
    private $id;
    private $permissoes;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fazerLogin($usuario, $senha) {

        $sql = "SELECT * FROM tb_usuarios WHERE usuario = :usuario AND senha = :senha";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();

            $_SESSION['logado'] = $sql['id'];

            return true;
        }
        return false;
    }

    public function setUsuario($id) {
        $this->id = $id;

        $sql = "SELECT * FROM tb_usuarios WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $sql = $sql->fetch();
            $this->permissoes = explode(',', $sql['permissao']);
        }

    }

    public function getPermissoes() {
        return $this->permissoes;
    }

    public function temPermissao($p) {
        if(in_array($p, $this->permissoes)) {
            return true;
        } else {
            return false;
        }
    }

    
}


