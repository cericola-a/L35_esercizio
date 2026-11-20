
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

<div class="container py-5">

    <div class="text-center mb-4">
        <h1 class="fw-bold">Menu Pizzeria</h1>
        <p class="text-secondary">Il nostro listino pizze</p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Elenco pizze</h5>
        </div>

        <div class="card-body">

            <div>

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

            </div>

        </div>

        <div class="card-footer text-secondary">
            Totale pizze: <?= count($pizze) ?>
        </div>

    </div>

</div>

</body>
</html>
