@extends('layouts.layout')

@section('headerContent')
    <header>
        <div class="header-inner">
            <div class="Logo">Barcode DB</div>
            <div class="header-item">
                <nav class="nav1">
                    <ul>
                        <li><a href="/">Top </a></li>
                        <li id="now"><a href="/download">DownLoad</a></li>
                        <li><a href="/taxonomy">Taxonomy</a></li>
                        <li><a href="/help">Help </a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="hpad"></div>
    <div class="N_wrapper"></div>
    <div class="NN_wrapper">
        <div class="N_header"></div>No query hit.<br>
        <div class="N_content"><span class="N_title"></span>Possible Causes:<br>
            <ul></ul>
            <li>Nucleotide sequences only.</li>
            <li>Your query may not be long enough to identify.</li>
            <li>Your query may not include sequences that encodes rbcL gene.</li>
            <li>The region encoding rbcL gene may not be long enough to identify.</li>
        </div>
    </div>
    <style type="text/css">
        <!--
        html {
            width: 100%;
            height: 100%;
        }

        .N_wrapper {
            max-width: 1280px;
            margin: 120px auto;
        }

        .NN_wrapper {
            margin: 0 30px;
            background-color: #f2f1f152;
            border: 1.3px solid #eee;
            border-radius: 13px;
            padding: 13px;
            color: white;
        }

        .N_content ul {
            display: block;
            margin: 15px 25px;
        }

        .N_content li {
            padding: 5px;
        }

        .N_header {
            font-weight: bold;
            font-size: 29px;
            text-align: center;
            border-bottom: 3px solid #fffefc;
            padding: 5px;
        }

        .N_content {
            padding: 10px;
            padding: left:30px;
            margin: auto;
        }

        .N_title {
            font-weight: bold;
            font-size: 18px;
        }
        -->
    </style>

@endsection