<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание рейсов</title>
    <style>
        body {
            background-color: #121212;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .weekday {
            background-color: #3498db;
            color: white;
        }

        form {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }

        label {
            margin-right: 10px;
        }

        input[type="text"] {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <table>
    <?php

    require 'db.php';
    $pdo = getPDO();
    // Получаем значения из URL
    $from_city = urldecode($_GET['city_from']);
    $to_city = urldecode($_GET['city_to']);

    // Подготавливаем SQL-запрос
    $sql_schedule = "SELECT 
        `flightno`,
        `airport_from`.`iata`,
        `airport_from`.`name`,
        `airport_to`.`iata`,
        `airport_to`.`name`,
        `geo_from`.`country` AS `country_from`,
        `geo_from`.`city` AS `city_from`,
        `geo_to`.`country` AS `country_to`,
        `geo_to`.`city` AS `city_to`,
        `monday`,
        `tuesday`,
        `wednesday`,
        `thursday`,
        `friday`,
        `saturday`,
        `sunday`
    FROM 
        `flightschedule`
    INNER JOIN
        `airport` AS `airport_from` ON `flightschedule`.`from` = `airport_from`.`airport_id`
    INNER JOIN
        `airport` AS `airport_to` ON `flightschedule`.`to` = `airport_to`.`airport_id`
    INNER JOIN `airport_geo` AS `geo_from`
        ON `geo_from`.`airport_id` = `airport_from`.`airport_id`
    INNER JOIN `airport_geo` AS `geo_to`
        ON `geo_to`.`airport_id` = `airport_to`.`airport_id`
    WHERE `geo_to`.`city` = :to_city
    ORDER BY `flightno` ASC
    LIMIT 10";

    try {
        $stmt = $pdo->prepare($sql_schedule);
        $stmt->bindParam(':to_city', $to_city, PDO::PARAM_STR);
        $stmt->execute();
        $result_schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>
            <tr>
                <th>Номер рейса</th>
                <th>Направление перелета</th>
                <th>Пн</th>
                <th>Вт</th>
                <th>Ср</th>
                <th>Чт</th>
                <th>Пт</th>
                <th>Сб</th>
                <th>Вс</th>
            </tr>";

        foreach ($result_schedule as $row_schedule) {
            echo "<tr>
                <td>{$row_schedule['flightno']}</td>
                <td>{$row_schedule['country_from']} ({$row_schedule['city_from']}) - {$row_schedule['country_to']} ({$row_schedule['city_to']})</td>";

            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            foreach ($days as $day) {
                echo "<td class='" . ($row_schedule[$day] ? 'weekday' : '') . "'></td>";
            }

            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        die("Ошибка выполнения запроса: " . $e->getMessage());
    }
    ?>
     </table>
</div>

</body>
</html>
