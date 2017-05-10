<?php require('gasemconta.class.php');
$gas = new GasEmConta();


if($_GET['do'] == 'addUser') $gas->addUser('Zé','teste@teste.com');
if($_GET['do'] == 'createGasStation') $gas->createGasStation(25);
if($_GET['do'] == 'updateGasStation') $gas->updateGasStation();
if($_GET['do'] == 'updateFuelPrice') $gas->updateFuelPrice($_POST['user_id']);

?>
<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<title>Gasolina ou álcool mais barato - Melhores preços em combustível - GASemCONTA</title>
	<meta name="description" content="gasolina, álcool, preço, combustível, barato" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="http://fonts.googleapis.com/css?family=Dosis:400,600" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="style.css" />
</head>

<body>
<h1>O GASemCONTA calcula qual o combustível mais barato e mais perto de você</h1>
<p>Pra que criar uma conta?</p>
<h2>Acesse usando o seu Facebook</h2>
<form action="index.php?do=addUser" method="post">
	<input type="email" />
	<input type="password" />
	<input type="submit" value="Entrar" />
</form>

<h3>Criar novo posto</h3>
<form action="index.php?do=createGasStation" method="post">
	<input id="name" name="name" placeholder="Nome do posto" type="text" />
	<input id="address" name="address" placeholder="Endereço" type="text" />
	<input id="city" name="city" placeholder="Cidade" type="text" />
	<input id="province" name="province" placeholder="UF" type="text" />
	<input id="gas-price" name="gas-price" placeholder="Preço da gasolina" type="text" />
	<input id="etanol-price" name="etanol-price" placeholder="Preço do etanol" type="text" />
	<input id="geolat" name="geolat" type="hidden" />
	<input id="geolng" name="geolng" type="hidden" />
	<input type="submit" value="Criar posto" />
</form>


<h3>Editar posto</h3>
<form action="index.php?do=updateGasStation" method="post">
	<input id="name" name="name" placeholder="Nome do posto" type="text" value="" />
	<input id="address" name="address" placeholder="Endereço" type="text" value="" />
	<input id="city" name="city" placeholder="Cidade" type="text" value="" />
	<input id="province" name="province" placeholder="UF" type="text" value="" />
	<input id="station_id" name="station_id" type="hidden"  value="1" />
	<input type="submit" value="Salvar" />
</form>


<h3>Preço do combustível</h3>
<form action="index.php?do=updateFuelPrice" method="post">
	<input id="gas-price" name="gas-price" placeholder="Preço da gasolina" type="text" />
	<input id="etanol-price" name="etanol-price" placeholder="Preço do etanol" type="text" />
	<input id="station_id" name="station_id" type="hidden" value="2" />
	<input id="user_id" name="user_id" type="hidden" value="25" />
	<input type="submit" value="Atualizar" />
</form>
<form action="index.php?do=findBestPrice" method="post">
	<input id="best-price" type="submit" value="Calcular melhor preço" />
</form>

<html>
<head>
<script type="text/javascript">
  function mask(inputName, mask, evt) {
    try {
      var text = document.getElementById(inputName);
      var value = text.value;

      // If user pressed DEL or BACK SPACE, clean the value
      try {
        var e = (evt.which) ? evt.which : event.keyCode;
        if ( e == 46 || e == 8 ) {
          text.value = '';
          return;
        }
      } catch (e1) {}

      var literalPattern=/[0\*]/;
      var numberPattern=/[0-9]/;
      var newValue = "";

      for (var vId = 0, mId = 0 ; mId < mask.length ; ) {
        if (mId >= value.length)
          break;

        // Number expected but got a different value, store only the valid portion
        if (mask[mId] == '0' && value[vId].match(numberPattern) == null) {
          break;
        }

        // Found a literal
        while (mask[mId].match(literalPattern) == null) {
          if (value[vId] == mask[mId])
            break;

        newValue += mask[mId++];
      }

      newValue += value[vId++];
      mId++;
    }

    text.value = newValue;
  } catch(e) {}
}
</script>
<form id="form1">
<input type="text" id="zipCode" onkeyup="javascript:mask('zipCode', '(00)0000-0000', event);" value="12345-6789" >
</form>

</body>
</html>