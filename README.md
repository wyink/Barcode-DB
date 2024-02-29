# Barcode-DB
DNAバーコーディングは種などの分類群情報を塩基配列の類似度から導き出す手法です。
このアプリケーションはユーザーから*rbcL*もしくは*matK*の塩基配列を受け取って最も近いと判断できる種（taxonomy）の情報をリストで表示します。
判定はBLASTアプリケーションを使用するため、これをインストール下いてだく必要があります。
BLASTで検索に利用するデータベースはこちらで提供しているものを選択してご利用いただけます。

</br>

利用方法：
1. 下記URLよりBLASTアプリケーションをインストール
https://ftp.ncbi.nlm.nih.gov/blast/executables/blast+/LATEST/ </br>
動作確認済：ncbi-blast-2.11.0

2. DB準備等（Laravelのみ）</br>
   1. SQLサーバー上でphp_version/database/preworkの6つのSQLを下記の順番に実行
      - create_table.sql
      - 残りの5つのSQLファイル（各テーブルへのデータ挿入）</br>
   2. 下記二つのファイルの設定を利用するデータベース環境に合わせて変更
      - /.env (14~16行目/記載はsqlsrv)
      - /config/database.php(36行目以降ののconnection) </br>
   3. /public/resources/download/gz_fastaおよびgz_taxidList直下の全ファイルを下記に移動
      - /php_version/storage/app/public/*

2. 本アプリケーションを起動 </br>
   - Node.jsの場合 </br>
   `node app.js`
   - Laravelの場合
     1. php_versionディレクトリへ移動
     2. `php artisan serve`


4. 任意のブラウザにてlocalhost:3000(node.js)/8000(Laravel)にアクセス（下記ページが表示されます）</br>

5. フォームに調査したい植物の塩基配列を入力し、実行ボタンを押下
　 入力した塩基配列から可能性の高い植物の一覧を表示します。

</br>
</br>

**Top画面**
<img width="1770" alt="image" src="https://github.com/wyink/Barcode-DB/assets/69898489/3e851a24-92b4-4915-9df2-4d79c96a5828">


</br>
</br>
</br>


**検索結果画面（サンプル）**
<img width="1770" alt="image" src="https://github.com/wyink/Barcode-DB/assets/69898489/a3d2b8e5-ebe2-4590-ad65-6c4bbb2e78fe">




