<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>blast_result_screen</title>
    <link rel="stylesheet" href="/css/Common_header.css">
</head>

<body>
    <header>
        <div class="header-inner">
            <div class="Logo">Barcode DB</div>
            <div class="header-item">
                <nav class="nav1">
                    <ul>
                        <li><a href="/"> Top </a></li>
                        <li><a href="./download">DownLoad</a></li>
                        <li><a href="./taxonomy">Taxonomy</a></li>
                        <li><a href="./help"> Help </a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="hpad"></div>
    <div class="content_wrap">
        <div class="content_main">
            <div class="s_wrap">
                <div class="second_wrap">
                    <div class="top_info">
                        <h2 class="h2_1">Top Hit</h2>
                        <table id="accordion" class="topul">
                            <tbody>
                                <tr id="top_bar" class="topulel">
                                    <th>TaxonomyID</th>
                                    <th>species</th>
                                    <th>genus</th>
                                    <th>family</th>
                                    <th>phylum</th>
                                </tr>
                                <tr id="lineheight" class="topulel adjust">
                                    <td><a href="https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id={{$blastLineArray['topRef']['TAXID']}}">
                                            {{$blastLineArray['topRef']['TAXID']}}
                                        </a>
                                    </td>
                                    <td>{{$blastLineArray['topRef']['SPECIES']}}</td>
                                    <td>{{$blastLineArray['topRef']['GENUS']}}</td>
                                    <td>{{$blastLineArray['topRef']['FAMILY']}}</td>
                                    <td>{{$blastLineArray['topRef']['PHYLUM']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h2 class="h2_2">Distribution of your Query against the DB</h2>
                    <div class="svg_wrap">
                        <table class="query_info">
                            <caption>Query infomation</caption>
                            <tbody>
                                <tr>
                                    <th>QueryID</th>
                                    <td>{{$blastLineArray['QueryID']}}</td>
                                </tr>
                                <tr>
                                    <th>MAX <br> Aligned length</th>
                                    <td>{{$blastLineArray['objArrayIn'][0]['ALEN']}} /bases</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="s_info">
                            <ul class="s_ul">
                                <li>Scale</li>
                                <li>Reference</li>
                                <li>Aligned length</li>
                            </ul>
                        </div><svg xmlns="http://www.w3.org/2000/svg" height="150px"><text x="21%" y="13%"
                                fill="#148c81" font-size="15" font-weight="bold" class="mmr">250bp</text><text x="46%"
                                y="13%" fill="#148c81" font-size="15" font-weight="bold" class="mmr">500bp</text><text
                                x="71%" y="13%" fill="#148c81" font-size="15" font-weight="bold"
                                class="mmr">750bp</text>
                            <line x1="0%" y1="20%" x2="100%" y2="20%" class="sca_1"></line>
                            <line x1="0%" y1="50%" x2="100%" y2="50%" class="len_db"></line>
                            <line x1="0%" y1="17%" x2="0%" y2="23%" class="edge"></line>
                            <line x1="25%" y1="17%" x2="25%" y2="90%" class="scale"></line>
                            <line x1="50%" y1="17%" x2="50%" y2="90%" class="scale"></line>
                            <line x1="75%" y1="17%" x2="75%" y2="90%" class="scale"></line>
                            <line x1="100%" y1="17%" x2="100%" y2="23%" class="edge"></line>
                            <line x1="{{$blastLineArray['perIdent']['RSTART']}}%" y1="80%" x2="{{$blastLineArray['perIdent']['REND']}}%" y2="80%" class="len_qr"></line>
                        </svg>
                    </div>
                </div>
            </div>
            <h2 class="h2_3">Blast Result List</h2>
            <div class="table_wrap">
                <table class="blast_result">
                    <tbody>
                        <tr>
                            <th>Subject_ID</th>
                            <th>species</th>
                            <th>Identity<br>(%)</th>
                            <th>aligned<br>length</th>
                            <th>Mis<br>mathes</th>
                            <th>Gap<br>openings</th>
                            <th>Query<br>start</th>
                            <th>Query<br>end</th>
                            <th>Subject<br>start</th>
                            <th>Subject<br>end</th>
                            <th>E-value</th>
                            <th>Bit<br>score</th>
                        </tr>
                        @foreach($blastLineArray['objArrayIn'] as $item)
                        <tr>
                            <td><a href="{{$item['URL']}}">{{$item['REF']}}</a></td>
                            <td>{{$item['SPE']}}</td>
                            <td>{{$item['IDEN']}}</td>
                            <td>{{$item['ALEN']}}</td>
                            <td>{{$item['MM']}}</td>
                            <td>{{$item['GA']}}</td>
                            <td>{{$item['QS']}}</td>
                            <td>{{$item['QE']}}</td>
                            <td>{{$item['RS']}}</td>
                            <td>{{$item['RE']}}</td>
                            <td>{{$item['EV']}}</td>
                            <td>{{$item['BS']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style type="text/css">
        <!--
        .hpad {
            padding: 51px;
        }

        .second_wrap {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            padding: 30px;
            padding-top: 10px;
        }

        .svg_wrap {
            display: flex;
            justify-content: flex-start;
            padding: 0 15px;
            align-items: center;
            margin: 5px 0;
            border: 2px solid #607d8b;
            background-color: aliceblue;
            border-radius: 10px;
        }

        .query_info {
            font-weight: bold;
            width: 350px;
            margin-bottom: 10px;
            padding: 10px;
            color: #374952;
        }

        .s_info {
            display: inline-block;
            margin-left: auto;
        }

        .s_info li {
            list-style: none;
            margin-top: 5px;
            padding: 8px;
            font-weight: bold;
            color: white;
            background-color: #2ea6bd;
            border-radius: 3px;
            text-align: center;
        }

        svg {
            width: 560px;
            margin-left: 10px;
        }

        line {
            stroke-width: 5px;
        }

        line.sca_1 {
            stroke-width: 2px;
            stroke: black;
        }

        line.len_db {
            stroke: #009688;
        }

        line.len_qr {
            stroke: #e91e1e;
        }

        line.scale {
            stroke-width: 2px;
            stroke-dasharray: 5px;
            stroke: #607d8b75;
        }

        line.edge {
            stroke-width: 5px;
            stroke: black;
        }

        table {
            width: 100%;
            table-layout: auto;
            word-wrap: break-word;
            border-collapse: collapse;
            border-spacing: 0;
        }

        table th,
        table td {
            padding: 4px;
            margin: 0;
            box-shadow: 0 0 5px 2px #3e393912;
            text-align: center;
            border: 2px solid #d4c3c3;
        }

        table tr:nth-child(odd) {
            background-color: #eee;
        }

        .content_wrap {
            margin: auto;
            max-width: 1280px;
        }

        .content_main {
            border-radius: 20px;
            background-color: white;
            margin: 0 30px
        }

        h2 {
            background-color: #009688;
            color: white;
        }

        .h2_1 {
            margin-top: 10px;
            padding: 10px;
            padding-left: 20px;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .h2_2 {
            border: 1px solid;
            margin-bottom: 0;
            padding: 15px;
            border-radius: 5px;
            margin-top: 30px;
        }

        .h2_3 {
            border-radius: 5px;
            margin: 0 30px;
            padding: 10px;
        }

        .topul {
            padding: 0;
            word-break: break-word;
        }

        .adjust td:nth-child(1),
        .adjust td:nth-child(2) {
            width: 20%;
            font-weight: bold;
            color: #3c1c1c;
        }

        .adjust td:nth-child(1) {
            font-size: 18px;
        }

        .topulel td,
        .topulel th {
            border: 2px solid #3a6d77;
            padding: 13px;
        }

        .topul tr:nth-child(odd) {
            background-color: #eef9f9;
        }

        #top_bar {
            background-color: #607D8B;
            color: white;
            font-size: 20px;
        }

        .table_wrap {
            padding: 30px;
            padding-top: 5px;
        }

        .blast_result {
            word-break: break-all;
        }

        .blast_result td {
            color: black;
            font-weight: bold;
            font-size: 13px;
        }

        .blast_result th {
            color: #607d8b;
            font-size: 14px;
            background-color: aliceblue;
        }

        .blast_result td:nth-child(12) {
            white-space: nowrap;
        }

        .toggle {
            visibility: visible;
        }

        button {
            background-color: #607d8b;
            color: white;
            border-color: white;
            border-radius: 12px;
            width: 100%;
            font-size: 25px;
            text-align: center;
            font-weight: bold;
            padding: 20px;
            padding-left: 30px;
            outline: 0;
            position: relative;
        }

        .btn_wrap {
            border: 2px solid #3a6d77;
            border-top: none;
            padding: 10px 5px;
            background-color: #eee;
        }

        .nav_s,
        .nav_c {
            width: 30px;
            height: 30px;
            float: left;
            margin: 0;
            border: 5px solid white;
        }

        .nav_c {
            transform: translateY(20%) rotate(45deg);
            border-bottom: 0px solid transparent;
            border-right: 0px solid transparent;
        }

        .nav_s {
            transform: translateY(-20%) rotate(45deg);
            border-top: 0px solid transparent;
            border-left: 0px solid transparent;
        }

        .query_info th {
            background-color: skyblue;
            width: 15%;
            padding: 13px;
            border: 1.5px solid #607D8B;
        }

        .query_info td {
            background-color: #eee;
        }

        .query_info td {
            max-width: 150px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        caption {
            padding: 8px;
            font-weight: bold;
            color: #607d8b;
            font-size: 19px;
        }

        .s_ul {
            display: inline-block;
            margin-left: 30px;
        }

        #accordion {
            table-layout: fixed;
        }

        </style><script type="text/javascript">< !--window.onload=function() {
                acc = document.getElementsByClassName('toggle');

                for (var i = 0; i < acc.length; i++) {
                    acc[i].style.visibility = "collapse";
                }
            }

            function show() {
                button = document.getElementsByTagName('button');
                btn = button[0].innerHTML;

                if (btn === 'Show ALL<p class="nav_s"></p>') {
                    var tar = document.getElementsByClassName('toggle');

                    for (var j = 0; j < tar.length; j++) {
                        tar[j].style.visibility = "visible";
                    }

                    button[0].innerHTML = 'CLOSE<p class="nav_c"></p>';
                }

                else if (btn === 'CLOSE<p class="nav_c"></p>') {
                    var cls = document.getElementsByClassName('toggle');

                    for (var j = 0; j < cls.length; j++) {
                        cls[j].style.visibility = "collapse";
                    }

                    button[0].innerHTML = 'Show ALL<p class="nav_s"></p>';
                }
            }

            ;
        -- >
        </script>
</body>

</html>