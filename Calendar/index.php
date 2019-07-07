<?php 

function JePrechodnyRok ($rok)
{
    echo(date("L", mktime(0,0,0,1,1,$rok)));
    return (boolean) date("L", mktime(0,0,0,1,1,$rok));
}

function PocetDnu ($mesic, $rok)
{
    return cal_days_in_month(CAL_GREGORIAN, $mesic, $rok);
}

function PrvniDen ($mesic, $rok)
{
    $anglickeporadi = date("w", mktime(0, 0, 0, $mesic, 1, $rok));
    return ($anglickeporadi==0) ? 7 : $anglickeporadi;
}

function Bunka ($radek, $sloupec, $PrvniDen, $PocetDnu)
{
    $dny=Array(1=>"Po", "Út", "St", "Čt", "Pá", "So", "Ne");
    if ($sloupec==1) return $dny[$radek];
    $chcivratit = ($sloupec-2)*7 + $radek - $PrvniDen+1;
    if ($chcivratit<1 || $chcivratit>$PocetDnu) return "&nbsp;"; else return $chcivratit;
}


function Kalendar ($mesic, $rok)
{
    $mesice=Array(1=>"leden", "únor", "březen", "duben", "květen", "červen", "červenec", "srpen", "září", "říjen",    "listopad", "prosinec");
    //Validation
    if (!is_numeric($mesic)) return "Měsíc musí být číslo";
    if (!is_numeric($rok)) return "Rok musí být číslo";
    if ($mesic<1 || $mesic>12) return "Měsíc musí být číslo od 1 do 12";
    if ($rok<1980 || $rok>2050) return "Rok musí být číslo od 1980 do 2050";
    // zjištění počtu sloupců
    $PocetDnu = PocetDnu ($mesic, $rok); $PrvniDen = PrvniDen($mesic,$rok);
    //kontrola počtu sloupců
    if((date("W",mktime(0, 0, 0, $mesic, 31, 2019))-date("W",mktime(0, 0, 0, $mesic, 1, 2019)))<0) {
        $sloupcu = (date("W",mktime(0, 0, 0, $mesic, 31, 2019+1))-date("W",mktime(0, 0, 0, $mesic, 1, 2019)))+2;
        } else {
        $sloupcu = (date("W",mktime(0, 0, 0, $mesic, 31, 2019))-date("W",mktime(0, 0, 0, $mesic, 1, 2019)))+2;
        }; 
    // vlastní     kód (+2 = 1.sloupec s čísly + matematický rozdíl mezi základnami)
    echo "<TABLE border=\"1\" style=\"border-collapse: collapse\" width=\"",$sloupcu*30,"\">";
    echo "<TR><TD colspan=$sloupcu width=\"",$sloupcu*30,"\"
    align=\"center\">".$mesice[$mesic]."&nbsp;".$rok."</TD></TR>\n"; for ($radek=1;$radek<=7;$radek++)
    {
    echo "<TR align=\"center\">";
    for ($sloupec=1; $sloupec<=$sloupcu; $sloupec++) echo "<TD width=\"30\">".Bunka($radek, $sloupec, $PrvniDen, $PocetDnu)."</    TD>";
    echo "</TR>\n"; }
    echo "</TABLE>";
}
$měsíc = is_numeric('červen');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container">
    <h1>Kalendář</h1>
    <div>
    <p>Je přechodný rok?</p>
    <?=  JePrechodnyRok(2019)?>
    <br>
    <p>Kolik má červen dnů?</p>
    <?=  PocetDnu(6,2019)?>
    <br>
    <p>Jaký den připadá na 1.?</p>
    <?=  PrvniDen(6,2019)?>
    <br>
    <p>Jaké datum bude na 6.ř ve 2.sl ?</p>
    <?=  Bunka(6,2,(PrvniDen(6,2019)),(PocetDnu(6,2019)))?>
    <br>
    <p>Kalendář červen 2019</p>
    <?= Kalendar (6, 2019)?>
    </div>
    
    <div>
    <h2>Tvůj kalendář:</h2>
    <form action="" method="post">
        <label for="">Month</label>
        <input name="month" type="number">
        <label for="">Year</label>
        <input name="year" type="number">
        <input class="btn-primary" type="Submit">
    </form>
    <br>
    <?= Kalendar ((int)($_POST['month']), (int)($_POST['year']))?>
    </div>
</html>