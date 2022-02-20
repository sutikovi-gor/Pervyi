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
$request="SELECT * FROM dokumendid WHERE id='$id'";
$output=mysqli_query($connection, $request);
$line=mysqli_fetch_assoc($output);
}
//редактировать запрос
if (!empty($_POST['Nimetus'])) {
$Nimetus = htmlspecialchars(trim($_POST['Nimetus']));
$Sari = htmlspecialchars(trim($_POST['Sari']));
$Liikumine = htmlspecialchars(trim($_POST['Liikumine']));
$Registreerimisnumber = htmlspecialchars(trim($_POST['Registreerimisnumber']));
$Kuupäev = htmlspecialchars(trim($_POST['Kuupäev']));

$edit="UPDATE dokumendid SET Nimetus='$Nimetus', Sari='$Sari', Liikumine='$Liikumine', Registreerimisnumber='$Registreerimisnumber', Kuupäev='$Kuupäev' WHERE id='$id'";
$edit_db=mysqli_query($connection, $edit);
	if($edit_db) {
	echo "<br> <strong> Kirje on uuendatud </strong>"
    ?>
    <br>
    <br>
    <form method="post" action="">
<a href="dokumendid_bootstrap.php" class="btn btn-primary">Tagasi dokumentide juurde</a>
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
<form action="dok_otsing.php?" method="post">
<input type="submit" name="submit" value="  Tagasi otsingu juurde  ">
</form>

<html>
<title>Dokumendid</title>
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet">
</head>

<body>
<div style="height:300px;">
<form method="post" action="">
<br>
<div>
<label>Nimetus</label>
<input type="text" name="Nimetus" value="<?php echo $line['Nimetus'];?>">

</div>
<br>
<div>
<label>Sari</label>
<input name="Sari" list="Sari" value="<?php echo $line['Sari'];?>">
<datalist id="Sari">
    <option value="01 Põhitegevus" />
    <option value="02 Õppetöö" />
    <option value="03 Personalitöö" />
    <option value="04 Majandustegevus" />
    <option value="05 Asjaajamine" />
    <option value=" " />
</datalist> 
</div>
<br>
<div>
<label>Liikumine</label>
<input name="Liikumine" list="Liikumine" value="<?php echo $line['Liikumine'];?>">
<datalist id="Liikumine">
    <option value="Sisene" />
    <option value="Väljaminev" />
    <option value="Sissetulev" />
    <option value=" " />
</datalist>
</div>
<br>
<div>
<label>Registreerimisnumber</label>
<input type="text" name="Registreerimisnumber" value="<?php echo $line['Registreerimisnumber'];?>">
</div>
<br>
<div>
<label>Kuupäev</label>
<input type="date" name="Kuupäev" value="<?php echo $line['Kuupäev'];?>">
</div>
<br>

<input class="btn btn-primary" type="submit" name="submit" value="Redakteerida">

</form>
<br>

<form method="post" action="">
<a href="dokumendid_bootstrap.php" class="btn btn-primary">Tagasi dokumentide juurde</a>
</form>

</div>

<div style="position: fixed; bottom: 0; right: 0">

<form method="get" action="esi.html">
    

    <input class="" type="submit" value="Esilehekülg">

</form>
</div>
</body>

</html>