<!DOCTYPE html>
<html>
<head>
<title>TP 4.2 - Email</title>
</head>

<body>
    <p>Bienvenue sur notre site de voyage, votre passerelle vers l'aventure, la découverte et l'émerveillement ! Explorez des horizons lointains, plongez-vous dans des cultures fascinantes, et créez des souvenirs inoubliables à chaque étape de votre périple. Que vous rêviez de plages paradisiaques, de montagnes majestueuses ou de villes animées, notre site est conçu pour donner vie à vos aspirations de voyage.<br>

Laissez-vous inspirer par nos suggestions de destinations, découvrez des offres exclusives, et planifiez votre prochaine escapade en toute simplicité. Notre équipe dévouée est là pour vous guider à travers chaque étape de votre voyage, de la réservation à l'exploration sur place.<br>

Que votre voyage soit une escapade de détente, une aventure palpitante ou une immersion culturelle, nous sommes ravis de faire partie de votre voyage. Embarquez avec nous pour une expérience unique où chaque destination devient une nouvelle page de votre histoire de voyage.<br>

Bienvenue à bord et que votre voyage soit rempli de moments extraordinaires !</p>
    <form action="page.php" methode="post">
        <fieldset id="voyage">
            <legend>Voyage au Burundi</legend>
            <table>
                <tr>
                    <td>Burundi</td>
                    <td><input type="radio" name="Bujumbura" value=""></td>
                    <td><input type="date" name="umusi" id="date"></td>
            
                </tr><br>
                <tr>
                    <td>Canada</td>
                    <td><input type="radio" name="Canada" value=""></td>
                    <td><input type="date" name="umusi" id="dat"></td>
                </tr>
            </table>
        </fieldset>
        <fieldset id="argent">
            <legend>la selection du budget</legend>
            <table>
                <tr>
                    <td><select name="amahera" id="inoti">
                    <option value="500€">500€</option>
                    <option value="1000€">1000€</option>
                    <option value="5000€">5000€</option>
                    <option value="10000€">10000€</option>

                    </select></td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <input type="submit" value="envoyer">
                </tr>
            </table>
        </fieldset>
    </form>
<?php 
if(isset($_POST['envoyer'])){
    ech
}
?>
</body>
</html>