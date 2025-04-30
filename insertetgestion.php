#!/usr/bin/php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Connexion DB
$host = "localhost";
$dbname = "domoticz_db";
$username = "phpmyadmin";
$password = "tp";
$connexion = mysqli_connect($host, $username, $password, $dbname);
if (!$connexion) {
    echo "Erreur de connexion MySQL : " . mysqli_connect_error();
    exit;
}
// Appel API Domoticz
$url = "http://192.168.4.1:8080/json.htm?type=command&param=getdevices&filter=all&used=true&order=Name";
$json = file_get_contents($url);
$data = json_decode($json, true);
$idc = random_int(1, 10);
if ($data && isset($data['result'])) {
    foreach ($data['result'] as $capteur) {
        $id = (int)$capteur['idx'];
        $nom = mysqli_real_escape_string($connexion, $capteur['Name']);
        $valeur = mysqli_real_escape_string($connexion, $capteur['Data']);
        $type = mysqli_real_escape_string($connexion, $capteur['Type']);
        $date = date('Y-m-d H:i:s');
        // Vérifie si le capteur existe déjà
        $sql_verif = "SELECT idDispo FROM Dispositif WHERE idDispo = '$id'";
        $result = mysqli_query($connexion, $sql_verif);
        if (!$result) {
            echo "Erreur SQL (check capteur) : " . mysqli_error($connexion);
            continue;
        }
        if (mysqli_num_rows($result) == 0) {
            // Insertion dans Dispositif sans nomDispo
            $sql_insert = "INSERT INTO Dispositif (idDispo, typeDispo, idC)
                           VALUES ($id, '$nom', $idc)";
            if (!mysqli_query($connexion, $sql_insert)) {
                echo "Erreur SQL (insert capteur) : " . mysqli_error($connexion);
                continue;
            } else {
                echo "Capteur ajouté : $nom (ID: $id) <br>";
            }
        }
        // Insertion données dans Donnees (après insert capteur)
        $sql_mesure = "INSERT INTO Donnees (idDispo, valeur, dateD)
                       VALUES ('$id', '$valeur', '$date')";
        if (!mysqli_query($connexion, $sql_mesure)) {
            echo "Erreur SQL (insert mesure) : " . mysqli_error($connexion);
        } else {
            echo "Donnée pour $nom (ID:$id)<br>";
        }
        echo "Test : $nom => $valeur <br>";
        // === ALERTES ===
        // Température chambre
        if (stripos($nom, 'TemperatureChambre') !== false) {
            if (preg_match('/([0-9.]+)/', $valeur, $matches)) {
                $temp = (float)$matches[1];
                if ($temp>18) {
                    $message = "Température trop élevée : {$temp}°C";
                    $msg_sql = mysqli_real_escape_string($connexion, $message);
                    $sql = "INSERT INTO Alerte (type, etatA, dateA, idDispo)
                            VALUES ('$msg_sql', 'Non résolue', '$date', $id)";
                    if (!mysqli_query($connexion, $sql)) {
                        echo "Erreur alerte température : " . mysqli_error($connexion) . "\n";
                    } else {
                        echo "Alerte température déclenchée : $message\n";
                    }
                }
                if ($temp<18) {
                    $message = "Température très Basse: {$temp}°C";
                    $msg_sql = mysqli_real_escape_string($connexion, $message);
                    $sql = "INSERT INTO Alerte (type, etatA, dateA, idDispo)
                            VALUES ('$msg_sql', 'Non résolue', '$date', $id)";
                    if (!mysqli_query($connexion, $sql)) {
                        echo "Erreur alerte température : " . mysqli_error($connexion) . "\n";
                    } else {
                        echo "Alerte température déclenchée : $message\n";
                    }
                }
            }
        }
        // Porte ouverte la nuit
        if (stripos($nom, 'Access control') !== false && $valeur ==='On') {
            $heure = (int)date('H');
            if ($heure >= 22 || $heure < 6) {
                $message = "Porte ouverte la nuit à " . date('H:i');
                $msg_sql = mysqli_real_escape_string($connexion, $message);
                $sql = "INSERT INTO Alerte (type, etatA, dateA, idDispo)
                        VALUES ('$msg_sql', 'Non résolue','$date', $id)";
                if (!mysqli_query($connexion, $sql)) {
                    echo "Erreur alerte porte : " . mysqli_error($connexion) . "\n";
                } else {
                    echo "Alerte porte ouverte la nuit enregistrée\n";
                }
            }
        }
        // Appui prolongé
        if (stripos($nom, 'AppuiProlonge') !== false && $valeur === 'On') {
            $message = "Appel d'urgence";
            $msg_sql = mysqli_real_escape_string($connexion, $message);
            $sql = "INSERT INTO Alerte (type, etatA, dateA, idDispo)
                    VALUES ('$msg_sql', 'Non résolue','$date', $id)";
            if (!mysqli_query($connexion, $sql)) {
                echo "Erreur alerte aide : " . mysqli_error($connexion) . "\n";
            } else {
                echo "Alerte aide enregistrée\n";
            }
        }
    }
} else {
    echo "Erreur : Impossible de récupérer les données depuis Domoticz.";
}
mysqli_close($connexion);
?>
