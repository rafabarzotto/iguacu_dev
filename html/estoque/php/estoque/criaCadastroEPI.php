<?php


    header('Access-Control-Allow-Origin: *');

    header('Access-Control-Allow-Methods: GET, POST');

    header('Access-Control-Allow-Headers: X-Requested-With');

    header('Access-Control-Allow-Headers: *');

    $info = $_POST['data'];
    $data = json_decode(stripslashes($info));
    $RE = $data->RE;
    $Colaborador = $data->Colaborador;
    $Cargo = $data->Cargo;
    $Setor = $data->Setor;
    $EPI = $data->EPI;
    $Data = $data->Data;
    $Responsavel = $data->Responsavel;

        $timestamp = date("d-m-Y H:i:s");

        $pdo = new PDO("mysql:host=localhost;dbname=iguacu", "opt", "qwe123");
        $pdo->exec("set names utf8");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('INSERT INTO ControleEPI (RE, Colaborador, Cargo, Setor, EPI, Data, Responsavel) VALUES :RE, :Colaborador, :Cargo, :Setor, :EPI, :Data, :Responsavel');

        $stmt->execute(array(
            ':RE' => $RE,
            ':Colaborador' => $Colaborador,
            ':Cargo' => $Cargo,
            ':Setor' => $Setor,
            ':EPI' => $EPI,
            ':Data' => $Data,
            ':Responsavel' => $Responsavel
        ));



?>

