mt-cros
===

Cross languages Mersenne Twister.

元々、PHPとJavaScriptで同じ乱数生成期を使いたかったので作りました。

オリジナルではなく、下記サイトからアレンジしています。

http://homepage2.nifty.com/magicant/sjavascript/mt.html

PHPがunsigned intをサポートしないため、javascript側もsigned intでの計算にするなど、複数言語用に多少いじっています。

PHPの浮動小数点精度とJavaScriptの浮動小数点精度が違う場合など、next()関数においては若干の誤差は起こりえるので、基本的にはnextIntによる利用になると思います。

javascript版はjsフォルダ内のファイルを、php版はphpフォルダ内のファイルを利用してください。他言語版はどなたかpushしてくれたらマージします。