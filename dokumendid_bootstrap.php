<?php
include 'config.php';
?>
<?php
error_reporting(0);
//добавление в базу
if ($_SERVER['REQUEST_METHOD']=='POST'){
if (!empty($_POST['Nimetus']) && !empty($_POST['Registreerimisnumber']) && !empty($_POST['Liikumine']) && !empty($_POST['Sari']) && !empty($_POST['Kuupäev']) ){
$Nimetus = htmlspecialchars(trim($_POST['Nimetus']));
$Registreerimisnumber = htmlspecialchars(trim($_POST['Registreerimisnumber']));
$Liikumine = htmlspecialchars(trim($_POST['Liikumine']));
$Sari = htmlspecialchars(trim($_POST['Sari']));
$Kuupäev = htmlspecialchars(trim($_POST['Kuupäev']));
;
}

//запрос
$query="INSERT INTO Dokumendid (Nimetus, Registreerimisnumber, Liikumine, Sari, Kuupäev) VALUES('".$Nimetus."','".$Registreerimisnumber."','".$Liikumine."','".$Sari."','".$Kuupäev."')";
$output=mysqli_query($connection, $query);

//количество ответов на запрос
$result=mysqli_affected_rows($connection);

//mysqli_affected_rows() проверяет, сколько запросов было сделано
if ($result == 1) {
echo "<br> <strong> Kirje lisamine õnnestus </strong>";
} else {
echo "<br> <strong> Kirje lisamine nurjus </strong>";

}
}

//вывод
$checkSQL=mysqli_query($connection, 'SELECT * FROM dokumendid');

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
?>

<html>
<head>
	    

<title>Dokumendid</title>
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
<div style="position:relative; left: 50">
<form method="post" action="">

	  <div class="form-group">
<div>
<label>Nimetus</label>
<input class="form-control" type="text" name="Nimetus" required>
</div>
<div>
<label>Registreerimisnumber</label>
<input class="form-control" type="text" name="Registreerimisnumber" required>
</div>
<div>
<label>Liikumine</label>
<input class="form-control" name="Liikumine" list="Liikumine" required />
<datalist id="Liikumine">
    <option value="Sisene" />
    <option value="Väljaminev" />
    <option value="Sissetulev" />
</datalist>
</div>
<div>
<label>Sari</label>
<input class="form-control" name="Sari" list="Sari" required />
<datalist id="Sari">
    <option value="01 Põhitegevus" />
    <option value="02 Õppetöö" />
    <option value="03 Personalitöö" />
    <option value="04 Majandustegevus" />
    <option value="05 Asjaajamine" />
</datalist> 
</div>
<div>
<label>Kuupäev</label>
<input type="date" name="Kuupäev" required>
</div>
<br>
<input class="btn btn-primary" type="submit" name="submit" value="Salvesta dokument">
</form>
<br>
<br>

<!--- Добавление файла с помощью "dok_faillisamine.php" в папку mus_doc_files с добавлением ID --->

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
<br>

<!--- Добавляем поиск --->

<form method="get" action="dok_otsing.php?id">
	

	<input class="btn btn-primary" type="submit" value="Otsi dokument">

</form>

<div style="position: fixed; bottom: 0; right: 0">

<form method="get" action="esi.html">
    

    <input class="" type="submit" value="Esilehekülg">

</form>
</div>


	

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
