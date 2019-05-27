<?php

    header('Access-Control-Allow-Origin: *');

    header('Access-Control-Allow-Methods: GET, POST');

    header("Access-Control-Allow-Headers: X-Requested-With");

    $page  = $_REQUEST['page'];
    $start = $_REQUEST['start'];
    $limit = $_REQUEST['limit'];

    //$PDO = new PDO('mysql:host=192.168.4.1;dbname=iguacu', 'opt', 'qwe123');
    $PDO = new PDO('mysql:host=localhost;dbname=iguacu', 'opt', 'qwe123');
    $PDO->exec("set names utf8");

    $sql = "SELECT ID, RE, Colaborador, Cargo, Setor, EPI, Data, Responsavel, stamp FROM ControleEPI LIMIT $start, $limit";
    $sqlTotal = "SELECT count(*) as ID FROM ControleEPI";
   

	$result = $PDO->query($sql);
	$datas = $result->fetchAll(PDO::FETCH_ASSOC);

	$resultTotal = $PDO->prepare($sqlTotal);
	$resultTotal->execute();
	$total = $resultTotal->fetchColumn();

	$status = array(
		"success" => "success",
		"total" => $total,
		"data" => $datas
	);
	
	echo json_encode($status, JSON_UNESCAPED_UNICODE);

?>


