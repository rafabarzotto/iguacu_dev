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
		$sql = "SELECT EQUIPAM.EQUI_CODIG, EQUIPAM.EQUI_DESCR, EQUIPAM.MAQ_CODIGO, MAQUINA.MAQ_DESCRI, EQUIPAM.TAG_CODIGO, TAG.TAG_DESCRI FROM EQUIPAM, MAQUINA, TAG WHERE LOWER (EQUIPAM.EQUI_DESCR) LIKE '%$busca%' AND EQUIPAM.MAQ_CODIGO = MAQUINA.MAQ_CODIGO AND EQUIPAM.TAG_CODIGO = TAG.TAG_CODIGO";
		$sqlTotal = "SELECT count(*) FROM EQUIPAM, MAQUINA, TAG WHERE LOWER (EQUIPAM.EQUI_DESCR) LIKE '%$busca%' AND EQUIPAM.MAQ_CODIGO = MAQUINA.MAQ_CODIGO AND EQUIPAM.TAG_CODIGO = TAG.TAG_CODIGO";
	} else {
		$sql = "SELECT OSCONCLU.OS_CODIGO, OSCONCLU.OS_DESCRIC, OSCONCLU.OS_SOLICIT, OSCONCLU.OS_DATAEMI, OSCONCLU.OS_DATAABE, OSCONCLU.OS_DATAEQU, OSCONCLU.EQUI_CODIG, OSCONCLU.CC_CODIGO, OSCONCLU.AREA_CODIG, OSCONCLU.TAG_CODIGO, OSCONCLU.MAQ_CODIGO, OSCONCLU.FUNCIONARIO FROM OSCONCLU ORDER BY OS_DATAEQU DESC";
		$sqlTotal = "SELECT count(*) FROM OSCONCLU";
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
