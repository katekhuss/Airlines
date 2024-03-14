<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Airlines</title>
    <style>
        body {
            background-color: #121212;
            color: #FFFFFF; 
        }

        header {
            background-color: #343A40;
        }

        .nav-link {
            color: #FFFFFF;
        }
        
    </style>
</head>
<body>
    <header>
        <div class="px-3 py-2 text-dark border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    <li>
                            <a href="#" class="nav-link">
                                <img src="airplane.png" alt="Home" class="d-block mx-auto mb-1" width="24" height="24">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="schedule.php" class="nav-link">
                                <img src="schedule.png" alt="Schedule" class="d-block mx-auto mb-1" width="24" height="24">
                                Schedule
                            </a>
                        </li>
                        <li>
                            <a href="profiles.php" class="nav-link">
                                <img src="profiles.png" alt="Profiles" class="d-block mx-auto mb-1" width="24" height="24">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="booking.php" class="nav-link">
                                <img src="booking.png" alt="Booking" class="d-block mx-auto mb-1" width="24" height="24">
                                Booking
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>