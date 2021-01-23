<?php
  echo date("d/m/Y");
  // 20/06/2015

  echo "<br>";
  echo "<br>";

  echo time();


  echo "<br>";
  echo "<br>";

  $nextWeek = time() + (7 * 24 * 60 * 60); // 7 dias * 24 horas * 60 minutos * 60 segundos
  echo 'Now:       '. date('d-m-Y') ."<br>";
  echo 'Next Week: '. date('d-m-Y', $nextWeek) ."<br>";
  echo 'Next Week: '. date('d-m-Y', strtotime('+1 week')) ."<br>";
// Now: 04-07-2015 à Data atual
// Next Week: 11-07-2015 à Uma semana após a data atual
// Next Week: 11-07-2015 à Uma semana após a data atual utilizando strtotime


  echo "<br>";
  echo "<br>";


  echo 'Next Month: '. date('d-m-Y', strtotime('+1 month')) ."<br>";
  // Next Month: 04-08-2015

  echo "<br>";
  echo "<br>";


  $data = mktime(02,30,00,04,30,1995); //hora, minuto, segundo, mês, dia e ano
   // Mostra 30-04-1995
   echo date("d-m-Y", $data)."<br>";

  // Mostra 30-04-1995 02:30
  echo date("d-m-Y H:i", $data)."<br>";

  // Mostra 1995
  echo date("Y", $data)."<br>";

  echo "<br>";
  echo "<br>";

$atual = new DateTime();
$especifica = new DateTime(' 1990-01-22');
$texto = new DateTime(' +1 month');

print_r($atual); echo "<br>";
print_r($especifica); echo "<br>";
print_r($texto); echo "<br>";


echo "<br>";
echo "<br>";


$data = new DateTime();
echo $data->format('d-m-Y H:i:s');

echo "<br>";
$data = new DateTime('+1 month');
echo $data->format('d-m-Y H:i:s'); // Dia, mês, ano, Hora, Min e seg.

echo "<br>";
echo "<br>";

$data = new DateTime('22-01-1990');
$data->modify('+1 month');
echo $data->format('d-m-Y H:i:s');