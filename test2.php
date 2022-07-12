<?php
/*
define('IS_LOCAL'     , in_array(['130.211.0.64'], ['127.0.0.1', '::1']));
define('BASEPATH'     , IS_LOCAL ? '/school/' : '/'); 
define('PROTOCOL'   , isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"); // Detectar si está en HTTPS o HTTP
define('HOST'       , $_SERVER['HTTP_HOST'] === 'localhost' ? (PREPROS ? 'localhost:'.PORT : 'localhost') : $_SERVER['HTTP_HOST']); // Dominio o host localhost.com tudominio.com
define('REQUEST_URI', $_SERVER["REQUEST_URI"]); // Parámetros y ruta requerida
define('URL'        , PROTOCOL.'://'.HOST.BASEPATH); // URL del sitio
define('CUR_PAGE'   , PROTOCOL.'://'.HOST.REQUEST_URI); // URL actual incluyendo parámetros get

echo "protocol :".PROTOCOL;
echo "<br>";
echo "host :".HOST;
echo "<br>";
echo "request uri :".REQUEST_URI;
echo "<br>";
echo "url :".URL;
echo "<br>";
echo "cur_page :".CUR_PAGE;
echo "<br>";
echo "basepath :".BASEPATH;
echo "<br>";
echo "islocal :".IS_LOCAL;
echo "<br>";
var_dump($_SERVER );
echo "<br>";
echo "server remote adr  :".$_SERVER['REMOTE_ADDR'];
*/
//

$mysqli = new mysqli("10.128.0.3", "jple", "Gordi54321$", "jpledev");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "\n";

$mysqli = new mysqli("10.128.0.3", "jple", "Gordi54321$", "jpledev", 3306);
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

echo $mysqli->host_info . "\n";


?>