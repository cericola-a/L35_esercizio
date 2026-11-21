<?php


include 'Connection.php';

// Connessione al database
$conn = new Connection('l35_pizzeria', 'pizzeria', 'pizzeria');
$db = $conn->getConnection();

// Preparo la query
$sql = "SELECT * FROM pizze";

$query = $db->prepare($sql);

// Eseguo la query
$query->execute();

// Recupero tutti i risultati
$pizze = $query->fetchAll();

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Listino Pizzeria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <h1 class="fw-bold text-center">Menu Pizzeria</h1>
    <p class="text-secondary text-center">Il nostro listino pizze</p>

    <table class="table table-striped  table-bordered align-middle mb-0">

        <thead class="table-dark">
            <tr>
                <th>Codice</th>
                <th>Gusto</th>
                <th>Prezzo</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($pizze as $p): ?>

                <tr>
                    <td><?= $p['codice'] ?></td>
                    <td><?= $p['gusto'] ?></td>
                    <td><?= $p['prezzo'] ?> €</td>
                </tr>

            <?php endforeach; ?>

        </tbody>


    </table>


    <div class="card-footer text-secondary">
        Totale pizze: <?= count($pizze) ?>
    </div>

    



</body>

</html>