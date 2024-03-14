<?php
require 'db.php';
$pdo = getPDO();

$sql_select = 'SELECT 
        `booking`.`price`,
        `booking`.`seat`,
        `passenger`.*,
        `flight`.`departure`,
        `flight`.`arrival`,
        `airport_from`.`iata`,
        `airport_from`.`name`,
        `airport_to`.`iata`,
        `airport_to`.`name`,
        `geo_from`.`country` AS `country_from`,
        `geo_from`.`city` AS `city_from`,
        `geo_to`.`country` AS `country_to`,
        `geo_to`.`city` AS `city_to`
        FROM
            `booking`
        INNER JOIN
            `passenger`
            ON `booking`.`passenger_id` = `passenger`.`passenger_id`
        INNER JOIN
            `flight`
            ON `booking`.`flight_id` = `flight`.`flight_id`
        INNER JOIN
            `airport` AS `airport_from`
            ON `airport_from`.`airport_id` = `flight`.`from`
        INNER JOIN
            `airport` AS `airport_to`
            ON `airport_to`.`airport_id` = `flight`.`to`
        INNER JOIN `airport_geo` AS `geo_from`
            ON `geo_from`.`airport_id` = `airport_from`.`airport_id`
        INNER JOIN `airport_geo` AS `geo_to`
            ON `geo_to`.`airport_id` = `airport_to`.`airport_id`
        LIMIT 50';

try {
    $stmt = $pdo->prepare($sql_select);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Booking</title>
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
    <table class='table'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Фамилия и имя</th>
                <th scope='col'>Номер паспорта</th>
                <th scope='col'>Направление перелета</th>
                <th scope='col'>Цена</th>
            </tr>
        </thead>
        <tbody>";

    foreach ($result as $row) {
        echo "<tr>
                <th scope='row'>{$row['passenger_id']}</th>
                <td class='name'><a href='profile.php?passenger_id={$row['passenger_id']}'>{$row['lastname']} {$row['firstname']}</a></td>
                <td>{$row['passportno']}</td>
                <td>{$row['country_from']}(<a href='cityfromfilter.php?city_from=" . urlencode($row['city_from']) . "&city_to=" . urlencode($row['city_to']) . "'>{$row['city_from']}</a>) - {$row['country_to']}(<a href='citytofilter.php?city_from=" . urlencode($row['city_to']) . "&city_to=" . urlencode($row['city_to']) . "'>{$row['city_to']}</a>)</td>
                <td>{$row['price']}</td>
            </tr>";
    }

    echo "</tbody>
    </table>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
    </body>
    </html>";

} catch (PDOException $e) {
    die("Ошибка выполнения запроса: " . $e->getMessage());
}
?>
