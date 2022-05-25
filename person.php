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
    private function connection() : \PDO
    {
        return new \PDO("mysql:host=localhost;dbname=db_crud","root", "")
    }

    //Função para criar os registros
    private function create() :array
    {
        //mantem a conexão com o banco
        $con = $this->connection();
        //stmt é para evitar sql injection 
        $stmt = $con->prepare("INSERT INTO user VALUES (NULL,:_name, :_password)");
        //\PDO::PARAM_STR para aceitar só string
        $stmt->bindValue(":_name" $this->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":_password" $this->getPassword(), \PDO::PARAM_STR);
    }

}