<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Game</title>

    <style>
    </style>
</head>

<body>
    <?php
        if(isset($_POST["submit"])) {
            // Baca data dari form
            $username = $_POST['nama'];
            $tgl = date("d/m/Y");

            $nyawa = 3;
            $skor = 0;

           setcookie('nyawa', $nyawa, time()+3*30*24*60*60);
            setcookie('skor', $skor, time()+3*30*24*60*60);


            // SET TO COOKIE
            setcookie('username', $username, time()+3*30*24*60*60);
            setcookie('tgl', $tgl, time()+3*30*24*60*60);

            header("Location:index.php");
        }
        if(!isset($_COOKIE['username'])) {
            echo "<h1>Selamat Datang</h1>";
        ?>
        <form action="index.php" method="POST">
            <input type="text" name="nama">
            <input type="submit" name="submit" value="Submit">
    </form>
        <?php
        } else {

            // VARIABLE SOAL
            $a = $_COOKIE['a'];
            $b = $_COOKIE['b'];

            // JAWABAN SOAL

                if(isset($_POST['kirimJawaban'])) {
                    // RANDOM SOAL
                    if(!isset($_COOKIE["rand"])) $_COOKIE["a"] = rand(1,10);
                    if(!isset($_COOKIE["rand"])) $_COOKIE["b"] = rand(1,10);
                    $jawabanSoal = $a+$b;
                    echo $jawabanSoal;

                // JAWABAN USER
            }
            echo "<h1>Halo, selamat datang ".$_COOKIE['username']."</h1>";
            echo "<h3>Nyawa : ".$_COOKIE['nyawa']."</h3>";
            echo "<h3>Skor ".$_COOKIE['skor']."</h3>";
            echo "<form action='index.php' method='POST'>
                    <label for='soal'>
                     <h3> ".$_COOKIE['a']."+".$_COOKIE['b']."</h3>
                    </label>
                    <input type='num' name='jawab'>
                    <input type='submit' name='kirimJawaban' value='Enter'>
                </form>";
        }


    ?>
</body>

</html>