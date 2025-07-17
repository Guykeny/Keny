<!DOCTYPE html>
<html>
<head>
<title>TP 4.2 - Email</title>
</head>
<body>
    <?php 
    if(!empty($_POST["navigateur"])){
        if(!empty($_POST["expediteur"])){
        echo "<table border=\"1\">";
        echo "<tr>";
        echo "<caption> votre mail et navigateur </caption>";
        foreach($_POST as $cle => $val){
            echo "<tr><td> $cle : &nbsp;</td><td>". stripslashes($val). "</td></tr>";

        }
        echo "</table>";
        }else{
            echo "<script>alert('Le formulaire est incomplet');document.location='exo2.php'</script>";
        }
    }
    ?>
    <form action="exo2.php" method="post">
    <fieldset>
        <legend>Saisir votre mail</legend>
        <table border="0">
            <tr>
                <td>mail :</td>
                <td><input type="email" name="expediteur"></td><br>
                <td><input type="hidden" name="navigateur" value="<?= $_SERVER['HTTP_USER_AGENT']; ?>"></td>
                
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Envoyer"></td>
            </tr>
        </table>   
    </fieldset>



    </form>
        </body>
</html>