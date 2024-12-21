<?php

function get_user_id($username) {

    $url = "https://forum.neverlose.cc/u/" . urlencode($username) . ".json";
    

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        'Accept: application/json',
        'Accept-Language: en-US,en;q=0.5',
        'Connection: keep-alive'
    ));


    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return "Fail " . curl_error($ch);
    }

    curl_close($ch);

    if ($response === false) {
        return "Fail";
    }

    $data = json_decode($response, true);

    if ($data === null) {
        return "Fail" . htmlspecialchars($response);
    }

    if (isset($data['user_badges']) && is_array($data['user_badges']) && count($data['user_badges']) > 0) {

        $user_id = $data['user_badges'][0]['user_id'];
        return $user_id; 
    } else {
        return "Check Username";
    }
}

$user_id = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $user_id = get_user_id($username);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neverlose UID</title>

    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            color: #fff;
            line-height: 1.6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('https://c.wallhere.com/photos/c3/d1/women_ass_in_bed_black_bras_lying_on_front_back_black_lingerie-268216.jpg!s1'); 
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(10px); 
        }

        .container {
            max-width: 600px;
            width: 100%;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.22);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.16);
            backdrop-filter: blur(10px); 
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 26px;
            color:rgb(189, 189, 189);
        }

        label {
            text-align: center;
            font-size: 18px;
            margin-bottom: 10px;
            display: block;
            color: #f1f1f1;
        }

        input[type="text"] {
            text-align: center;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-color:rgba(66, 66, 66, 0);
            border-radius: 4px;
            background-color: rgba(172, 172, 172, 0.1);
            color: #fff;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color:rgba(0, 0, 0, 0);
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: rgba(43, 43, 43, 0.16); 
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            border-radius: 30px; 
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: rgba(43, 43, 43, 0.43); 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25); 
        }

        .result {
            margin-top: 20px;
            text-align: center;
            opacity: 0; 
            animation: fadeIn 1s forwards; 
        }

        .result p {
            font-size: 17px;
            font-weight: bold;
            color:rgba(255, 255, 255, 0.66); 
        }

        /* Animacja pojawiania się */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }


        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 20px;
            }

            label {
                font-size: 16px;
            }

            input[type="text"] {
                font-size: 14px;
            }

            input[type="submit"] {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Neverlose UID check</h1>
        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <input type="submit" value="Check UID">
        </form>
        
        <?php

        if ($user_id) {
            echo "<div class='result'>"; echo "<p>Username: " . htmlspecialchars($username) . "</p>";
            echo "<p>UID: " . htmlspecialchars($user_id) . "</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
