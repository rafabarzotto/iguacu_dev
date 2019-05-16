<?php

    function setUpdateTime(Pdo $pdo){

    try {

        $timestamp = date("d-m-Y H:i:s");

        $pdo->exec("set names utf8");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('UPDATE updateTime SET atualizacao = :atual WHERE id = 1;');
        $stmt->execute(array(
            ':atual' => $timestamp
        ));

        echo $stmt->rowCount();

        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

   function Inserir($itens, Pdo $pdo){
   //print_r(substr($itens[5],0,1));

    try {

        if(substr($itens[5],0,1) === ","):
	  $novoSaldo = substr($itens[5],1,1);
	else:
	  $novoSaldo = $itens[5];
	endif;

        $pdo->exec("set names utf8");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('INSERT INTO Estoque1 (id, Descricao, Tp, Est, Estoque, Saldo) VALUES (:id, :Descricao, :Tp, :Est, :Estoque, :Saldo) ON DUPLICATE KEY UPDATE Descricao = :Descricao, Saldo = :Saldo, Estoque = :Estoque;');
        $stmt->execute(array(
            ':id' => $itens[0],
	    ':Descricao' => $itens[1],
	    ':Tp' => $itens[2],
	    ':Est' => $itens[3],
	    ':Estoque' => $itens[4],
            ':Saldo' => $novoSaldo
        ));

        echo $stmt->rowCount();

        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    if (!empty($_FILES['arquivo']))
    {
	$Pdo = new PDO("mysql:host=localhost;dbname=iguacu", "opt", "qwe123");
        $file = fopen($_FILES['arquivo']['tmp_name'], 'r');
        while (!feof($file)){
            $linha = fgets($file);
	    if(preg_match('/^[0-9]+$/', trim(substr($linha, 62, 9)), $match)):
	       //print_r(substr($linha, 86,14));
               //$itens = array(trim(substr($linha, 62, 9)), trim(substr($linha, 86,14)), trim(substr($linha, 100,6)));
	       $itens = array(trim(substr($linha, 62, 9)), trim(substr($linha, 0,61)), trim(substr($linha, 74,2)), trim(substr($linha, 77,3)), trim(substr($linha, 100,6)), trim(substr($linha, 86,14)));
	       Inserir($itens, $Pdo);
	    endif;
        }
	setUpdateTime($Pdo);
    }
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel='stylesheet' href='w3.css'>
<title>Atualizar Estoque</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
        <h2>Atualizar Estoque</h2>
	<p>Favor selecionar o arquivo "igesinveo.txt" salvo pelo BPCS</p>
        <input type="hidden" name="<?php echo ini_get('session.upload_progress.name'); ?>" value="test" />
        <input type="file" name="arquivo" id="arquivo">
        <input type="submit" name="enviar" value="Enviar">
	<div class="w3-light-grey">
           <div id="progressBar" class="w3-container w3-green w3-center" style="width:0%"><!-- filled by JS--></div>
        </div>
    </form>
</body>
</html>

