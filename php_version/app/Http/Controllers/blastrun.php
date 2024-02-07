<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class blastrun extends Controller
{
    public function index(){
        /*
        blast実行時のメソッド
        pre処理は値のvalidationで実施
        post処理はhtmlの整形処理
        このコントローラーでは何を実施する？
        後々はDBからデータ取得等
        今：
        １．ファイル名を生成
        ２．ファイルを書き出し
        ３．blast実行
        ４．ファイルサイズ確認
        ５．resultファイル読み出し＝＞DB登録？
        ６．種別ファイル読み出し
        ７．５と６の紐づけ
        ８．結果の表示＝＞postのmiddlewareにて実装
        コントローラとしてルートから呼び出されるものシングルメソッドにしておく。
        それ以外はprivateとして関数を分割する。
        */
        return view("index");
    }
    
    static function getfileName(){
        $randomNum = rand(0,10000);
        return $randomNum;
    }
}
