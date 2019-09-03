<?php
echo "<html>\n<header>\n";
switch ($page) {
        case 1 : echo "<title>presentation</title>\n"; break;
        case 2 : echo "<title>tarifs</title>\n";break;
        case 3 : echo "<title>agenda</title>\n"; break;
        case 5 : echo "<title>aide</title>\n"; break;
        case 4 : echo "<title>password perdu</title>\n"; break;
        case 6 : echo "<title>inscription</title>\n"; break;

}
echo "</header>\n";
echo "<body>\n";
echo "image de fond a definir<br>\n";
echo "<center>planningGN<br>\n";
if ($page!=4&&$page!=6) {
echo '<form action = "index.php" method = "post">'."\n";
echo 'Email  :<input type = "text" name = "login" class = "box"><br>'."\n";
echo 'Password :<input type = "password" name = "password" class = "box"><br>'."\n";
echo '<input type = "submit" value = "Se Connecter"/><br>'."\n";
echo "<a href=perdu.php>password perdu</a> ";
echo "<a href=inscription.php>inscription</a>\n";
}
echo "<br>\n<br>\ntitre de la page suivant la variable qui va bien<br>\n";
    switch ($page) {
        case 1 : echo "presentation<br>\n"; break;
        case 2 : echo "tarifs<br>\n";break;
        case 3 : echo "planning<br>\n"; break;
        case 5 : echo "aide<br>\n"; break;
        case 4 : echo "password perdu<br>\n"; break;
        case 6 : echo "inscription<br>\n"; break;
}
echo "<br>\n";
echo "menu pourri a rendre beau<br>\n";
echo "<table>\n";
echo "<tr>";
echo "<td><a href=index.php>accueil</a></td>\n";
echo "<td><a href=tarifs.php>tarifs</a></td>\n";
echo "<td><a href=agenda.php>agenda</a></td>\n";
echo "<td><a href=aide.php>aide</a></td>\n";
echo "</tr>\n";
echo "</table>\n</center>\n<br>\n";
?>