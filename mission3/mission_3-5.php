<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission3-5</title>
</head>
<body>
    <form action="" method="post">
        <span>お名前:</span><input type="text" name="name">
        <span>コメント:</span><input type="text" name="com">
        <span>パスワード:</span><input type="text" name="pass">
        <input type="submit" name="submit">
        <br>
        <span>削除番号指定:</span><input type="number" name="del" value="削除対象番号"> 
        <span>パスワード:</span><input type="text" name="del_pass">
        <input type="submit" name="submit" value="削除">
        <br>
        <span>編集番号指定:</span><input type="number" name="edit">
        <span>パスワード:</span><input type="text" name="edit_pass">
        <input type="submit" name="submit" value="編集">
        <br>
        <!--formの閉じタグは下の方にある。-->
    <?php
        $filename = "mission_3-5.txt";//ファイルの名前を決める
        $date = date("Y年m月d日H時i分s秒");
        if(!empty($_POST["name"]) && !empty($_POST["com"])&& !empty($_POST["pass"])&& empty($_POST["del_pass"]) && empty($_POST["edit_pass"])&&empty($_POST["del"])&& empty($_POST["edit"])&&
        empty($_POST["edit_num"])){
            $fp = fopen($filename,"a");//追記モードで開く。
            $name = $_POST["name"];
            $com = $_POST["com"];
            $pass=$_POST["pass"];
            if(file_exists($filename)){
                //投稿番号
                $lines=file($filename);//($filename,FILE_SKIP_EMPTY_LINES)
                $lastline= count($lines);
                $num=$lastline+1;
            }else{
               $num = 1;
            }
            $tex=$num."<>".$name."<>".$com."<>".$date."<>".$pass."<>";
            fwrite($fp,$tex.PHP_EOL);
            fclose($fp);
        }elseif(!empty($_POST["del"]) &&!empty($_POST["del_pass"])&& empty($name) && empty($com)&& empty($_POST["edit"])&&empty($_POST["pass"])){
            //削除機能
            $del = $_POST["del"];//削除ナンバー受け取り
            $del_pass=$_POST["del_pass"];//削除パスワード
            $lines=file($filename,FILE_SKIP_EMPTY_LINES);
            $lastline= count($lines);
            $delnum=file($filename);
            for($i=0; $i<count($delnum); $i++){
                $delData = explode("<>",$delnum[$i]);
                //array_splice ( $配列, $開始位置[, $削除する要素の数 [, $置き換える要素を含んだ配列 ]] )
                if($delData[4]==$del_pass&&$delData[0]==$del){
                    array_splice($delnum,$i,1);
                    file_put_contents($filename, implode("",$delnum));
                }else{                    
                }
            }
        }elseif(!empty($_POST["edit"]) && empty($name) && empty($com)&& empty($_POST["del"])){
            //編集を受け取る。
            $edit = $_POST["edit"];//編集ナンバー受け取り
            $edit_pass=$_POST["edit_pass"];
            $lines=file($filename,FILE_SKIP_EMPTY_LINES);
            $lastline= count($lines);
            foreach($lines as $line){
                $tex=explode("<>",$line);
                //echo $word[0];
                if($tex[4]==$edit_pass&&$tex[0] == $edit){
                  $edit_name=$tex[1];
                  $edit_com=$tex[2];
                  $edit_date=$tex[3];
                  $edit_num=$tex[0];
                  echo
                  '<span>お名前:</span><input type="text" name="edit_name" value="'.$edit_name.'"></input><br>
                  <span>コメント:</span> <input type="text" name="edit_com" value="'.$edit_com.'"></input>
                  <input type="hidden" name="edit_num" value="'.$edit_num.'"></input>
                  <input type="submit" name="submit" value="編集する"><br>
                  </form>';
                }
            }
        }elseif(!empty($_POST["edit_name"])&&!empty($_POST["edit_com"])&&!empty($_POST["edit_num"])){    
            //編集結果を書き込む。
            $edit_name=$_POST["edit_name"];
            $edit_com=$_POST["edit_com"];
            $edit_num=$_POST["edit_num"];       
            $lines=file($filename,FILE_SKIP_EMPTY_LINES);
            $lastline= count($lines);
            $fp=fopen($filename,"w");
            foreach($lines as $line){
                $tex=explode("<>",$line);
                if($tex[0]!=$edit_num){
                fwrite($fp,$line);
                }else{
                fwrite($fp,$edit_num."<>".$edit_name."<>".$edit_com."<>".$date."<>".$tex[4].PHP_EOL);
                }
            }fclose($fp);
        }elseif(isset($_POST["edit_num"])&&(empty($_POST["edit_name"])||empty($_POST["edit_com"])) ){
            echo "編集入力欄に入力されていません。";
        }else{
            echo "<br>"."入力されていません。"."<br>";
        }
        //表示
        if(file_exists($filename)){
            foreach(file($filename,FILE_SKIP_EMPTY_LINES) as $lines) {
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