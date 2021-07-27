<?php
require_once "connection.php";
$err = "";
session_start();

if(isset($_SESSION["name"])){
    session_unset();
    session_destroy();
    header("Location:login.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $tc = $_POST["tc"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $year = $_POST["year"];

    try {

        $request = new SoapClient('https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL');

        $result = $request->TCKimlikNoDogrula(array(
                'TCKimlikNo' => $tc,
                'Ad' => $name,
                'Soyad' => $surname,
                'DogumYili' => $year)
        );

        if ($result->TCKimlikNoDogrulaResult) {

                $sql = "insert into alive (tc,name,surname,year) values ('$tc','$name','$surname','$year');";

                $result = mysqli_query($conn, $sql);

                $_SESSION["name"] = $name;
                $sql2 = "select admin from alive where tc = '$tc'";
                $result2 = mysqli_query($conn, $sql2);
                $row = mysqli_fetch_assoc($result2);
                if ($row["admin"] == 0) {
                    header("Location:main.php");
                } else {
                    header("Location:admin/index.php");
                }




        } else {
            $err = "Wrong information!";
        }

    } catch (Exception $exc) {

        $err = $exc->getMessage();
    }



}


?>


<?php include "header.php"?>
<body>


    <div class="show-login">
        <img style="height: 15px;width: 15px" src="images/sign-in-alt-solid.svg">

        GET IN
    </div>

    <div class="container">
        <div class="hide-login">
            <img style="height: 15px;width: 15px" src="images/times-circle-solid.svg">
        </div>
            <form class="form-container" method="post">
                <h1>Login</h1>
                <span style="color: red; font-weight: bold" class="help-block"><?php echo $err ?></span>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="33333333333" name="tc" required autocomplete="off">
                    <label for="floatingInput">TC Number</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Name" name="name" required autocomplete="off">
                    <label for="floatingInput">Name</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Surname" name="surname" required autocomplete="off">
                    <label for="floatingInput">Surname</label>
                </div>
                <div class="form-floating">
                    <input type="number" class="form-control" id="floatingInput" placeholder="Year" name="year" required autocomplete="off">
                    <label for="floatingInput">Birth Year</label>
                </div>
                <button class="btn btn-secondary">LOGIN</button>
            </form>
    </div>

    <script type="text/javascript">
        $(".show-login").on("click",function (){
            $(".container").toggleClass("showed");
        });
        $(".hide-login").on("click",function (){
            $(".container").toggleClass("showed");
        });

    </script>

</body>
</html>