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
    for ($num = 1 ; $num <= 100 ; $num = $num + 1 ) {
        if($num%3==0 && $num%5==0){
            echo "FizzBuzz<br>";
        }elseif($num%3==0){
            echo "Fizz<br>";
        }elseif($num%5==0){
            echo "Buzz<br>";
        }else{
            echo $num . "<br>";
        }
    }
    ?>    
</body>
</html>