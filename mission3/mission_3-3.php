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
        $filename = "mission_3-1.txt";//ファイルの名前を決める
        $fp = fopen($filename,"a");//追記モードで開く。
        $num = 0;//必要かわからん
        $name = $_POST["name"];
        $com = $_POST["com"];
        $date = date("Y年m月d日 H時i分s秒");

        $num = count( file( $filename ) ); // ファイルのデータの行数を数えて$numに代入
        $num++; // 投稿番号を取得
        $tex=$num."<>".$name."<>".$com."<>".$date;

        fwrite($fp,$tex.PHP_EOL);
        foreach(file($filename) as $lines) {
            $line = explode("<>",$lines);
            echo $line[0];
            echo $line[1];
            echo $line[2];
            echo $line[3]."<br>";
        } 
        fclose($fp);
    ?>
</body>
</html>