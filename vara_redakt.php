
<?php
error_reporting(0);
include 'config.php';
?>
<?php
//проверка
if (empty($_GET['id'])) {
	die('Sihtmärk ei ole valitud!');
} else {
	$id = $_GET['id'];
//запрос
$request="SELECT * FROM vara WHERE id='$id'";
$output=mysqli_query($connection, $request);
$line=mysqli_fetch_assoc($output);
}
//редактировать запрос
if (!empty($_POST['Nimetus'])) {
$Nimetus = htmlspecialchars(trim($_POST['Nimetus']));
$Inventaarinumber = htmlspecialchars(trim($_POST['Inventaarinumber']));
$Maksumus = htmlspecialchars(trim($_POST['Maksumus']));
$Vastutav = htmlspecialchars(trim($_POST['Vastutav']));
$Soetamine = htmlspecialchars(trim($_POST['Soetamine']));
$Mahaarvutamine = htmlspecialchars(trim($_POST['Mahaarvutamine']));
$Asukoht = htmlspecialchars(trim($_POST['Asukoht']));

$edit="UPDATE vara SET Nimetus='$Nimetus', Inventaarinumber='$Inventaarinumber', Maksumus='$Maksumus', Vastutav='$Vastutav', Soetamine='$Soetamine', Mahaarvutamine='$Mahaarvutamine', Asukoht='$Asukoht' WHERE id='$id'";
$edit_db=mysqli_query($connection, $edit);
	if($edit_db) {
	echo "<br> <strong> Kirje on uuendatud </strong>"
    ?>
    <br>
    <br>
    <form method="post" action="">
<a href="vara.php" class="btn btn-primary">Tagasi vara juurde</a>
</form>

<?php
	die();
	} else {
	echo "<strong> redakteerimine ei õnnestunud </strong>";
	}

}


?>
<br>
<br>
<form action="vara_otsing.php?" method="post">
<input type="submit" name="submit" value="  Tagasi otsingu juurde  ">
</form>

<html>
<title>Vara_redakt</title>
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet">
</head>



<body>
<div style="position:relative; left: 50">
<form method="post" action="">
<br>
<br>

<div>
<label>Nimetus</label>
<input class="form-control" type="text" name="Nimetus" value="<?php echo $line['Nimetus'];?>" required>
</div>
<div>
<label>Inventaarinumber</label>
<input class="form-control" type="text" name="Inventaarinumber" value="<?php echo $line['Inventaarinumber'];?>" required>
</div>
<div>
<label>Maksumus eur.</label>
<input class="form-control" type="text" name="Maksumus" value="<?php echo $line['Maksumus'];?>" required>
</div>
<!--- выбор с таблицы oppejoud значений столбца Nimi --->
<div>
<label>Vastutav isik</label>
<input class="form-control" name="Vastutav" list="Vastutav" value="<?php echo $line['Vastutav'];?>" required />
<datalist id="Vastutav">
    <option>
 <?php
    $query = mysqli_query($connection, "SELECT * FROM oppejoud ORDER BY id DESC");
    $numrows = mysqli_num_rows($query);
    while ($row = mysqli_fetch_assoc($query)) {
echo '<option>'.$row['Nimi'].'</option>';
}
?>
</datalist> 
</div>

<div>
<label>Soetamise kuupäev</label>
<input type="date" name="Soetamine" value="<?php echo $line['Soetamine'];?>" required>
</div>
<div>
<label>Mahaarvutamise kuupäev</label>
<input type="text" name="Mahaarvutamine" value="<?php echo $line['Mahaarvutamine'];?>" required>
</div>
<div>
<label>Asukoht</label>
<input class="form-control" type="text" name="Asukoht" value="<?php echo $line['Asukoht'];?>" required>
</div>
<br>

<input class="btn btn-primary" type="submit" name="submit" value="Redakteerida">

</form>
<br>

<form method="post" action="">
<a href="vara.php" class="btn btn-primary">Tagasi vara juurde</a>
</form>

</div>

<div style="position: fixed; bottom: 0; right: 0">

<form method="get" action="esi.html">
    

    <input class="" type="submit" value="Esilehekülg">

</form>
</div>
</body>

</html>