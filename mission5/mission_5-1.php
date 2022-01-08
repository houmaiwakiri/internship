<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission5-1</title>
</head>
<body>
    <form action="" method="post">
        <span>お名前:</span><input type="text" name="name">
        <span>コメント:</span><input type="text" name="comment">
        <span>パスワード:</span><input type="text" name="pass">
        <input type="submit" name="submit">
        <br>
        <span>削除番号指定:</span><input type="number" name="delete" value="削除対象番号"> 
        <span>パスワード:</span><input type="text" name="del_pass">
        <input type="submit" name="submit" value="削除">
        <br>
        <span>編集番号指定:</span><input type="number" name="edit">
        <span>パスワード:</span><input type="text" name="edit_pass">
        <input type="submit" name="submit" value="編集">
        <br>
        <!--formの閉じタグは下の方にある。-->
    <?php
        //ログイン情報
        $dsn = 'mysql:dbname=tb230882db;host=localhost';
        $user = 'tb-230882';
        $password = 'UdJfTfs5wT';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //.txt=>データーベース上に表を作る作業
        $sql="CREATE TABLE IF NOT EXISTS keiziban"
        ." ("
        ."number INT AUTO_INCREMENT PRIMARY KEY,"
        ."name char(32),"//32文字まで
        ."comment TEXT,"//無限
        ."date TEXT,"
        ."pass TEXT"
        .");";
        //queryは実行するという意味
        $stmt=$pdo->query($sql);

        //$filename = "mission_5-1.txt";//ファイルの名前を決める
        $date = date("Y年m月d日H時i分s秒");
        if(!empty($_POST["name"]) && !empty($_POST["comment"])&& !empty($_POST["pass"])&& empty($_POST["del_pass"]) && empty($_POST["edit_pass"])&&empty($_POST["delete"])&& empty($_POST["edit"])&&
        empty($_POST["edit_number"])){
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $password=$_POST["pass"];

            $sql = "INSERT INTO keiziban (name,comment,date,pass) VALUES (:name,:comment,:date,:pass);";
            $stmt = $pdo -> prepare($sql);
            //PDOは入る内容が文字なのか数字なのか指定している。
            //STR:文字　INT：数字
            // 「=」代入 「->」これを使って　という意味
            $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
            $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt -> bindParam(':pass',$password, PDO::PARAM_STR);
            $stmt -> bindParam(':date',$date, PDO::PARAM_STR);
            $stmt -> execute();
            /*txtに書き込むときのやつ
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
            */
        }elseif(!empty($_POST["delete"]) &&!empty($_POST["del_pass"])&& empty($name) && empty($comment)&& empty($_POST["edit"])&&empty($_POST["pass"])){
            //削除機能
            $del = $_POST["delete"];//削除ナンバー受け取り
            $del_pass=$_POST["del_pass"];//削除パスワード
            /*txtに書き込むとき
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
            */
            $sql = 'delete from keiziban where number=:delete';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':delete', $delete, PDO::PARAM_INT);
            $stmt->execute();
            
        }elseif(!empty($_POST["edit"]) && empty($name) && empty($comment)&& empty($_POST["delete"])){
            //編集を受け取る。
            $edit = $_POST["edit"];//編集ナンバー受け取り
            $edit_pass=$_POST["edit_pass"];
            /*txtに書き込むとき。
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
            */
            $ok=0;
            $sql = 'SELECT * FROM keiziban';
            $stmt = $pdo->query($sql);
            //fetchALLは$stmtを分解して綺麗に揃えてから$resultsに代入しているイメージ（正確な情報か分からない）
            $lines = $stmt->fetchAll();
            //連想配列＝配列の中に配列が入っているイメージ。
            foreach ($lines as $line){
                //配列は通常数字を入れるが、今回はカラム名を入力する。
                //if文を通った時点でどこのラインかは特定できている。
                //特定したひとつの$lineしか持ってこれない。
                if ($edit==$line['number']&&$in_pass==$line['password']){ 
                    $ok=1;
                    $edit_name=$line['name'];
                    $edit_comment=$line['comment'];
                    $edit_number=$line['number'];
                    echo
                    '<span>お名前:</span><input type="text" name="edit_name" value="'.$edit_name.'"></input><br>
                    <span>コメント:</span> <input type="text" name="edit_comment" value="'.$edit_comment.'"></input>
                    <input type="hidden" name="edit_number" value="'.$edit_number.'"></input>
                    <input type="submit" name="submit" value="編集する"><br>
                    </form>';    
                }
            }
            //「===」は設定も同じでなければ通らない。
            //ex)"1+1"===1+1は通らない。(文字列と数字は別物)
            if($ok===0){
              echo "入力条件が間違っています。<br>";
            }
        }elseif(!empty($_POST["edit_name"])&&!empty($_POST["edit_comment"])&&!empty($_POST["edit_number"])){    
            $edit_name=$_POST["edit_name"];
            $edit_commett=$_POST["edit_comment"];
            $edit_number=$_POST["edit_number"]; 
            $date=date("Y/m/d h時i分");      
            /*txtに編集結果を書き込む。
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
            */
            $sql = 'update keiziban set name=:name,comment=:comment,date=:date where number=:number';
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':name', $edit_name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $edit_comment, PDO::PARAM_STR);
            $stmt->bindParam(':number', $edit_number, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
        }elseif(isset($_POST["edit_number"])&&(empty($_POST["edit_name"])||empty($_POST["edit_comment"])) ){
            echo "編集入力欄に入力されていません。";
        }else{
            echo "<br>"."入力されていません。"."<br>";
        }
        /*txt表示
        if(file_exists($filename)){
            foreach(file($filename,FILE_SKIP_EMPTY_LINES) as $lines) {
                $line = explode("<>",$lines);//linesを<>で区切ってlineに代入
                echo $line[0];
                echo $line[1];
                echo $line[2];
                echo $line[3]."<br>";
            } 
        }*/   
        //MySQLで表示
        $sql = 'SELECT * FROM keiziban';
        $stmt = $pdo->query($sql);
        //fetchALLは$stmtを分解して綺麗に揃えてから$resultsに代入しているイメージ（正確な情報か分からない）
        $lines = $stmt->fetchAll();
        //連想配列＝配列の中に配列が入っているイメージ。
        foreach ($lines as $line){
            //配列は通常数字を入れるが、今回はカラム名を入力する。
            echo $line['number'].':';
            echo $line['name'];
            echo "[".$line['date']."]<br>";
            echo "⇒".$line['comment']."<br>";
        }
    ?>
</body>
</html>