<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #121212;
            color: #fff;
            padding-top: 56px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            margin-top: -20px;
        }

        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #495057;
            color: #fff;
            padding: 8px;
            text-align: left;
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

        .table tr:hover {
            background-color: #343a40;
        }

        .container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php
require 'db.php';
$pdo = getPDO();
if (isset($_GET['passenger_id'])) {
    $passenger_id = $_GET['passenger_id'];

    try {
        // Получаем данные о пассажире
        $stmt_passenger = $pdo->prepare("SELECT * FROM passenger WHERE passenger_id = :passenger_id");
        $stmt_passenger->bindParam(':passenger_id', $passenger_id, PDO::PARAM_INT);
        $stmt_passenger->execute();

        if ($stmt_passenger->rowCount() > 0) {
            $passenger = $stmt_passenger->fetch(PDO::FETCH_ASSOC);

            echo "<div class='container mt-5'>
                    <h2>Passenger Profile</h2>
                    <table class='table'>
                        <tr>
                            <th>Фамилия и имя пассажира</th>
                            <td>{$passenger['lastname']} {$passenger['firstname']}</td>
                        </tr>";

            // Получаем количество броней
            $stmt_booking_count = $pdo->prepare("SELECT COUNT(*) AS booking_count FROM booking WHERE passenger_id = :passenger_id");
            $stmt_booking_count->bindParam(':passenger_id', $passenger_id, PDO::PARAM_INT);
            $stmt_booking_count->execute();

            $booking_count = ($stmt_booking_count->rowCount() > 0) ? $stmt_booking_count->fetch(PDO::FETCH_ASSOC)['booking_count'] : 0;

            echo "<tr>
                    <th>Количество броней</th>
                    <td>{$booking_count}</td>
                </tr>";

            // Получаем статистику по странам
            $stmt_statistics = $pdo->prepare("SELECT
                `passenger`.`passenger_id`,
                `booking`.`flight_id`,
                `flight`.`from` AS `from_airport_id`,
                `flight`.`to` AS `to_airport_id`,
                `airport_from`.`name` AS `from_airport_name`,
                `airport_to`.`name` AS `to_airport_name`
            FROM
                `passenger`
            INNER JOIN
                `booking` ON `passenger`.`passenger_id` = `booking`.`passenger_id`
            INNER JOIN
                `flight` ON `booking`.`flight_id` = `flight`.`flight_id`
            INNER JOIN
                `airport` AS `airport_from` ON `flight`.`from` = `airport_from`.`airport_id`
            INNER JOIN
                `airport` AS `airport_to` ON `flight`.`to` = `airport_to`.`airport_id`
            WHERE `passenger`.`passenger_id` = :passenger_id");

            $stmt_statistics->bindParam(':passenger_id', $passenger_id, PDO::PARAM_INT);
            $stmt_statistics->execute();

            echo "<tr>
                    <th colspan='2' class='text-center'>Статистика по странам</th>
                </tr>
                <tr>
                    <th>Страна (Прилеты)</th>
                    <th>Страна (Вылеты)</th>
                </tr>";

            while ($row_statistics = $stmt_statistics->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row_statistics['from_airport_name']}</td>
                        <td>{$row_statistics['to_airport_name']}</td>
                    </tr>";
            }

            echo "</table></div>";
        } else {
            echo "Пассажир не найден.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "Неверные параметры запроса.";
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
