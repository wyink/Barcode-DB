@extends('layouts.layout')

@section('append_header')
  <link rel='stylesheet' href='/css/help.css'>
@endsection

@section('headerContent')
    <header>
        <div class="header-inner">
            <div class="Logo">Barcode DB</div>
            <div class="header-item">
                <nav class="nav1">
                    <ul>
                        <li><a href="/"> Top </a></li>
                        <li><a href="/download">DownLoad</a></li>
                        <li><a href="/taxonomy">Taxonomy</a></li>
                        <li id="now"><a href="#"> Help </a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <div class="headline">
            <h1>Read Me</h1>
            <div class="content">
                <h2>このウェブサイトについて</h2>
                <p>今回作成したウェブサイトの目的は以下に示す一連の流れをボタン一つで簡単に行うサービスである．
                    ユーザーが研究・解析などによって得た遺伝子配列がどの種の配列に最も似ているかを探索する．</p>
                <div>
                    <h2>このアプリケーションの仕組み</h2>
                    <p class="image-display"><img src="/images/architecture.png" alt="このアプリケーションの仕組み"></p>
                </div>
            </div>
            <div class="content">
                <h2>他ウェブサービスとの違い</h2>
                <p>作成したウェブサービスは，ユーザーから受け取った配列を検索にかけるデータの選別及び処理にこだわっている.
                    検索対象のデータは多ければ多いほど良いわけでは無く，その分不正確なデータや欠損データ，及び検索アルゴリズム
                    の特性からはじかれるデータが増加する．このような利用者からは見えにくい潜在的なエラーを減らすことを目的とした
                    データセットを検索対象のデータとして利用している．しかし，従来のデータセットも使用可能である．</p>
            </div>
            <div class="content">
                <h2>ターゲットユーザー</h2>
                <p>このウェブサービスは特定の遺伝子を利用して種の判別を行いたい利用者に向いている．
                    特に正解の種が検索結果に出来るだけ含まれるような検索を行いたい場合に有利である．
                    このウェブサイトで公開しているデータの詳細は<a href="/">トップページ</a>を参照されたい．</p>
            </div>
        </div>
        <div class="section_wrap"></div>
    </main>
@endsection