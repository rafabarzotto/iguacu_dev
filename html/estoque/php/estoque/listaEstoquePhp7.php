<?php

    header('Access-Control-Allow-Origin: *');

    header('Access-Control-Allow-Methods: GET, POST');

    header("Access-Control-Allow-Headers: X-Requested-With");

    $start = $_REQUEST['start'];
    $limit = $_REQUEST['limit'];

    $desc = '';
    $cod = '';
    $extra = '';
    $op = '';
    $cls = '';

    if(isset($_REQUEST['desc']) && $_REQUEST['op'] == 'Todos'){
	$op = '>=';
    } else if (isset($_REQUEST['desc']) && $_REQUEST['op'] == 'Itens Com Saldo'){
	$op = '>';
    } else if (isset($_REQUEST['desc']) && $_REQUEST['op'] == 'Itens Sem Saldo'){
	$op = '=';
    }

    $searchSplit = '';
    $searchQueryItems = array();


    //$PDO = new PDO('mysql:host=192.168.4.1;dbname=iguacu', 'opt', 'qwe123');
    $PDO = new PDO('mysql:host=localhost;dbname=iguacu', 'opt', 'qwe123');
    $PDO->exec("set names utf8");

    if (isset($_REQUEST['desc']) && $_REQUEST['desc'] != '') {
        $desc = $_REQUEST['desc'];

	$searchSplit = explode(' ', $desc);
	  foreach ($searchSplit as $searchTerm) {
          /*
           * NOTE: Check out the DB connections escaping part 
           * below for the one you should use.
           */
            $searchQueryItems[] = "Descricao LIKE '%" . trim($PDO->quote($searchTerm), "'") . "%'";
          }
          $sql = "SELECT id, Descricao, Est, Cls, Estoque, Extra, Saldo FROM Estoque1" . (!empty($searchQueryItems) ? " WHERE " . implode(" AND ", $searchQueryItems) : "") . " AND Saldo $op 0 LIMIT $start, $limit";
          $sqlTotal = "SELECT count(*) as id FROM Estoque1" . (!empty($searchQueryItems) ? " WHERE " . implode(" AND ", $searchQueryItems) : "") . "AND Saldo $op 0";
    } else if (isset($_REQUEST['cod']) && $_REQUEST['cod'] != '') {
        $cod = $_REQUEST['cod'];
        $sql = "SELECT id, Descricao, Estoque, Est, Cls, Extra, Saldo FROM Estoque1 WHERE id = '$cod' LIMIT $start, $limit";
        $sqlTotal = "SELECT count(*) as id FROM Estoque1 WHERE id = '$cod'";
    } else if (isset($_REQUEST['extra']) && $_REQUEST['extra'] != '') {
        $extra = $_REQUEST['extra'];
        $sql = "SELECT id, Descricao, Est, Cls, Estoque, Extra, Saldo FROM Estoque1 WHERE Extra LIKE '%$extra%' LIMIT $start, $limit";
        $sqlTotal = "SELECT count(*) as id FROM Estoque1 WHERE id = '$cod'";
    } else if (isset($_REQUEST['cls']) && $_REQUEST['cls'] != '') {
	$cls = $_REQUEST['cls'];
	$sql = "SELECT id, Descricao, Est, Cls, Estoque, Extra, Saldo FROM Estoque1 WHERE Cls LIKE '$cls' ORDER BY Cls LIMIT $start, $limit";
        $sqlTotal = "SELECT count(*) as id FROM Estoque1 WHERE Cls LIKE '$cls'";
    } else {
        $sql = "SELECT id, Descricao, Estoque, Cls, Est, Extra, Saldo FROM Estoque1 LIMIT $start, $limit";
        $sqlTotal = "SELECT count(*) as id FROM Estoque1";
   }

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


