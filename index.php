<!DOCTYPE html>
<html>

<head>
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Math Game</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center px-5 py-3">
                <h1>Welcome To Math Game</h1>
            </div>
            <div class="card-body px-5 py-3 text-center">
                <?php
        session_start();
        include "config.php";
            if (!isset($_COOKIE['username'])){
    ?>
                <center>
                    <form action='index.php' method='POST' class="mt-5">
                        <label for="name" class="form-labe">Enter your name</label>
                        <input type='text' name='name' class="form-control w-50 my-3">
                        <input type='submit' name='submitname' value='Submit' class="btn btn-primary">
                    </form>
                </center>
                <?php
            if(isset($_POST['submitname'])){
                // baca nama user dari form 
                $name = $_POST['name'];

                // simpan nama user ke cookie
                setcookie('username', $name);

                // redirect to math.php?mode=start
                header("Location:index.php?mode=start");
            }
		} else {
			if ($_GET['mode']=="play"){

                // If muncul pertanyaan
                if($_SESSION['lives'] > 0) {

                    if(isset($_POST['submitans'])) {
                        if($_POST['jawaban'] == $_SESSION['hasil']){
                            $_SESSION['score'] = $_SESSION['score']+10;
                        } else {
                            $_SESSION['lives'] = $_SESSION['lives']-1;
                            $_SESSION['score'] = $_SESSION['score']-2;   
                        }
                        header("Location:index.php?mode=play");
                    }
                    echo "
                    <h2>Hello, ".$_COOKIE['username']."</h2>
                    <h4>Lives : ".$_SESSION['lives']."</h4>
                    <h4>Score : ".$_SESSION['score']."</h4>
                    ";
                    if(!isset($_SESSION["a"])) $_SESSION["a"] = rand(1,10); 
                    if(!isset($_SESSION["b"])) $_SESSION["b"] = rand(1,10);

                    $bil1 = rand(1,10);
                    $bil2 = rand(1,10);
                    $_SESSION['hasil'] = $bil1+$bil2;
					?>
                <form action="index.php?mode=play" method="POST">
                    <?php echo $bil1. " + ".$bil2." = "; ?>
                    <input type='num' name='jawaban'>
                    <input type="submit" name="submitans" value="Kirim Jawaban">
                </form>
                <?php

                    // Else cetak game over
				} else {
                    // Simpan score ke database
                    $conn = mysqli_connect($localhost, $username, $password, $db);

                    $date = date("d/m/Y");
                    $namanya = $_COOKIE["username"];
                    $skornya = $_SESSION['score'];

                    $sql = "INSERT INTO rank (tanggal, nama, skor) VALUES ('$date', '$namanya', '$skornya')";
                    
                    if (mysqli_query($conn, $sql)) {
                    // echo "New record created successfully";
                    } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

                    mysqli_close($conn);
					// cetak game over
                    echo "<h3>Game over</h3>";

					// munculkan link: Main lagi -> mode=start | Hall of Fame -> mode=halloffame
                    echo "<a href='index.php?mode=start' class='btn btn-success'>Main lagi </a> <a href='index.php?mode=halloffame' class='btn btn-primary'>Hall of Fame</a>";
                    // header("Location:index.php?mode=start");
				}
			}

			if ($_GET['mode']=="start"){

                // Set score and lives
                $score = 0;
                $lives = 3;

				// simpan score dan lives ke session
                session_start();
                $_SESSION['score'] = $score;
                $_SESSION['lives'] = $lives;

				// redirect to math.php?mode=play
                header("Location:index.php?mode=play");
			}

			if ($_GET['mode']=="halloffame"){
                $conn = mysqli_connect($localhost, $username, $password, $db);

                $sql = mysqli_query($conn, "SELECT * FROM rank");
                while($row = mysqli_fetch_assoc($sql)){
                    $name = $row['skor'];
                    $name_explode = explode(" , ",$row['skor']);  

                    echo "skor : ".$name."<br>";
                    echo "<pre>";
                    // print_r($name_explode);
                    foreach($name_explode as $i) {
                        // echo $i;
                    }
                    echo "</pre>";
                }
			}
		}
	?>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP BUNDLE JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>