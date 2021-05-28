<?php
session_start();
$json = file_get_contents('php://input');
$data = json_decode($json);

$data = $data->roll;

if($data !== null) 
{
    include_once('dbh.inc.php');

    $roll = explode(" ", $data);
    
    $sql = "SELECT * FROM characters WHERE charactersId = ". $roll[1];
    $result = $conn->query($sql);
    $sheet = $result->fetch_assoc();

    $posRolls = array(
        "For" => "Força",
        "Dex" => "Destreza",
        "Con" => "Constituição",
        "Tam" => "Tamanho",
        "Pod" => "Vontade",
        "Car" => "Carisma",
        "Int" => "Inteligência",
        "Edu" => "Educação",
        "Sor" => "Sorte",
        "Exp" => "Exposição Paranormal"
    );

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if ($roll[0] == "Exp") 
    {
        $msg = 'EXP' . explode(' ', $sheet['name'])[0] . " : " . $posRolls[$roll[0]] . " " . RollExp($sheet["paranormalExposure"]) . ".";
    }
    else if (isset($posRolls[$roll[0]])) 
    {
        $msg = 'CHA' . explode(' ', $sheet['name'])[0] . " : " . $posRolls[$roll[0]] . " " . Roll($sheet["char" . $roll[0]]) . ".";
    }
    else
    {
        $msg = 'CHA' . explode(' ', $sheet['name'])[0] . " : " . substr($roll[0], 4) . " " . Roll($sheet[$roll[0]]) . ".";
    }

    $name = mysqli_real_escape_string($conn, $_SESSION['username']);
    $msg = mysqli_real_escape_string($conn, $msg);

    date_default_timezone_set('America/Sao_Paulo');
    $date = date('d-m-y h:i:sa');

    $sql = "INSERT INTO chat (chatUName, chatMsg, chatDt) VALUES ('$name', '$msg', '$date');";
    if(mysqli_query($conn, $sql))
    {
        ;
    } 
    else
    {
        echo "Erro: Mensagem não enviada!";
    }
}
else 
{
    header("location: ../login.php");
}