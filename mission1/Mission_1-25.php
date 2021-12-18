<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
        $str = "ほりーわーるど";
        $filename="mission_1-25.txt";
        $fp = fopen($filename,"w");
        fwrite($fp, $str.PHP_EOL);
        fclose($fp);
        echo "書き込み成功！";
    ?>    
</body>
</html>