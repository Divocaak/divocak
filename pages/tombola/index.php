<?php
// generování seznamu
/* for($i = 1; $i <= 109; $i++){
    echo "g" . $i . "<br>";
} */

if (isset($_POST["reset"])) {
    resetVal();
}
if (isset($_POST["getNum"])) {

    eraseFromAvailable();

    unset($_POST["getNum"]);
}

function resetVal()
{
    fopen("nums/used.txt", "w");
    if (!copy("nums/saved.txt", "nums/available.txt")) {
        $_SESSION["output"] = "Někde se stala chyba";
    }

    $_SESSION["output"] = "Hodnoty nastaveny do počátečního stavu";
}

function eraseFromAvailable()
{
    $available = file("nums/available.txt");
    if ((count($available)) > 0) {
        $selected = "";
        do {
            $index = rand(0, (count($available) - 1));
            $selected = $available[$index];
        } while ($selected == "");


        $used = file("nums/used.txt");
        $used[] = $selected;
        unset($available[$index]);

        file_put_contents("nums/available.txt", $available);
        file_put_contents("nums/used.txt", $used);

        prepareOutput($selected, strval(count($available)));
    } else {
        $_SESSION["output"] = "VYPRODÁNO";
    }
}


function prepareOutput($selected, $remaining)
{
    $clr = "";
    $clrWord = "";
    switch (substr($selected, 0, 1)) {
        case "r":
            $clr = "#de68a3";
            $clrWord = "(Růžová) ";
            break;
        case "b":
            $clr = "#1e4f9e";
            $clrWord = "(Modrá) ";
            break;
        case "g":
            $clr = "#72b89c";
            $clrWord = "(Zelená) ";
            break;
    }

    $_SESSION["output"] = '<i class="bi bi-circle-fill" style="color:' . $clr . ';"></i> ' . $clrWord . "<b>" . substr($selected, 1, strlen($selected)) . "</b><br>
    <span class='text-secondary'>(Zbývá: " . $remaining . ")</span>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tombola</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body class="p-5 m-5">
    <form action="index.php" method="post">
        Divočák 2021
        <div class="col-6"><button class="btn btn-outline-secondary" name="reset">Resetovat</button></div>
    </form>
    <div class="text-center">
        <h1><?php echo $_SESSION["output"]; ?></h1>
        <form action="index.php" method="post">
            <button class="btn btn-primary btn-lg" name="getNum">Vylosovat</button>
        </form>
    </div>
</body>

</html>