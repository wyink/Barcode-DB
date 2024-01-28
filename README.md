# Barcode-DB
DNA barcoding is one of a method for species identification. 
This application allows you to identify large amount of *rbcL* sequences more accurately by using our curated Blast DB. </br>

DNAバーコーディングは種などの分類群情報を塩基配列の類似度から導きだす手法です。
このアプリケーションはユーザーから*rbcL*もしくは*matK*の塩基配列を受け取って最も近いと判断できる種（taxonomy）の情報をリストで表示します。
判定はBLASTを使用するため、これがインストールされている必要があります。BLASTで検索に利用するデータベースはこちらで提供しているものが使用されます。
このデータベースを構成するIDや塩基配列はウェブアプリケーション上のダウンロードページを利用して入手できます。</br>

利用方法：
1. 下記URLよりBLASTアプリケーションをインストールします。
https://ftp.ncbi.nlm.nih.gov/blast/executables/blast+/LATEST/

2. 本アプリケーションを起動します
$ node app.js

