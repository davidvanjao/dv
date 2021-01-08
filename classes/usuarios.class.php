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
            $_SESSION['h_login'] = date('Y-m-d H:i:s', strtotime('-1 hour', strtotime(date('Y-m-d H:i:s'))));
            
            //inserir dados de acesso no log
            $this->logSessao($sql['id']);

            return true;
        }
        return false;
    }

    //usada para alimentar a tabela log_sessao.
    public function logSessao($usuario) {

        $sql = "INSERT INTO tb_log_sessao SET usuario = :usuario, data_login = NOW(), status = 'S'";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->execute();

        return true;
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


