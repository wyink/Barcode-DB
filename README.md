# Barcode-DB
DNA barcoding is one of a method for species identification. 
This application allows you to identify large amount of *rbcL* sequences more accurately by using our curated Blast DB. </br>

DNAバーコーディングは種などの分類群情報を塩基配列の類似度から導き出す手法です。
このアプリケーションはユーザーから*rbcL*もしくは*matK*の塩基配列を受け取って最も近いと判断できる種（taxonomy）の情報をリストで表示します。
判定はBLASTアプリケーションを使用するため、これをインストール下いてだく必要があります。
BLASTで検索に利用するデータベースはこちらで提供しているものを選択してご利用いただけます。

</br>

利用方法：
1. 下記URLよりBLASTアプリケーションをインストール
https://ftp.ncbi.nlm.nih.gov/blast/executables/blast+/LATEST/
動作確認済：ncbi-blast-2.11.0

2.DB準備等（Laravelのみ）
　(1)SQLサーバー上でphp_version/database/preworkの6つのSQLを下記の順番に実行
   ・create_table.sql
   ・残りの5つのSQLファイル（各テーブルへのデータ挿入）

　(2)下記二つのファイルの設定を利用するデータベース環境に合わせて変更
    /.env (14~16行目/記載はsqlsrv)
    /config/database.php(36行目以降ののconnection)

　(3)/public/resources/download/gz_fastaおよびgz_taxidList直下の全ファイルを下記に移動
　　/php_version/storage/app/public/*

2. 本アプリケーションを起動 </br>
　(1)Node.jsの場合
　　　`node app.js`
　(2)Laravelの場合
　　　(ⅰ)php_versionディレクトリへ移動
　　　(ⅱ)`php artisan serve`


3. 任意のブラウザにてlocalhost:3000(node.js)/8000(Laravel)にアクセス（下記ページが表示されます）</br>

4. フォームに調査したい植物の塩基配列を入力し、実行ボタンを押下
　 入力した塩基配列から可能性の高い植物の一覧を表示します。

</br>
</br>

**Top画面**
<img width="1770" alt="image" src="https://github.com/wyink/Barcode-DB/assets/69898489/c82a3f04-1e43-4743-8406-1a864a44ae88">

</br>
</br>
</br>

**検索結果画面（サンプル）**
<img width="1770" alt="image" src="https://github.com/wyink/Barcode-DB/assets/69898489/9e4fcd18-8b02-4fc9-b246-5c18908026f5">




