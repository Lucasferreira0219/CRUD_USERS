
<?php

//Puxa outros arquivos do projeto
require_once "user.php";

//Codigo de resposta para quem requisiyou a api
header('X-PHP-Response-Code: 404', true, 404);


//recebe um arquivo json
$json_convertido = json_decode(file_get_contents('php://input'), true);
//recebe o parametro da url
$fn = $_REQUEST["fn"] ?? null;
$data = [];
//cria um novo objeto
$user = new user;
//passa os parametros do json para as variaveis 
$name = $json_convertido["user"][0]["name"];
$password = $json_convertido["user"][0]["password"];
//verifica se o id foi preenchido
if ($json_convertido["user"][0]["id"] == null){
    $id = 0;
} else {
    $id = $json_convertido["user"][0]["id"];
}
//puxa as informações do id
$user->setId($id);

//Executa o crud pelo parametro que foi passado pela URL
switch ($fn) {
    case "create":
        
        if ($name !== null && $password !== null){
            $user->setName($name);
            $user->setPassword(($password));
            $data["user"] = $user->create();
            $data["sucess"] = true;
        }

      break;

    case "update":

      if ($id > 0 && $name !== null && $password !== null){
            $user->setName($name);
            $user->setPassword(($password));
            $data["user"] = $user->update();
            $data["sucess"] = true;
        }

      break;

    case "delete":

        if ($id > 0 ){
            $data["user"] = $user->delete();
        }

        break;

    case "read":
        $data["sucess"] = true;
        $data["user"] = $user->read();
        $data["sucess"] = true;

      break;

    default:

        $data["info"] = "default";
        die(json_encode($data));
}

//retorna um json pra quem chamou a API
die(json_encode($data));
