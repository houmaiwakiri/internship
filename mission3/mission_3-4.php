<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission3-4</title>
</head>
<body>
    <div class="post">
        <form action="" method="post" value="コメント">
            <input type="text" name="name" value="お名前">
            <input type="text" name="com" value="コメント">
            <input type="submit" name="submit">
        </form>
    </div>
    <div class="delete">
        <form action="" method="post" value="">
            <input type="number" name="del" value="削除対象番号"> 
            <input type="submit" name="submit" value="削除">
        </form>
    </div>
    <?php
        $filename = "mission_3-4.txt";//ファイルの名前を決める
        $date = date("Y年m月d日 H時i分s秒");
        if(!empty($_POST["name"]) && !empty($_POST["com"])){
            $fp = fopen($filename,"a");//追記モードで開く。
            $name = $_POST["name"];
            $com = $_POST["com"];

            if(file_exists($filename)){
                //投稿番号
                $lines=file($filename);//($filename,FILE_SKIP_EMPTY_LINES)
                $lastline= count($lines);
                $num=$lastline+1;
            }else{
               $num = 1;
            }
            $tex=$num."<>".$name."<>".$com."<>".$date;
            fwrite($fp,$tex.PHP_EOL);
            fclose($fp);
        }elseif(!empty($_POST["del"]) && empty($name) && empty($com)){
            //削除機能
            $del = $_POST["del"];//削除ナンバー受け取り
            if(!empty($_POST["del"])){
                $delnum=file($filename);
                for($i=0; $i<count($delnum); $i++){
                    $delData = explode("<>",$delnum[$i]);
                    //array_splice ( $配列, $開始位置[, $削除する要素の数 [, $置き換える要素を含んだ配列 ]] )
                    if($delData[0]==$del){
                        array_splice($delnum,$i,1);
                        file_put_contents($filename, implode("",$delnum));
                    }
                }
            }
        }else{
            echo "入力されていません。"."<br>";
        }
        //表示
        if(file_exists($filename)){
            foreach(file($filename) as $lines) {
                $line = explode("<>",$lines);//linesを<>で区切ってlineに代入
                echo $line[0];
                echo $line[1];
                echo $line[2];
                echo $line[3]."<br>";
            } 
        }      
    ?>
</body>
</html>