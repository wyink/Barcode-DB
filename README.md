# barcodedb
DNA barcoding is a method for species identification. 
This application allows you to identify large amont of rbcL sequences more accurately by using our curated Blast DB. </br>
more info 

DNAバーコーディングは種などの分類群情報を塩基配列の類似度から導きだす手法です。
このアプリケーションはユーザーから*rbcL*もしくは*matK*の塩基配列を受け取って最も近いと判断できる種（taxonomy）の情報をリストで表示します。
判定はBLASTを使用するためこれがインストールされている必要があります。BLASTで検索に利用するデータベースはこちらで提供しているものが使用されます。
このデータベースを構成するIDや塩基配列はウェブアプリケーション上のダウンロードページを利用して入手できます。</br>
## デモ
このアプリケーションは実際に現在運用しているサイトをNode.jsで書き換えたものであり、[このURL](http://www.plant.osakafu-u.ac.jp/~kagiana/barcode/Website.html)から動きを確認できます。
こちらはサーバーサイドの処理をPerlのCGIで処理しています。
