<?php
error_reporting(0);
include 'config.php';
?>

<html>
<head>
	    

<title>Dokumendid</title>
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
<div style="position:relative; left: 50">


<form method="get" action="">


	<!-- Первый поиск по значению Nimetus, выпадает из самого столбца Nimetus из таблицы -->
	<br>
	<br>
	<div>
	<label>Nimetus</label>
	<select name="Nimetus" list="Nimetus" required>
	<datalist id="Nimetus">
    	<option>
 	<?php
		$query = mysqli_query($connection, "SELECT DISTINCT Nimetus FROM dokumendid");
		$numrows = mysqli_num_rows($query);
		while ($row = mysqli_fetch_array($query)) {
	echo '<option>'.$row['Nimetus'].'</option>';
	}
	?>
	</select>
	</datalist> 
		</option>
	</div>
<!--- второй поиск по значению Liikumine, возможные варианты выбора здесь в коде--->
<div>
<label>Liikumine</label>
<input name="Liikumine" list="Liikumine" required />
<datalist id="Liikumine">
	<option value=" " />
    <option value="Sisene" />
    <option value="Väljaminev" />
    <option value="Sissetulev" />
    
</datalist>
</div>

<!--- третий поиск по значению Sari, возможные варианты выбора в коде--->
<div>
<label>Sari</label>
<input name="Sari" list="Sari" required />
<datalist id="Sari">
	<option value=" " />
    <option value="01 Põhitegevus" />
    <option value="02 Õppetöö" />
    <option value="03 Personalitöö" />
    <option value="04 Majandustegevus" />
    <option value="05 Asjaajamine" />
    
</datalist>
</div>

	<br>
	<input class="btn btn-primary" type="submit" value="Otsi dokument">
	
	<br>
	<br>

</form>

<div>
<form method="post" action="">
<a href="dokumendid_bootstrap.php" class="btn btn-primary">Tagasi dokumentide juurde</a>
</form>


</div>

<!-- Добавление doc- файла к документу, файл добавляется в папку mus_doc_files. --->
<br>
<?php echo "Lisage doc_fail dokumendi juurde: " ?>
<br>
<br>

<form action="dok_faillisamine.php" method="post" enctype="multipart/form-data">
	<label for="file">Valige fail:</label>
	<input  value="Vali fail"  type="file" name="userfile" >
	<input type="submit" name="submit" value="Salvesta fail">
<br>
<br>

<div>
<label>Dokumendi ID</label>
<select name="Dokument" list="Dokument" required>
<datalist id="Dokument">
    <option>
 <?php
    $query = mysqli_query($connection, "SELECT * FROM dokumendid ORDER BY id DESC");
    $numrows = mysqli_num_rows($query);
    while ($row = mysqli_fetch_array($query)) {
echo '<option>'.$row['id'].'</option>';
}
?>
</select>
</datalist> 
    </option>
</div>

</form>


<p><a href="/praktika/mus_doc_files/">Dokumendid</a></p>
<br>

</div>
</body>

<div style="position: fixed; bottom: 0; right: 0">

<form method="get" action="esi.html">
    

    <input class="" type="submit" value="Esilehekülg">

</form>
</div>

<!---------------------------------------------------------------------------- -->
<?php

if ($_SERVER['REQUEST_METHOD']=='GET'){
if (!empty($_GET['Nimetus']) && ($_GET['Liikumine']) && ($_GET['Sari']) ){

$Nimetus = htmlspecialchars(trim($_GET['Nimetus']));
$Liikumine = htmlspecialchars(trim($_GET['Liikumine']));
$Sari = htmlspecialchars(trim($_GET['Sari']));

;
}


	// указываем какие значения поиска откуда брать (создаём массив) и после достаём значения с таблицы

	$fields=['Nimetus'=>'Nimetus'];
	$field='Nimetus';
	$fields1=['Liikumine'=>'Liikumine'];
	$field1='Liikumine';
	$fields2=['Sari'=>'Sari'];
	$field2='Sari';


	if(array_key_exists($_GET['Nimetus'],$fields))  {
		$field=$fields[$_GET['Nimetus']];
		

		if(array_key_exists($_GET['Liikumine'],$fields1))
			$field1=$fields1[$_GET['Liikumine']];

			
	
			if(array_key_exists($_GET['Sari'],$fields2)) 
				$field2=$fields2[$_GET['Sari']];
		
	}
	}
	// указываем какие значения поиска откуда брать и после достаём значения с таблицы

	$query = "SELECT * FROM dokumendid WHERE {$field} LIKE '%{$Nimetus}%' AND {$field1} LIKE '%{$Liikumine}%' AND {$field2} LIKE '%{$Sari}%' ORDER BY id DESC";

	$output=mysqli_query($connection, $query); 
	$results=mysqli_num_rows($output);
	 	///if ($query==NULL)
	
		//удаление
	if(!empty($_GET['id'])){

	//удаляем запрос
	$id = $_GET['id'];
	$delete_sql = "DELETE FROM Dokumendid WHERE id='$id'";
	$delete_value = mysqli_query($connection, $delete_sql);
	if($delete_value){
	echo "Rida kustutatud!";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$_SERVER['PHP_SELF'].'">';
	} else {
	echo "Viga kustutamisel!";
	}
	}

	// вывод значений на экран, причем их тут больше, чем указанно в поиске

	while ($line=mysqli_fetch_array($output)) {
		/**echo '<strong>' , "ID=:  " , '</strong>', $line['id'].'  |  ', ' | ', '<strong>' , "Nimetus:  " , '</strong>', $line['Nimetus'].'  |  ', ' | ' , '<strong>' , "Sari:  " , '</strong>' .$line['Sari'].'  |  ' ,'<strong>' , "Liikumine:  " , '</strong>' .$line['Liikumine'].'  |  ' , '<strong>' , "Registreerimisnumber:  " , '</strong>' .$line['Registreerimisnumber'].'  |  ' , '<strong>' , "Kuupäev:  " , '</strong>' .$line['Kuupäev']. ' <br> ';
		echo '<br>'; */


		echo "<strong> <table border='1'> </strong>
<tr><td align='center', width='100'> <strong> ID </strong> </td><td align='center', width='200'> <strong> Nimetus </strong> </td><td align='center', width='200'> <strong> Sari </strong> </td><td align='center', width='200'> <strong> Liikumine </strong> </td><td align='center', width='200'> <strong> Registreerimisnumber </strong> </td><td align='center', width='200'> <strong> Kuupäev </strong> </td><td align='center', width='300'> dokumendi muutmine </td>  </tr> 

<tr><td align='center'>$line[id]</td><td align='center'>$line[Nimetus]</td><td align='center'>$line[Sari]</td><td align='center'>$line[Liikumine]</td><td align='center'>$line[Registreerimisnumber]</td><td align='center'>$line[Kuupäev]</td><td align='center'><button><a href=".$_SERVER['PHP_SELF'].'?id='.$line["id"].">kustutada</a></button><button><a href=dok_redakt.php?id=".$line['id'].">redakteerida</a></button></div> </td> </tr>";
}

?>