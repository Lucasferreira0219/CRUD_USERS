<?php 

//Criando uma classe
class user {

    //definindo as variaveis da classe
    private $id = 0;
    private $name = null;
    Private $password = null; 

    //definindo as funcoes set e get
    public function setId(int $id) :void
    {
        $this->id = $id;
    }

    public function getId() :int
    {
        return $this->id;
    }

    public function setName(string $name) :void
    {
        $this->name = $name;
    }

    public function getName() :string
    {
        return $this->name;
    }

    public function setPassword(string $password) :void
    {
        $this->password = $password;
    }

    public function getPassword() :string
    {
        return $this->password;
    }

    //conexão com o banco de dados
    private function connection() :\PDO
    {
        return new \PDO("mysql:host=localhost;dbname=db_crud","root", "");
    }

    //Função para criar os registros
    public function create() :array
    {
        //mantem a conexão com o banco
        $con = $this->connection();
        //stmt é para evitar sql injection 
        $stmt = $con->prepare("INSERT INTO user VALUES (NULL,:_name, :_password)");
        //\PDO::PARAM_STR para aceitar só string
        $stmt->bindValue(":_name", $this->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":_password", $this->getPassword(), \PDO::PARAM_STR);
        //se a inclusão foi bem sucedida 
        if ($stmt->execute()){
            $this->setID($con->lastInsertId());
            return $this->read();
        }
        return[];
    }

    //funcao para ler o registro
    public function read() :array
    {
        //mantem a conexão com o banco
        $con = $this->connection();
        if ($this->getId() === 0){
            //stmt é para evitar sql injection 
            $stmt = $con->prepare("SELECT * FROM user");
            //se a leitura foi bem sucedida 
            if ($stmt->execute()){
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        } else if ($this->getId() > 0){
            $stmt = $con->prepare("SELECT * FROM user WHERE id = :_id");
            $stmt->bindValue(":_id", $this->getId(), \PDO::PARAM_INT);
            //se a leitura foi bem sucedida 
            if ($stmt->execute()){
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        return[];
    }

    public function update() :array
    {
        //mantem a conexão com o banco
        $con = $this->connection();
        //stmt é para evitar sql injection 
        $stmt = $con->prepare("UPDATE user SET name = :_name, password = :_password WHERE ID = :_id");
        //\PDO::PARAM_STR para aceitar só string
        $stmt->bindValue(":_name", $this->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":_password", $this->getPassword(), \PDO::PARAM_STR);
        $stmt->bindValue(":_id", $this->getId(), \PDO::PARAM_INT);
        //se a alteração foi bem sucedida 
        if ($stmt->execute()){
            return $this->read();
        }
        return[];
    }

    public function delete() :array
    {
        $user = $this->read();
        //mantem a conexão com o banco
        $con = $this->connection();
        //stmt é para evitar sql injection 
        $stmt = $con->prepare("DELETE FROM user WHERE id = :_id");
        //\PDO::PARAM_INT para aceitar só INT
        $stmt->bindValue(":_id", $this->getId(), \PDO::PARAM_INT);
        //se exclusão foi bem sucedida 
        if ($stmt->execute()){
            return $user;
        }
        return[];
    }


}