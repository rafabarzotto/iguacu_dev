<?php

    header('Access-Control-Allow-Origin: *');

    header('Access-Control-Allow-Methods: GET, POST');

    header('Access-Control-Allow-Headers: X-Requested-With');

    //$PDO = new PDO('mysql:host=192.168.4.1;dbname=iguacu', 'opt', 'qwe123');
    $PDO = new PDO('mysql:host=localhost;dbname=iguacu', 'opt', 'qwe123');
    $PDO->exec("set names utf8");

    $sql = "SELECT id_colab, RE, Colaborador, Cargo, Setor FROM colaboradores";
    $sqlTotal = "SELECT count(*) as id_colab FROM colaboradores";
   

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
