<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>伝説のポケモン</h2>
    <?php
        $Legendary_Pokemon = array("ディアルガ","パルキア","ダークライ","ギラティナ","アルセウス","ミュウツー");
        foreach($Legendary_Pokemon as $value){
            echo $value;
            echo "<br>";
        }
    ?>
</body>
</html>