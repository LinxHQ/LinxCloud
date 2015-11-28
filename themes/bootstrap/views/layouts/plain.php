<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<link href='https://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800|Rouge+Script|Kaushan+Script' rel='stylesheet' type='text/css'>
	<link media="all" type="text/css" href="https://fonts.googleapis.com/css?family=Poiret+One&amp;subset=latin%2Clatin-ext%2Ccyrillic&amp;ver=3.9" id="pachyderm-poiret-one-css" rel="stylesheet">
            
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
	
        <style>
            /* Stylesheet / CSS */

/* CSS Reset - Do not edit this line */ 
html {margin:0;padding:0;border:0;}body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, code, del, dfn, em, img, q, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, dialog, figure, footer, header, hgroup, nav, section {margin:0;padding:0;border:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;}article, aside, dialog, figure, footer, header, hgroup, nav, section {display:block;}body {line-height:1.5;background:white;}table {border-collapse:separate;border-spacing:0;}caption, th, td {text-align:left;font-weight:normal;float:none !important;}table, th, td {vertical-align:middle;}blockquote:before, blockquote:after, q:before, q:after {content:'';}blockquote, q {quotes:"" "";}a img {border:none;}:focus {outline:0;}


/* General Styles
----------------------------------------------------------------------------------------------------*/
html {
	min-height: 100%;
}
body {
	height: 100%;
	position: relative;
	font-family: Arial, Helvetica, sans-serif;
	color: #888;
	font-size: 13px;
	line-height: 20px;
	min-width: 998px;
	border-top:5px solid #0398da;
        background:url(../images/loginform/BG.jpg) repeat;
	/**background: url("../images/gray_jean.png") repeat scroll 0 0 transparent;**/
}
#wrapper {	
	padding: 70px 0 0 0px;
	height: 100%;
}
#wrapper {
	width: 350px;
	margin:auto;
	position: relative;
}

#wrappertop {
	/**background:url(../images/loginform/wrapper_top.png) no-repeat;**/
	height:22px;
}

#wrappermiddle {
	/**background:url(../images/loginform/wrapper_middle.png) repeat-y;**/
	height:240px;
}

#wrapperbottom {
	/**background:url(../images/loginform/wrapper_bottom.png) no-repeat;**/
	height:22px;
}

#wrapper h2 {
	margin-left:20px;
	font-size:20px;
	font-weight:bold;
	font-family:Myriad Pro;
	text-transform:uppercase;
	position:absolute;
	text-shadow: #fff 2px 2px 2px;
}

#username_input {
	margin-left:25px;
	position:absolute;
	width:300;
	height:50px;
	/**margin-top:40px;**/
}

#username_inputleft {
	float:left;
	background:url(../images/loginform/input_left.png) no-repeat;
	width:12px;
	height:50px;
}

#username_inputmiddle {
	float:left;
	background:url(../images/loginform/input_middle.png) repeat-x;
	width:276px;
	height:50px;
}

#username_inputright {
	float:left;
	background:url(../images/loginform/input_right.png) no-repeat;
	width:12px;
	height:50px;
}

.url{
	display:block;
	width:276px;
	height:45px;
	background:transparent;
	border:0;
	color:#bdbdbd;
	font-family:helvetica, sans-serif;
	font-size:14px;
	padding-left:20px;
}

#url_user {
	position:absolute;
	display:block;
	margin-top:-28px;
	float:left;
	padding-right:10px;
}

#password_input {
	margin-left:25px;
	position:absolute;
	width:300;
	height:50px;
	margin-top:60px;
}

#password_inputleft {
	float:left;
	background:url(../images/loginform/input_left.png) no-repeat;
	width:12px;
	height:50px;
}

#password_inputmiddle {
	float:left;
	background:url(../images/loginform/input_middle.png) repeat-x;
	width:276px;
	height:50px;
}

#password_inputright {
	float:left;
	background:url(../images/loginform/input_right.png) no-repeat;
	width:12px;
	height:50px;
}

#url_password {
	display:block;
	position:absolute;
	margin-top:-32px;
	float:left;
	margin-left:4px;
}

#submit{
	float:left;
	position:relative;
	padding:0;
	margin-top:120px;
	margin-left:25px;
	width:300px;
	height:40px;
	border:0;
}

#submit1 {
	position:absolute;
	z-index: 10;
	border:0;
}

#submit2 {
	position:absolute;
	margin-top:0px;
	border:0;
}

#links_left{
	float:left;
	position:relative;
	padding-top:5px;
	margin-left:25px;
}

#links_left a{
	color:#bbb;
	font-size:11px;
	text-decoration:none;
	transition: color 0.5s linear;
	-moz-transition: color 0.5s linear;
	-webkit-transition: color 0.5s linear;
	-o-transition: color 0.5s linear;
}

#links_left a:hover{
	color:#292929;
}

#links_right{
	float:right;
	position:relative;
	padding-top:5px;
	margin-right:25px;
}

#links_right a{
	color:#bbb;
	font-size:11px;
	text-decoration:none;
	transition: color 0.5s linear;
	-moz-transition: color 0.5s linear;
	-webkit-transition: color 0.5s linear;
	-o-transition: color 0.5s linear;
}

#links_right a:hover{
	color:#292929;
}

#powered{
	float:right;
	position:relative;
	padding-top:3px;
	margin-right:5px;
	font-size:11px;
}

#powered a{
	color:#aaa;
	font-size:11px;
	text-decoration:none;
	transition: color 0.5s linear;
	-moz-transition: color 0.5s linear;
	-webkit-transition: color 0.5s linear;
	-o-transition: color 0.5s linear;
}

#powered a:hover{
	color:#292929;
}

.btn {
  -moz-border-bottom-colors: none;
-moz-border-left-colors: none;
-moz-border-right-colors: none;
-moz-border-top-colors: none;
background-color: #fff;
/**border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #a2a2a2;**/
border-image: none;
border-radius: 4px;
border-style: solid;
border-width: 1px;
color: #fff;
cursor: pointer;
display: inline-block;
font-size: 14px;
line-height: 20px;
margin-bottom: 0;
padding: 4px 12px;
text-align: center;
/**text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);**/
vertical-align: middle;
}

.btn-primary {
  background-color: #dcdcdc;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  color: #fff;
  /**text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);**/
}


        </style>
	
<script>


	$(document).ready(function(){
 
	$("#submit1").hover(
	function() {
	$(this).animate({"opacity": "0"}, "slow");
	},
	function() {
	$(this).animate({"opacity": "1"}, "slow");
	});
 	});


</script>
	
</head>
<body>
    <?php echo $content; ?>
</body>
</html>