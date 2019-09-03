<?php
echo "<html>\n<header>\n";
switch ($page) {
        case 1 : echo "<title>mes GNs</title>\n"; break;
        case 2 : echo "<title>les GNs du site</title>\n";break;
        case 3 : echo "<title>mon compte</title>\n";break;
        case 11 : echo "<title>GN</title>\n";break;
        case 12 : echo "<title>evenements</title>\n";break;
        case 13 : echo "<title>evenement</title>\n";break;
        case 14 : echo "<title>scenaristes</title>\n";break;
        case 15 : echo "<title>scenariste</title>\n";break;
        case 16 : echo "<title>PJs</title>\n";break;
        case 17 : echo "<title>PJ</title>\n";break;
        case 18 : echo "<title>PNJs</title>\n";break;
        case 19 : echo "<title>PNJ</title>\n";break;
        case 20 : echo "<title>role PJ</title>\n";break;
        case 21 : echo "<title>role PNJ</title>\n";break;
        case 22 : echo "<title>besoins PJ</title>\n";break;
        case 23 : echo "<title>besoin PJ</title>\n";break;
        case 24 : echo "<title>besoins PNJ</title>\n";break;
        case 25 : echo "<title>besoin PNJ</title>\n";break;
        case 26 : echo "<title>joueurs</title>\n";break;
        case 27 : echo "<title>joueur</title>\n";break;
        case 28 : echo "<title>scenario</title>\n";break;
        case 29 : echo "<title>runtime</title>";break;
	case 30 : echo "<title>running</title><meta http-equiv=refresh content=60>";break;
	case 31 : echo "<title>objectifs</title>";break;
}
echo "</header>\n";
echo "<body>\n";
echo "image de fond a definir<br>\n";
echo "<center>planningGN<br>\n";
switch ($page) {
        case 1 : echo "mes GNs<br>\n"; break;
        case 2 : echo "les GNs du site<br>\n";break;
        case 3 : echo "mon compte<br>\n";break;
        case 11 : echo "GN\n";break;
        case 12 : echo "liste des evenements\n";break;
        case 13 : echo "informations sur un evenement\n";break;
        case 14 : echo "liste des scenaristes\n";break;
        case 15 : echo "information sur un scenariste\n";break;
        case 16 : echo "liste des roles PJ\n";break;
        case 17 : echo "informations sur un PJ\n";break;
        case 18 : echo "liste des roles PNJ\n";break;
        case 19 : echo "information sur un PNJ\n";break;
        case 20 : echo "informations sur un role PJ\n";break;
        case 21 : echo "informations sur un role PNJ\n";break;
        case 22 : echo "liste des besoins PJ sur un event\n";break;
        case 23 : echo "informations sur les besoins PJ sur un event\n";break;
        case 24 : echo "liste des besoins PNJ sur un event\n";break;
        case 25 : echo "information sur les besoins PNJ sur un event\n";break;
        case 26 : echo "liste des joueurs sur le GN\n";break;
        case 27 : echo "information sur un joueur\n";break;
        case 28 : echo "scenario\n";break;
        case 29 : echo "runtime\n";break;
        case 29 : echo "running\n";break;
	case 30 : echo "silence, ca tourne !\n";break;
	case 31 : echo "les des objectifs\n";break;
}
echo "<br>\n<br>\n";
echo "menu pourri a rendre beau<br>\n";
echo "<table>\n";
echo "<tr>\n"; 
echo "<td><a href=liste.php>mes GNs</a></td>\n";
echo "<td><a href=gns.php>GNs sur le site</a></td>\n";
echo "<td><a href=compte.php>mon compte</a></td>\n";
echo '<td><a href="logout.php">se deconnecter</a></td>'."\n";
echo "</tr>\n</table>\n<br>\n";

echo "<table>\n<tr>\n";
echo "<td><a href=\"gn.php?gn=$gn\">general</a></td>\n";
echo "<td><a href=\"scenario.php?gn=$gn\">scenario</a></td>\n";
echo "<td><a href=\"event-list.php?gn=$gn\">evenements</a></td>\n";
echo "<td><a href=\"scenar-list.php?gn=$gn\">liste des scenaristes</a></td>\n";
echo "<td><a href=\"joueur-list.php?gn=$gn\">liste des joueurs</a></td>\n";
echo "<td><a href=\"role-list.php?gn=$gn&pnj=0\">roles des PJ</a></td>\n";
echo "<td><a href=\"role-list.php?gn=$gn&pnj=1\">roles des PNJ</a></td>\n";
echo "<td><a href=\"objectif-list.php?gn=$gn\">objectifs</a></td>\n";
echo "<td><a href=\"runtime.php?gn=$gn\">lancer le GN</a></td>\n";
echo "</tr>\n</table>\n";
}
echo "</center>\n<br>\n";
?>
