<?php

	header('Access-Control-Allow-Origin: *');

        header('Access-Control-Allow-Methods: GET, POST');

	header('Access-Control-Allow-Headers: X-Requested-With');

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	$page  = $_REQUEST['page'];

	$searchSplit = '';
    $searchQueryItems = array();

	//conectamos ao banco de dados
	$PDO = new PDO('firebird:dbname=192.168.4.5:C:\Sigma_Banco\NOVO_SIGMAPDCA_IGUACU_PRD.FDB;charset=utf8', 'SYSDBA', 'masterkey');
	$PDO->exec("set names utf8");

	if(isset($_REQUEST['query'])){
	   $busca = $_REQUEST['query'];
	   $searchSplit = explode(' ', $busca);
	  	foreach ($searchSplit as $searchTerm) {
          /*
           * NOTE: Check out the DB connections escaping part 
           * below for the one you should use.
           */
            $searchQueryItems[] = "EQUIPAM.EQUI_DESCR LIKE '%" . trim($PDO->quote($searchTerm), "'") . "%'";
          }
		$sql = "";
		$sqlTotal = "";
	} else {
		$sql = "SELECT OS.OS_CODIGO, OS.OS_DESCRIC, OS.OS_SOLICIT, OS.OS_DATAEMI, OS.OS_DATAABE, OS.OS_DATAEQU, OS.EQUI_CODIG, OS.CC_CODIGO, OS.AREA_CODIG, OS.TAG_CODIGO, OS.MAQ_CODIGO, OS.FUNCIONARIO FROM OS ORDER BY OS_DATAEQU DESC";
		$sqlTotal = "SELECT count(*) FROM OS";
	}

	//montamos e rodamos a query
	$result = $PDO->query($sql);

	//retornamos todos os registros (fetchAll) em forma de uma lista de Objetos (FECH_OBJ)
	$datas = $result->fetchAll(PDO::FETCH_ASSOC);

	$resultTotal = $PDO->query($sqlTotal);
	$total = $resultTotal->fetchColumn();

	$status = array(
		"success" => "success",
		"total" => $total,
		"data" => $datas
	);

	echo json_encode($status, JSON_UNESCAPED_UNICODE);
?>
