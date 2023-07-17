<?php
require 'db-connect.php';

// Check if the table exists, create it if not
$tableName = "feedback";
$checkTableQuery = "SHOW TABLES LIKE '$tableName'";
$tableExists = mysqli_query($conn, $checkTableQuery);

if ($tableExists->num_rows === 0) {
    // Create the table
    $createTableQuery = "CREATE TABLE `$tableName` (
        `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255),
        `email` VARCHAR(255),
        `subject` VARCHAR(255),
        `feedback` TEXT,
        `rate` INT(11)
    )";

    mysqli_query($conn, $createTableQuery);
}

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $feedback = $_POST["feedback"];
    $rate = $_POST["rate"];

    $query = "INSERT INTO `$tableName` (`name`, `email`, `subject`, `feedback`, `rate`) VALUES ('$name','$email','$subject','$feedback','$rate')";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        #background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            pointer-events: none;
            opacity: 0.8;
        }

        .main {
            position: relative;
            z-index: 1;
            overflow-y: scroll;
            height: 100vh;
            padding: 20px;
        }
        .rate {
            display: inline-block;
            width: 97%;
            outline: none;
            color: #fce205;
            margin:auto;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 65px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>
    <script>
        function democonfirm() {
            if (confirm("Are you Sure you want to Submit this Form??")) {
                alert("you have chosen the Yes option, press OK to submit the form.");
            } else {
                alert("you have chosen the No option, press OK to check the form.");
            }
        }
    </script>
</head>

<body>
    <video id="background-video" src="video.mp4" autoplay loop muted></video>
    <main class="main">
        <div class="container">
            <section class="wrapper">
                <div class="heading">
                    <h1 class="text text-large">Feedback Form</h1>
                </div>
                <form id="form" action="" method="post" name="feedback" class="form">
                    <div class="input-control">
                        <label for="name" class="input-label" hidden>Name</label>
                        <input name="name" type="text" id="name" class="input-field" placeholder="Name">
                    </div>
                    <div class="input-control">
                        <label for="email" class="input-label" hidden>Email Address</label>
                        <input name="email" type="email" id="email" class="input-field" placeholder="Email Address">
                    </div>
                    <div class="input-control">
                        <label for="issue" class="input-label" hidden>Issue</label>
                        <input name="subject" type="text" id="designation" class="input-field" placeholder="Issue">
                    </div>
                    <div class="input-control">
                        <label for="msg" class="input-label" hidden>Message</label>
                        <textarea name="feedback" id="feedback" class="input-field" rows="4" placeholder="Message"></textarea>
                    </div>
                    <div class="method">
                        <div class="method-control">
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" required>
                                <label for="star5" title="5 stars">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4" required>
                                <label for="star4" title="4 stars">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" required>
                                <label for="star3" title="3 stars">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" required>
                                <label for="star2" title="2 stars">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" required>
                                <label for="star1" title="1 star">1 star</label>
                            </div>
                        </div>
                        <div class="method-control">
                            <input type="submit" name="submit" value="Submit" class="method-action btn btn-brand" onclick="democonfirm()">
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
