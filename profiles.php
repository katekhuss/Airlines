<?php
require 'db.php';
$pdo = getPDO();

// Создание индексов
// $createIndexesQueries = [
//     "CREATE INDEX idx_passenger_passenger_id ON passenger (passenger_id);",
//     "CREATE INDEX idx_passenger_firstname ON passenger (firstname);",
//     "CREATE INDEX idx_passenger_lastname ON passenger (lastname);",
//     "CREATE INDEX idx_booking_passenger_id ON booking (passenger_id);",
//     "CREATE INDEX idx_passenger_firstname_lastname ON passenger (firstname, lastname);",
//     "CREATE INDEX idx_booking_passenger_id_booking_id ON booking (passenger_id, booking_id);",
// ];

// try {
//     foreach ($createIndexesQueries as $query) {
//         $stmtCreateIndexes = $pdo->prepare($query);
//         $stmtCreateIndexes->execute();
//     }
// } catch (PDOException $e) {
//     die("Ошибка при создании индексов: " . $e->getMessage());
// }

$sql_passenger_list = "SELECT
    passenger.passenger_id,
    passenger.lastname,
    passenger.firstname,
    COUNT(booking.booking_id) AS booking_count
FROM
    passenger
LEFT JOIN
    booking ON passenger.passenger_id = booking.passenger_id
GROUP BY
    passenger.passenger_id
LIMIT 50";

try {
    $stmt = $pdo->prepare($sql_passenger_list);
    $stmt->execute();
    $result_passenger_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка выполнения запроса: " . $e->getMessage());
}


    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Passenger Profiles</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
        <style>
            body {
                background-color: #121212;
                color: #fff;
                padding-top: 56px;
            }

            th, td {
                border: 1px solid #495057;
                color: #fff;
            }

            th {
                background-color: #212529;
            }

            a {
                color: #007bff;
            }

            a:hover {
                color: #0056b3;
                text-decoration: none;
            }

            .name {
                color: #007bff;
            }
        </style>
    </head>
    <body>
    <div class='container mt-5'>
        <h2>Passenger Profiles</h2>
        <table class='table'>
            <thead>
            <tr>
                <th>#</th>
                <th>Фамилия и имя пассажира</th>
                <th>Количество броней</th>
            </tr>
            </thead>
            <tbody>";

    foreach ($result_passenger_list as $row_passenger) {
        echo "<tr>
                <th scope='row'>{$row_passenger['passenger_id']}</th>
                <td class='name'><a href='profile.php?passenger_id={$row_passenger['passenger_id']}'>{$row_passenger['lastname']} {$row_passenger['firstname']}</a></td>
                <td>{$row_passenger['booking_count']}</td>
            </tr>";
    }

    echo "</tbody>
        </table>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
    </body>
    </html>";

?>