<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission3-3</title>
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
    <div class="edit">
        <form action="" method="post" value="">
            <input type="number" name="edit" value="編集対象番号"> 
            <input type="submit" name="submit" value="編集">
        </form>            
    </div>
    <?php
        $filename = "mission_3-4.txt";//ファイルの名前を決める
        $fp = fopen($filename,"a");//追記モードで開く。
        $name = $_POST["name"];
        $com = $_POST["com"];
        $date = date("Y年m月d日 H時i分s秒");
        //これを使うと、投稿を削除した時に番号が重なってしまう。とりあえず先に進む。
        $num = count( file( $filename ) ); // ファイルのデータの行数を数えて$numに代入
        $num++; // 投稿番号を取得

        /*メンバーのコード
        $lines = file($filename.FILE_IGNORE_NEW_LINES);
        $lastline = $lines[count($lines)-1];
        $num = explode("<>",$lastline)[0]+1;
        */

        $tex=$num."<>".$name."<>".$com."<>".$date;

        if($name=="" && $com==""){
        }elseif($name==""){
        }elseif($com==""){
        }else{
            fwrite($fp,$tex.PHP_EOL);
            fclose($fp);
        }
        
        //削除
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
        //編集
        $edit = $_POST["edit"];
        if(isset($_POST["edit"])){
            foreach(file($filename)as $editForm){
                $editnum = explode("<>",$editForm);
            }
            //もし編集ナンバーと投稿ナンバーが同じ場合、処理を行う。
            if($editnum[0] == $edit){
                echo "成功";
            }else{
                echo "omg";
            }
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