<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PDF - RAPPORT</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>

        /* *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            position: relative;
        }

        body{
            overflow-x: hidden;
            padding:0 ;
            width: 100%;
        } */
        body{
            padding:0 25px;
        }

        li{
            margin: 10px 0;
        }
        .logo-img {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            /*height: 45px;*/
            width: 100%;
            margin-bottom: 5px;
            border-bottom: 2px solid #000;
            padding: 15px 0;
        }

        .logo-img img {
            width: 30%;
            object-fit: contain;
            height: auto;
        }

        h4 {
            text-align: center;
            margin: 0;
            margin-bottom: 10px;
            padding: 0;
            margin-top: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h4 strong {
            text-decoration: underline;
            padding-right: 7px;
        }

        h4 span {
            /*font-size: 18px !important;*/
        }

        .author h2 {
            text-align: center;
            color: #006696 !important;
            margin-bottom: 25px;
        }

        .desc-ctn {
            display: flex;
            align-items: center;
            margin-bottom: 10px;

        }

        .desc-ctn .title {
            font-size: 18px;
            font-weight: bold;
            margin-right: 20px;
        }

        .desc-ctn .desc {
            font-size: 18px;
        }

        .reports {
            padding: 40px 0;
        }

        .content-section {
            margin-top: 20px;
        }

        .content-title {
            text-transform: uppercase;
            color: #10325c;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .contents {
            text-align: justify;
        }

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

<body {{-- onload="print();" --}}>
    <div class="logo-img">
        <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="akasigroup">
    </div>
    <div>
        <h4>
            <strong class="title">
                RAPPORT HEBDOMADAIRE :
            </strong>
            <span class="desc">
                {{ strtoupper($report->user->firstname) }} {{ strtoupper($report->user->lastname) }}
            </span>
        </h4>
        <div style="text-align: center">
            Semaine du <span class="desc"> {{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y') }}</span>
        </div>
    </div>


    <div class="pdf-content">
        <div class="b-container">
            <div class="author">
                {{-- 
                <div class="desc-ctn">
                    <strong class="title">
                        De :
                    </strong>
                    <span class="desc">
                        {{ strtoupper($report->user->firstname) }} {{ strtoupper($report->user->lastname) }}
                    </span>
                </div> --}}
                {{-- 
                    <h2> Weekly Report - <span class="user">Tester Test</span> - <span
                            class="date">02/02/2022</span></h2> --}}
            </div>
            <div class="reports">
                <div class="content-section">
                    <div class="content-title">
                        A) Objectifs fixés pour la semaine
                    </div>
                    <div class="contents">
                        <ul>
                            @foreach ($report->goals as $goal)
                                <li>{{ $goal }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="content-section">
                    <div class="content-title">
                        B) Travaux réalisés
                    </div>
                    <div class="contents">
                        <ul>
                            @foreach ($report->achievements as $achievement)
                                <li>{{ $achievement }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="content-section">
                    <div class="content-title">
                        C) Problèmes à signaler et commentaires généraux
                    </div>
                    <div class="contents">
                        <ul>
                            @foreach ($report->observations as $observation)
                                <li>{{ $observation }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="content-section">
                    <div class="content-title">
                        D) Focus de la semaine suivante
                    </div>
                    <div class="contents">
                        <ul>
                            @foreach ($report->next_goals as $next_goal)
                                <li>{{ $next_goal }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
