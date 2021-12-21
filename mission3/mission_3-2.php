<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission3-2</title>
</head>
<body>
    <form action="" method="post" value="コメント">
        <input type="text" name="name" value="お名前">
        <input type="text" name="com" value="コメント">
        <input type="submit" name="submit">
    </form>
    <?php
        $filename = "mission_3-1.txt";
        $fp = fopen($filename,"a");

        $num = 0;
        $name = $_POST["name"];
        $com = $_POST["com"];
        $date = date("Y年m月d日 H時i分s秒");

        $num = count( file( $filename ) ); // ファイルのデータの行数を数えて$numに代入
        $num++; // 投稿番号を取得
        $tex=$num."<>".$name."<>".$com."<>".$date;

        fwrite($fp,$tex.PHP_EOL);
        fclose($fp);
        foreach(file($filename) as $line) {
            echo explode("<>",$line)."<br>";
        } 
    ?>
</body>
</html>