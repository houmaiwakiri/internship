<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission3-4</title>
</head>
<body>
    <div class="post-edit">
        <form action="" method="post">
            <input type="text" name="name">
            <input type="text" name="com">
            <input type="submit" name="submit">
            <input type="number" name="edit">
            <input type="submit" name="submit" value="編集">
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
        }elseif(!empty($_POST["del"]) && empty($name) && empty($com)&& empty($_POST["edit"])){
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
        }elseif(!empty($_POST["edit"]) && empty($name) && empty($com)&& empty($_POST["del"])){
            //編集を受け取る。
            $edit = $_POST["edit"];//編集ナンバー受け取り
            $lines=file($filename,FILE_SKIP_EMPTY_LINES);
            $lastline= count($lines);
            foreach($lines as $line){
              $word=explode("<>",$line);
            }
            foreach($lines as $line){
                $editData=explode("<>",$line);
                //echo $word[0];
                if($editData[0] == $edit){
                  $edit_name=$editData[1];
                  $edit_com=$editData[2];
                  $edit_date=$editData[3];
                  $edit_num=$editData[0];
                  echo
                  '<input type="text" name="edit_name" value="'.$edit_name.'"></input><br>
                  <input type="text" name="edit_comment" value="'.$edit_com.'"></input>
                  <input type="hidden" name="edit_number" value="'.$edit_num.'"></input>
                  <input type="submit" name="button" value="編集する" style="font-size: 12px;"><br>
                  </form>';
                }
            }
        }elseif(!empty($_POST["edit_name"])&&!empty($_POST["edit_com"])&&!empty($_POST["edit_num"])){    
            //編集結果を書き込む。
            $edit_name=$_POST["edit_name"];
            $edit_com=$_POST["edit_com"];
            $edit_num=$_POST["edit_num"];            
        }else{
            echo "入力されていません。"."<br>";
        }
        //表示
        if(file_exists($filename)){
            foreach(file($filename) as $lines) {
                $line = explode("<>",$lines);//linesを<>で区切ってlineに代入
                echo $line[0].":";
                echo $line[1].":";
                echo $line[2].":";
                echo $line[3]."<br>";
            } 
        }      
    ?>
</body>
</html>