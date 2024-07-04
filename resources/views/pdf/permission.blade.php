<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PDF - Permission</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 40px;
            text-align: center;
            line-height: 20px;
            font-size: 10px;
            /** Extra personal styles
              background-color: #0b395b;
              color: white;
              
              line-height: 35px; **/
        }
    </style>
</head>

<body onload="print();">
    <div style="display: flex; justify-content:space-between; width: 100%; margin-bottom:5rem">
        <div style="width: 45%;">
            <span>
                <h5>
                    DEMANDE DE PERMISSION - AKASI INTRANET <br><br><br>
                </h5>
            </span>
        </div>

        <div>
            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="akasigroup"
                style="float:right; width: 300px"><br>
            {{-- <div style="float:right; ">
                <i>
                    <center>Leading the digital generation & global business agility et des nations</center>
                </i>
            </div> --}}
        </div>
    </div>

    <p style="float:right">Cotonou, le <?= date('d/m/Y') ?></p>

    <div>
        <p>{{ $permission->user->firstname }} {{ $permission->user->firstname }}</p>
        {{--         <p>Email : {{ $permission->user->email }} </p> --}}<br><br>

        <p><span style="text-decoration: underline;">Objet</span> : {{ $permission->object }}</p> <br /><br />

        <p>
            <strong>
                Monsieur le Directeur Général de Akasi Group,
            </strong>
        </p>

        {{-- 			<p><b>{{ $packages->nature }}</b></p>
--}}
        <p>
            Je viens par la présente note vous faire une demande de permission.
        </p>

        <p>
            {{-- Les raisons de la demande sont les suivantes : --}} En effet, <span style="text-transform: lowercase">{{ $permission->reasons }}</span>
        </p>

        <p>
            Cette demande durera {{ $permission->duration }} à compter du
            {{ \Carbon\Carbon::parse($permission->starting_date)->format('d/m/Y') }} au
            {{ \Carbon\Carbon::parse($permission->ending_date)->format('d/m/Y') }} .
        </p>


        {{--         <p style="float: right;">Operation Manager</p><br>
 --}}

{{--         <p>Monsieur le Directeur Général<br>De AKASI CONSULTING GROUP</p>
 --}}


        {{-- <p style="text-align:center; font-size:10px; margin-top: 30%;">
            Rue du College Gaza - Agla 72 - B.P. 242 Cotonou Republique du Benin www.akasigroup.net Email:
            akasi-admin@akasigroup.com <br />
            Tel : +1 603 852 79 35; +229 67 08 24 29; +225 59 26 40 41; +228 97 78 41 28 +250 78 50 22 308
        </p> --}}


    </div>
    <footer>
        <p style="text-align:center; font-size:10px;">
            <hr style="width:40%" />
            Rue de l'Église Ste Rita - B.P. 242 Cotonou Republique du Benin www.akasigroup.net Email:
            akasi-admin@akasigroup.com <br />
            Tel : +1 603 852 79 35; +229 67 08 24 29; +225 59 26 40 41; +228 97 78 41 28 +250 78 50 22 308
        </p>
    </footer>

</body>

</html>
