
<!DOCTYPE HTML>
<html>
<head>
<title>EFREY-PHP :: !!!Uups!!! Error</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style type="text/css">
@font-face {
  font-family: 'Love Ya Like A Sister';
  font-style: normal;
  font-weight: 400;
  src: local('Love Ya Like A Sister Regular'), local('LoveYaLikeASister-Regular'), url(<?php echo BASE_URL."core/404/font/LzkxWS-af0Br2Sk_YgSJY5HSI-O7NEBdNbD5SV3GSEY.woff"?>) format('woff');
}

body{
	font-family: 'Love Ya Like A Sister', cursive;
}
body{
	background:#eaeaea;
}	
.wrap{
	margin:0 auto;
	width:100%;
}
.logo{
	text-align:center;
	margin-top:5%;
}

.logo p{
	color:#272727;
	font-size:250%;
	margin-top:1px;
}	
.logo p span{
	color:lightgreen;
}


.bracket{
   color: #0000ff;
   font-size: 800%;
}
.code{
   color: #19ae38;
   font-size: 800%;
}

.footer{
	color:black;
	position:absolute;
	right:10px;
	bottom:10px;
}	
.footer a{
	color:rgb(114, 173, 38);
}	
</style>
</head>


<body>
 <div class="wrap">
	<div class="logo">
			<p> <?php echo $msg_error  ?></p>
			<div><span class="bracket">{</span><span class="code">!...?</span><span class="bracket">}</span></div>
            <div style="font-size: 120%;">Ir al <a href="http://<?php echo BASE_URL;?>">sitio</a> por defecto</div>
	</div>
 </div>	
	
	
	<div class="footer">
		Creado con <a href="http://efrey-php.com">Efrey-PHP</a> desearrollado por <a href="http://www.easycubasoft.com">Easycubasoft</a>
	</div>
	
</body>