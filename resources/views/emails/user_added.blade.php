<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Email - User</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
        }

        * {
            padding: 0;
            margin: 0;
            position: relative;
            box-sizing: border-box;
            box-sizing: border-box;
            color: #343a40;
            /*
            font-size: 18px;
            font-family: Verdana, Geneva, Tahoma, sans-serif; */
        }

        .mail-container {
            min-height: 100vh;
            padding: 20px;
        }

        .b-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .author {
            font-weight: bold;
        }
    </style>
</head>

<body class="antialiased">
    <div class="b-container">
        <div class="mail-container">
            <div class="mail-title">
                <div>
                    Bonjour <span class="author">
                        {{ $user->firstname }} {{ $user->lastname }},
                    </span>
                    un compte vient d'être créé en votre nom sur AKASI INTRANET.
                    <p>
                        Ci-dessous vos identifiants de
                        connexion.
                    </p>
                </div>
                <div>
                    <span class="author"> Email :</span> {{ $user->email }}
                </div>
                <div>
                    <span class="author"> Mot de passe :</span> {{ $password }}
                </div>
            </div>
            <div class="mail-content">
                <div>
                    
                    --
                    <p>

                        Cordialement, <br>
                        Akasi Intranet.
                    </p>
                </div>
            </div>
        </div>
</body>

</html>
