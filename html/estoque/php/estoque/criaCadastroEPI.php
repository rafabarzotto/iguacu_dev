<?php


    header('Access-Control-Allow-Origin: *');

    header('Access-Control-Allow-Methods: GET, POST');

    header('Access-Control-Allow-Headers: X-Requested-With');

    header('Access-Control-Allow-Headers: *');

    $info = $_POST['data'];
    $json = json_decode($info, JSON_UNESCAPED_UNICODE);
    $RE = $json->RE;
    $Colaborador = $json->Colaborador;
    $Cargo = $json->Cargo;
    $Setor = $json->Setor;
    $EPI = $json->EPI;
    $Data = $json->Data;
    $Responsavel = $json->Responsavel;

        $timestamp = date("d-m-Y H:i:s");

        $pdo = new PDO("mysql:host=localhost;dbname=iguacu", "opt", "qwe123");
        $pdo->exec("set names utf8");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('INSERT INTO ControleEPI (RE, Colaborador, Cargo, Setor, EPI, Data, Responsavel, stamp) VALUES :RE, :Colaborador, :Cargo, :Setor, :EPI, :Data, :Responsavel', ':stamp');

        $stmt->execute(array(
            ':RE' => $RE,
            ':Colaborador' => $Colaborador,
            ':Cargo' => $Cargo,
            ':Setor' => $Setor,
            ':EPI' => $EPI,
            ':Data' => $Data,
            ':Responsavel' => $Responsavel,
            ':stamp' => $timestamp
        ));



?>

