<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>TP PHP 4.1 - Calculatrice</title>
</head>

<body>
    <!-- A INSERER : CODE PHP POUR TRAITER LE FORMULAIRE -->
    <?php 
    $nb1="";
    $nb2="";
    $resultat="";


    if(isset($_POST['calcul'])){
        if(!empty($_POST['nb1']) && !empty($_POST['nb2'])){
            $nb1=(int) $_POST['nb1'];
            $nb2=(int) $_POST['nb2'];
            switch($_POST['calcul']){
                case "Addition x+y" :
                    $resultat=$nb1 +$nb2;
                    echo $resultat;
                    break;
                case "Soustraction x-y":
                    $resultat=$nb1-$nb2;
                    echo $resultat;
                    break;
                case "Division x/y":
                    $resultat=$nb1/$nb2;
                    echo $resultat;
                    break;
                case "Puissance x^y":
                    $resultat=pow($nb1,$nb2);
                    echo $resultat;
                    break;
                default:
                echo "choisissez entre la somme la division la soustraction ou la puissance";
                break;
            }
        }
    }
    ?>
    <h3>Entrez deux nombres : </h3>
    <!-- A MODIFIER : CODE PHP POUR AFFICHER ARGUMENTS ET RESULTAT EVENTUELS  -->
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
        <fieldset>
            <legend>Calculatrice en ligne</legend>
            <table>
                <tbody>
                    <tr>
                        <td><label><b> Nombre 1 </b></label> <input type="number" step="1" name="nb1" size="30"
                                value="" />
                        </td>
                    </tr>
                    <tr>
                        <td><label><b> Nombre 2 </b></label> <input type="number" step="1" name="nb2" size="30"
                                value="" />
                        </td>
                    </tr>
                    <tr>
                        <td><label><b> Résultat </b></label> <input type="number" step="1" name="result" size="30"
                                value="" disabled />
                        </td>
                    </tr>
                    <tr>
                        <td><label><b> Choisissez ! </b></label> <input type="submit" name="calcul"
                                value="Addition x+y" />&nbsp;&nbsp;&nbsp;
                            <input type="submit" name="calcul" value="Soustraction x-y" />&nbsp;&nbsp;&nbsp;
                            <input type="submit" name="calcul" value="Division x/y" />&nbsp;&nbsp;&nbsp;
                            <input type="submit" name="calcul" value="Puissance x^y" />&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </form>

</html>
