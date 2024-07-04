<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pdf - Rapport</title>

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
            line-height: 25px;
        }

        .page-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .b-container {
            margin: 0 auto !important;
            max-width: 595px;
        }

        .pdf-nav {
            display: flex;
            align-items: center;
            height: 70px;
            /*             border-bottom: 1px solid black;
 */
        }

        .pdf-nav .b-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .nav-wrapper .img {
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .nav-wrapper .img img {
            height: 50px !important;
            width: 100% !important;
            object-fit: contain;
            display: flex;
            align-items: center;
        }




        .doc-title {
            width: 50%;
            text-align: right;
            height: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .doc-title h3 {
            height: 100%;
            display: flex;
            align-items: center;
        }

        main {
            min-height: calc(100vh - (70px + 62px));
        }

        .pdf-content {
            /*             background-color: #f4f6f9;
 */
            padding: 20px 30px 0px 30px;
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

        .desc-ctn .desc{
            font-size: 18px;
        }

        .author h2 {
            text-align: center;
            color: #006696 !important;
            margin-bottom: 25px;
        }

        .author .user {
            color: #006696 !important;
        }

        .author .date {
            color: #ff0000;
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

        .footer {
            /*
            width:100%;
            display: flex;
            justify-content: center;
            align-items: center; */
            /*             border-top: 1px solid #000;
 */
            font-weight: bold;
            padding: 20px 0;
            text-align: center;
        }

        .footer div {}



        .footer .name {
            color: #006696;
        }

        .footer .group {
            color: #ff0000;
        }
    </style>
</head>

<body class="antialiased">
    <div class="page-container">
        <header class="pdf-nav">
            <div class="b-container">
                <div class="nav-wrapper">
                    <div class="img">
                        <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="akasigroup">
                    </div>
                    <div class="doc-title">

                        <h3> Weekly report</h3>
                    </div>
                </div>
            </div>
        </header>
        <main class="pdf-content">
            <div class="b-container">
                <div class="author">
                    <h2> Rapport hebdommadaire</h2>

                    <div class="desc-ctn">
                        <div class="title">
                            Du :
                        </div>
                        <div class="desc">02 - Octobre - 2022</div>
                    </div>
                    <div class="desc-ctn">
                        <div class="title">
                            De :
                        </div>
                        <div class="desc">Tester Testing</div>
                    </div>
                    {{-- 
                    <h2> Weekly Report - <span class="user">Tester Test</span> - <span
                            class="date">02/02/2022</span></h2> --}}
                </div>
                <div class="reports">
                    <div class="content-section">
                        <div class="content-title">
                            A-) Objectifs de la semaine
                        </div>
                        <div class="contents">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere animi ratione, voluptatum
                            necessitatibus error optio illo iusto quod velit, at voluptates rem, laudantium vitae ex
                            temporibus provident adipisci suscipit beatae possimus placeat! Tempore, voluptate dolores
                            velit nobis sed harum dicta itaque similique temporibus, voluptatem enim animi ea
                            consequatur! Sapiente vero magnam iusto suscipit. Adipisci, cumque autem blanditiis enim
                            suscipit quis aperiam libero unde quia molestias, commodi et. Eveniet nulla id dignissimos
                            ex quasi earum placeat. Vero praesentium deleniti, sapiente quae quas magnam assumenda ipsum
                            inventore tempore ea! Quidem, expedita quasi ad voluptate repellendus deleniti rerum libero,
                            voluptatem, recusandae facere suscipit!
                        </div>
                    </div>
                    <div class="content-section">
                        <div class="content-title">
                            B-) Travaux réalisés
                        </div>
                        <div class="contents">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere animi ratione, voluptatum
                            necessitatibus error optio illo iusto quod velit, at voluptates rem, laudantium vitae ex
                            temporibus provident adipisci suscipit beatae possimus placeat! Tempore, voluptate dolores
                            velit nobis sed harum dicta itaque similique temporibus, voluptatem enim animi ea
                            consequatur! Sapiente vero magnam iusto suscipit. Adipisci, cumque autem blanditiis enim
                            suscipit quis aperiam libero unde quia molestias, commodi et. Eveniet nulla id dignissimos
                            ex quasi earum placeat. Vero praesentium deleniti, sapiente quae quas magnam assumenda ipsum
                            inventore tempore ea! Quidem, expedita quasi ad voluptate repellendus deleniti rerum libero,
                            voluptatem, recusandae facere suscipit!
                        </div>
                    </div>
                    <div class="content-section">
                        <div class="content-title">
                            C-) Problèmes à signaler et commentaires généraux
                        </div>
                        <div class="contents">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere animi ratione, voluptatum
                            necessitatibus error optio illo iusto quod velit, at voluptates rem, laudantium vitae ex
                            temporibus provident adipisci suscipit beatae possimus placeat! Tempore, voluptate dolores
                            velit nobis sed harum dicta itaque similique temporibus, voluptatem enim animi ea
                            consequatur! Sapiente vero magnam iusto suscipit. Adipisci, cumque autem blanditiis enim
                            suscipit quis aperiam libero unde quia molestias, commodi et. Eveniet nulla id dignissimos
                            ex quasi earum placeat. Vero praesentium deleniti, sapiente quae quas magnam assumenda ipsum
                            inventore tempore ea! Quidem, expedita quasi ad voluptate repellendus deleniti rerum libero,
                            voluptatem, recusandae facere suscipit!
                        </div>
                    </div>
                    <div class="content-section">
                        <div class="content-title">
                            D-) Focus de la semaine suivante
                        </div>
                        <div class="contents">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere animi ratione, voluptatum
                            necessitatibus error optio illo iusto quod velit, at voluptates rem, laudantium vitae ex
                            temporibus provident adipisci suscipit beatae possimus placeat! Tempore, voluptate dolores
                            velit nobis sed harum dicta itaque similique temporibus, voluptatem enim animi ea
                            consequatur! Sapiente vero magnam iusto suscipit. Adipisci, cumque autem blanditiis enim
                            suscipit quis aperiam libero unde quia molestias, commodi et. Eveniet nulla id dignissimos
                            ex quasi earum placeat. Vero praesentium deleniti, sapiente quae quas magnam assumenda ipsum
                            inventore tempore ea! Quidem, expedita quasi ad voluptate repellendus deleniti rerum libero,
                            voluptatem, recusandae facere suscipit!
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer">
            <div class="b-container">

                <div>
                    Rue du College Gaza, Agla 72 BP 242 Cotonou Republique du Benin , Cotonou, Benin &copy; <span
                        class="name">AKASI</span> <span class="group">GROUP</span>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
