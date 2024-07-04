<!DOCTYPE html>
<html>

<head>
    <title>MEMORANDUM - Demande de Service
    </title>

    <style>
        /** Define the margins of your pdf page **/
        @page {
            margin: 100px 25px;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;

            /** Extra personal styles
                  background-color: #0b395b;
                  color: white;
                  text-align: center;
                  line-height: 35px; **/
        }

        footer {
            position: fixed;
            bottom: -60px;
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

<body>
    <div class="row" style="padding-left:50px; width:90%;">

        <table>
            <tr>
                <td style="text-align:center;">
                    <p>
                    <h1>
                        DEMANDE DE PERMISSION - AKASI INTRANET
                    </h1>
                    </p>

                    {{-- <p>
                        Demande de Service : {{ $permission->id }} - {{ $permission->id }}
                    </p>
                    <p>
                    </p> --}}
                </td>
                <td>
                    <div class="text-center mt-6">
                        <img class="img-pnud" src="{{ Vite::asset('resources/images/logo.png') }}" alt="akasigroup"
                            style="width: 300px">
                    </div>
                </td>
            </tr>


            <tr>
                <td style="text-align:justify;">
                    <table>
                        <tr>
                            <td>
                                <strong> De : </strong>
                            </td>
                            <td>
                                {{ $permission->user->firstname }}
                                <br />
                                {{ $permission->user->firstname }} <br />
                                {{ $permission->user->title }} <br />
                                {{ $permission->user->email }}
                            </td>
                        </tr>

                    </table>

                </td>

                <td>
                    <p style="text-align:right;">
                        Date : {{ \Carbon\Carbon::parse($permission->created_at)->format('d/m/Y') }} au
                         </p>
                </td>
            </tr>


            <tr>
                <td style="text-align:justify;">
                    <p><br /></p>

                    <p>
                        <strong><u>Objet</u></strong>: {{ $permission->object }}
                    </p>
                    <p><br /></p>
                    <p>
                        <strong>
                            Monsieur le Directeur Général De AKASI CONSULTING GROUP,
                        </strong>
                    </p>

                    <p>
                        Je viens par la présente note vous faire une demande de permission.
                    </p>

                    <p>
                        {{-- Les raisons de la demande sont les suivantes : --}} En effet, <span
                            style="text-transform: lowercase">{{ $permission->reasons }}</span>
                    </p>

                    <p>
                        Cette demande durera {{ $permission->duration }} à compter du
                        {{ \Carbon\Carbon::parse($permission->starting_date)->format('d/m/Y') }} au
                        {{ \Carbon\Carbon::parse($permission->ending_date)->format('d/m/Y') }} .
                    </p>


                    {{--         <p style="float: right;">Operation Manager</p><br>
             --}}

                    <p>Monsieur le Directeur Général<br>De AKASI CONSULTING GROUP</p>


                    <p style="text-align:justify; font-size:13px;"><?php echo $permission->id; ?></p>
                </td>

                <td>
                    &nbsp;
                </td>
            </tr>


        </table>

        <footer>
            <p style="text-align:center; font-size:10px;">
                <hr style="width:40%" />
                Rue du College Gaza - Agla 72 - B.P. 242 Cotonou Republique du Benin www.akasigroup.net Email:
                akasi-admin@akasigroup.com <br />
                Tel : +1 603 852 79 35; +229 67 08 24 29; +225 59 26 40 41; +228 97 78 41 28 +250 78 50 22 308
            </p>
        </footer>

</body>

</html>
