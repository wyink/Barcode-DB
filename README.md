# Barcode-DB
DNA barcoding is one of a method for species identification. 
This application allows you to identify large amount of *rbcL* sequences more accurately by using our curated Blast DB. </br>

DNAバーコーディングは種などの分類群情報を塩基配列の類似度から導き出す手法です。
このアプリケーションはユーザーから*rbcL*もしくは*matK*の塩基配列を受け取って最も近いと判断できる種（taxonomy）の情報をリストで表示します。
判定はBLASTアプリケーションを使用するため、これをインストール下いてだく必要があります。
BLASTで検索に利用するデータベースはこちらで提供しているものを選択してご利用いただけます。

</br>

利用方法：
1. 下記URLよりBLASTアプリケーションをインストールします。
https://ftp.ncbi.nlm.nih.gov/blast/executables/blast+/LATEST/

2. 本アプリケーションを起動します
$ node app.js

3. 任意のブラウザにてlocalhost:3000にアクセスします。

１～３の手順にて下記のページにてアクセスできるようになります。
<img src= "https://github.com/wyink/Barcode-DB/assets/69898489/1850fa15-fdcd-42e7-a557-1588a7e31c1a">

4. フォームにお持ちの調査したい植物の塩基配列を入力し、実行ボタンを押下することで可能性の高い植物の一覧が表示されます。


