<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="dizajn.css">
    <link rel="stylesheet" type="text/css" href="pozadina.css">
</head>

<?php

$ime = "";
$sifra = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST["korIme"])) {
        echo "Korisnicki račun nije unesen.";
    } else if (empty($_POST["sifra1"])) {
        echo "Lozinka nije unesena.";
    } else {
        $ime = $_POST["korIme"];
        $sifra = $_POST["sifra1"];

        dodaj($ime, $sifra);
    }
}

function dodaj($ime, $sifra)
{


    // Open and parse the XML file
    $xml = simplexml_load_file("korisnici.xml");

    foreach ($xml->user as $usr) {
        $usrn = $usr->korisnickoIme;
        $usrp = $usr->lozinka;
        if ($usrn == $ime || $usrp == $sifra) {

            echo "Korisničko ime ili lozinka iskorištena!";
            return;
        }
    }
    $child = $xml->addChild("user");
    $child->addChild("korisnickoIme", $ime);
    $child->addChild("lozinka", $sifra);

    $dom = new DOMDocument("1.0");
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save("korisnici.xml");

    return;
}
?>


<body>
    <!--Pozadina-->
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
     <!--Sign up forma-->
    <div class="login-box">
        <h2>Registracija</h2>
        <form action="" method="post">
            <div class="user-box">

                <input type="text" name="korIme" id="korIme" required="" />
                <label for="korIme">Korisničko ime:</label>
                <span id="porukaKorisniku" class="error"></span>
            </div>
            <div class="user-box">

                <input type="password" name="sifra1" id="sifra1" required="" />
                <label for="sifra1">Lozinka:</label>
                <span id="porukaSifri1" class="error"></span>
            </div>
            <div class="user-box">

                <input type="password" name="sifra2" id="sifra2" required="" />
                <label for="sifra2">Ponovite lozinku:</label>
                <span id="porukaSifri2" class="error"></span>
            </div>
            <button type="submit" id="gumb">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Registriraj se </button>

            <a href="login.php">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Povratak na login </a>

        </form>
    </div>
    
    <!--Javascript za javljanje grešaka-->
    <script type="text/javascript">
        document.getElementById("gumb").onclick = function(event) {
            var slanje_forme = true;

            var korIme = document.getElementById("korIme").value;
            if (korIme == "") {
                slanje_forme = false;
                document.getElementById("porukaKorisniku").innerHTML = "Korisničko ime ne smije biti prazno!<br>";

            }

            var sifra1 = document.getElementById("sifra1").value;
            if (sifra1 == "") {
                slanje_forme = false;
                document.getElementById("porukaSifri1").innerHTML = "Lozinka ne smije biti prazna!<br>";

            } else if (sifra1.length < 8) {
                slanje_forme = false;
                document.getElementById("porukaSifri1").innerHTML = "Lozinka treba imati najmanje 8 znakova!<br>";

            }


            var sifra2 = document.getElementById("sifra2").value;

            if (sifra2 == "") {
                slanje_forme = false;
                document.getElementById("porukaSifri2").innerHTML = "Ponovljena lozinka ne smije biti prazna!<br>";

            }

            if (sifra1 != sifra2) {
                slanje_forme = false;
                document.getElementById("porukaSifri2").innerHTML = "Lozinke trebaju biti iste";

            }

            if (slanje_forme != true) {
                event.preventDefault();
            }
        }
    </script>

</body>

</html>