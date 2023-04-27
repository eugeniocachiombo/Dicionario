<?php
	
	include 'conexao.php';

	$con = getConexao();

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>

	<meta charset="utf-8">
	<title>Dicionario</title>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>

	<fieldset>
		<legend>Pesquisar Palavras</legend>

		<form method="POST" autocomplete="off">
			<input list="datalist" type="text" id="Pesq_palavra" name="Pesq_palavra" placeholder="Digite uma letra ou palavra">
			<input id="btnPesquisar" type="submit" name="Pesq" value="P">
			
			<!--DATA LIST -->
			<?php $select = "select palavra from vocabulario limit 5";

			$stmt = $con->prepare($select);
			$stmt->execute();
			$result = $stmt->fetchAll();
			?>


			<datalist id="datalist">

			<?php   foreach ($result as $value) { ?>

			<option value="<?php  echo $value['palavra'] ?>">

			<?php } ?>

			</datalist>
			<!--DATA LIST -->
		
		</form>

	</fieldset>

	
	<fieldset>
		<legend>Cadastrar Palavras</legend>

		<form method="POST" autocomplete="off">
			<label>Palavra</label><br>
			<input type="text" id="palavra" name="palavra" placeholder="Digite a letra ou Palavra" > <br><br>

			<label>Significado</label><br>
			
			<textarea id="significado" name="significado" rows="0" placeholder="Digite o significado" ></textarea><br><br>
			<input id="cadastrar" type="submit" name="cadastrar" value="Cadastrar" >
		</form>

	</fieldset>

	
<script>
	btnPesquisar = document.querySelector("#btnPesquisar");
	Pesq_palavra = document.querySelector("#Pesq_palavra");
	
	btnPesquisar.style = "border-radius: 9px;border: 3px solid red;padding-left: 5px;color:white";
	btnPesquisar.disabled = true;
	Pesq_palavra.style="width: 20px";
	datalist = document.querySelector("#datalist");
    datalist.id = "";
	

	Pesq_palavra.addEventListener('click', ()=>{

		Pesq_palavra.style="width: auto";

		});


	Pesq_palavra.addEventListener('keyup', ()=>{

		if(Pesq_palavra.value != ""){
		Pesq_palavra.style="width: 160px";
		btnPesquisar.style = "border-radius: 9px; background-color: red;border: 3px solid red; color: white;cursor:pointer";
		btnPesquisar.disabled = false;
		datalist.id = "datalist";
		
	}else{
		btnPesquisar.style = "border-radius: 9px;border: 3px solid red;padding-left: 5px;color:white";
		//Pesq_palavra.style="width: 20px";
		btnPesquisar.disabled = true;
		datalist.id = "";
	}

	});

	Pesq_palavra.addEventListener('mouseout', ()=>{
		if(Pesq_palavra.value == ""){
		btnPesquisar.style = "border-radius: 9px;border: 3px solid red;padding-left: 5px;color:white";
		Pesq_palavra.style="width: 20px";
		btnPesquisar.disabled = true;
		datalist.id = "";
		}
	});
	
</script>


<?php
	
	if (isset($_POST["cadastrar"])) {

		$palavra = $_POST["palavra"];
		$significado = $_POST["significado"];

		if ($palavra != "" && $significado != "") {
		
		
		$conteudo = 
		"<!DOCTYPE HTML>
		<html lang='pt-br'>
		<head>
		<link rel='stylesheet' href='../estilo.css'>
		<meta charset='utf-8'>
		<title> Palavra: ".$_POST['palavra']."</title>
		<style>
			a{
				color: orange;
			}

			a:hover{
				background: orange;
				color: white;
				font-weigth: bold;
				padding-left: 10px;  
				padding-right: 10px;
				border-radius: 9px;
			}
		</style>
		</head>


		<body>"
		."<fieldset>"
		."<legend> Palavra: "	.$_POST['palavra']."</legend>"
		."<?php ?>"
		."<dl>"
		."<dt>"
		."<label style='color: orange;'> <?php echo '".$_POST['palavra']."'?></label>"."<br>"
		."<dt>"
		.""
		."<?php echo '".$_POST['significado']."'?>"
		."<dd> </dl>"
		.""
		."<br> <a href='../Index.php'>Voltar</a>"
		."<?php ?>"
		."<fieldset>
		</body>
		</html>";

		$fp = fopen("Vocabulários/".$_POST["palavra"].".php","wb");

		
		$sql = "insert into vocabulario (palavra, significado) values(?, ?)";

		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $palavra);
		$stmt->bindValue(2, $significado);
		

		if ($stmt->execute()) {

			fwrite($fp, $conteudo);
			echo "<p id='mss' align='Center' style='background: blue'>" ;
			
			//echo "Palavra cadastrada com Sucesso";
			echo "</p>";

			?>
			<script>
			
			mss = document.querySelector("#mss");
			mss.innerText = "Palavra cadastrada com Sucesso";

			setInterval(() => {
				mss.innerText = "";
			}, 2000);

			

			</script>
			<?php
		} else{
			echo "Erro ao executar";
		}

	} else{
		echo "Existe campo vazio";
	} 
} 

		if (isset($_POST["Pesq"])) {
	
	$Pesq_palavra = $_POST["Pesq_palavra"];

	$select = "select * from vocabulario where palavra = ?";

		$stmt = $con->prepare($select);
		$stmt->bindValue(1, $Pesq_palavra);
		$stmt->execute();
		$result = $stmt->fetchAll();

		$a = 0;

		

		foreach ($result as $value) { $a++;


			?>

				<dl style="text-align: center">
				<hr>
				<dt>
		<a href="Vocabulários/<?php echo $value["palavra"] ?>.php" style="color: orange; font-weight: bold;">	<?php	echo $value["palavra"];	 ?> </a>
				</dt>

				<dd>
			<?php 	echo  $value["significado"];	 ?>		
				</dd>
				<hr>
			</dl>

		<?php
		} 

		if ($a == 0) {

		echo "<p align='Center' style='background: blue;color: white'>" ;
		echo "Palavra não encontrada";
		echo "</p>";
		}

	}


?>
</body>
</html>

