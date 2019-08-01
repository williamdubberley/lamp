<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1">
<title>untitled document</title>
<link rel="stylesheet" href="css/screen.css" media="screen">
<style >
/* This demo stylesheet ONLY styles the nav menu. */
a {
    color:#33348e;
    text-decoration:none;
    text-transform:uppercase;
}
nav {
    background-color:#33348e;
    font-family:verdana,arial,times,serif;
    font-size:.875em;
    overflow:hidden;
    padding-left:4%;
}
nav ul {
    padding:0;
    margin:0;
}
nav ul li {
    list-style-type:none;
    float:left;
    position:relative;
    padding:0;
    margin:0;
}
nav ul li a {
    display:block;
    color:#fff;
    padding:.875em .625em;
    margin:0;
}
nav ul li a:hover,
nav ul li a:focus {
    background-color:#fff;
    color:#33348e;
    text-decoration:underline;
    font-weight:normal;
}
/* These selectors style the active page's menu */
#home .home a,
#aboutus .aboutus a,
#services .services a,
#projects .projects a,
#contact .contact a {
    color:#33348e;
    background-color:#fff;
    pointer-events:none;
}

</style>
</head>
<body> 
<h1>Page Title</h1>
<?php
   $menu=file_get_contents("menu.txt");
   $base=basename($_SERVER['PHP_SELF']);
   $menu=preg_replace("|<li><a href=\"".$base."\">(.*)</a></li>|U", "<li id=\"current\">$1</li>", $menu);
   echo $menu;
?>
</body>
</html>