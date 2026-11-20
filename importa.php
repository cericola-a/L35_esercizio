
<?php

include 'Connection.php';

// Connessione al database
$conn = new Connection('l35_pizzeria', 'pizzeria', 'pizzeria');
$db = $conn->getConnection();

// Apertura del file CSV
$file = __DIR__ . '/listino.csv';
$aperturaFile = fopen($file, 'r');

// Salto l'intestazione
$intestazione = fgetcsv($aperturaFile, 0, ",", '"', "");

// Preparo la query
$sql = "INSERT IGNORE INTO pizze (codice, gusto, prezzo)
        VALUES (:codice, :gusto, :prezzo)";

$query = $db->prepare($sql);

// Collego i parametri
$query->bindParam(':codice', $codice);
$query->bindParam(':gusto', $gusto);
$query->bindParam(':prezzo', $prezzo);

// Inizializzo gli errori
$errori = [];
$numeroRiga = 1;
$importate = 0;

while (($riga = fgetcsv($aperturaFile, 0, ",", '"', "")) !== false) {

    $numeroRiga++;

    // Controllo che i dati siano validi
    if (
        count($riga) !== 3 ||
        trim($riga[0]) === '' ||
        trim($riga[1]) === '' ||
        !is_numeric($riga[2]) ||
        (float)$riga[2] <= 0
    ) {

        $errori[] = "Riga $numeroRiga: dati mancanti o non validi";
        continue;
    }

    // Assegno i valori
    $codice = $riga[0];
    $gusto = $riga[1];
    $prezzo = $riga[2];

    // Eseguo l'inserimento
    $query->execute();

    // Controllo se il record è stato inserito
    $importate += $query->rowCount();

}

// Chiudo il file
fclose($aperturaFile);

?>

<h2>Risultato importazione</h2>

<p>Numero di pizze importate: <?= $importate ?></p>

<?php if (!empty($errori)): ?>

    <h3>Attenzione: alcuni dati non sono validi</h3>

    <ul>
        <?php foreach ($errori as $e): ?>
            <li><?=$e?></li>
        <?php endforeach; ?>
    </ul>

<?php else: ?>

    <p>Tutti i dati sono stati importati correttamente!</p>

<?php endif; ?>
