<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Email - Rapport</title>

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
            color: #343a40;
        }

        .mail-container {
            min-height: 100vh;
            padding: 20px;
        }

        .b-container {
            margin: 0 auto !important;
            max-width: 1170px;
            padding-left: 15px;
            padding-right: 15px;
        }
    </style>
</head>

<body class="antialiased">
    <div class="b-container">
        <div class="mail-container">
            <div class="mail-title">
                <p>
                    Vous aviez reçu un nouveau rapport hebdomadaire de la part de 
                    <span class="author">
                        {{ $report->user->firstname }} {{ $report->user->lastname }}
                    </span>
                </p>
            </div>
            <div class="mail-content">
                <p>Ci joint le contenu du rapport</p>
               
               {{--  <p>
                    Les raisons de la demande sont : {{ $permission->reasons }}
                </p>
                <p>
                    La permission durera {{ $permission->duration }} du {{ $permission->starting_date }} au
                    {{ $permission->ending_date }}.
                </p> --}}
            </div>
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
