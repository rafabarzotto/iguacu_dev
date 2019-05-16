<?php

    header('Access-Control-Allow-Origin: *');

    header('Access-Control-Allow-Methods: GET, POST');

    header("Access-Control-Allow-Headers: X-Requested-With");

    //$start = $_REQUEST['start'];
    //$limit = $_REQUEST['limit'];

    $PDO = new PDO('mysql:host=localhost;dbname=iguacu', 'opt', 'qwe123');
    $PDO->exec("set names utf8");

        $sql = "SELECT Estoque1.Cls, Classes.descricao FROM Estoque1, Classes WHERE Estoque1.Cls = Classes.id GROUP BY Estoque1.Cls";
        
	$result = $PDO->query($sql);
	$datas = $result->fetchAll(PDO::FETCH_ASSOC);

	$status = array(
		"success" => "success",
		"data" => $datas
	);

	echo json_encode($status, JSON_UNESCAPED_UNICODE);

?>


