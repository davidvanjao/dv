<?php
class Usuarios {

    private $pdo;
    private $id;
    private $permissoes;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    //verifica se o usuario existe no sistema
    public function fazerLogin($usuario, $senha) {

        $sql = "SELECT * FROM tb_usuarios WHERE usuario = :usuario AND senha = :senha";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();

            if($this->existeUsuario($sql['id'])) {

                if($this->verificarUsuarioOline($sql['id'])) {

                    $_SESSION['logado'] = $sql['id'];
                    $_SESSION['h_login'] = date('Y-m-d H:i:s', strtotime('-1 hour', strtotime(date('Y-m-d H:i:s'))));
                    
                    //inserir dados de acesso no log
                    $this->logSessao($sql['id']);


                } else {

                    return false;                    

                } 

            } else {

                $_SESSION['logado'] = $sql['id'];
                $_SESSION['h_login'] = date('Y-m-d H:i:s', strtotime('-1 hour', strtotime(date('Y-m-d H:i:s'))));
                $this->logSessao($sql['id']);
            }

            return true;

        } else {

            return false;

        }

        
    }

    //verificar se o usuario está online
    public function verificarUsuarioOline($usuario) {

        $sql = "SELECT * FROM tb_log_sessao WHERE usuario = :usuario ORDER BY data_login DESC LIMIT 1";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();

            if($sql['status'] == 'N') {

                return true;

            } else {

                echo "<script>alert('Já existe um usuário com esse login conectado!');</script>";
                
            }
        }
    }

    //existe usuario na tabela log_sessao
    public function existeUsuario($usuario) {

        $sql = "SELECT * FROM tb_log_sessao WHERE usuario = :usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->execute();

        if($sql->rowCount() > 0) {
            
            return true;
    
        } else {

            return false;
        }
    }


    //usada para alimentar a tabela log_sessao.
    public function logSessao($usuario) {

        $sql = "INSERT INTO tb_log_sessao SET usuario = :usuario, data_login = NOW(), status = 'S'";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->execute();

    }

    //usada para sair e alimentar a tabela log_sessao.
    public function logSessaoSair($usuario, $data_login) {

        $sql = "UPDATE tb_log_sessao SET data_exit = NOW(), status = 'N' WHERE usuario = :usuario AND data_login = :data_login";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":data_login", $data_login);
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


