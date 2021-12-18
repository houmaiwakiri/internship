<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission2-4</title>
</head>
<body>
    <form action="" method="post" value="コメント">
        <input type="text" name="com">
        <input type="submit" name="submit">
    </form>
    <?php
            $com = $_POST["com"];
            if ($com == "ありがとう") {
                echo "どういたしまして";
            }elseif(!empty($_POST["com"])){
                echo $com."を受け付けました。";                
            }else{
            }

            $filename="mission_2-4.txt";
            $fp = fopen($filename,"a");
            fwrite($fp, $com.PHP_EOL);
            foreach(file($filename) as $line) {
                echo $line. "<br>";
            } 
            fclose($fp);
    ?>
</body>
</html>