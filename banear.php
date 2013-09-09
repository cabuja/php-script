<?php
if ($_SERVER) {  
   if ( $_SERVER["HTTP_X_FORWARDED_FOR"] ) {  
       $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];  
   } elseif ( $_SERVER["HTTP_CLIENT_IP"] ) {  
       $realip = $_SERVER["HTTP_CLIENT_IP"];  
   } else {  
       $realip = $_SERVER["REMOTE_ADDR"];  
   }  
} else {  
    if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {  
       $realip = getenv( 'HTTP_X_FORWARDED_FOR' );  
    } elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {  
       $realip = getenv( 'HTTP_CLIENT_IP' );  
    } else {  
       $realip = getenv( 'REMOTE_ADDR' );  
    }  
}

$fecha=date("Y-m-d H:i:s");
include "conectar.php";

$sql_vis="SELECT * FROM visitantes WHERE ip_visitantes='$realip' ORDER BY id_visitantes DESC";
$rs_vis=mysql_query($sql_vis);

if (mysql_num_rows($rs_vis)!="") {
  $row_vis=mysql_fetch_assoc($rs_vis);
  $ip_visitantes=$row_vis["ip_visitantes"];
  $date_visitantes=$row_vis["date_visitantes"];
  $estado_visitantes=$row_vis["estado_visitantes"];
  //$fecha=date("m-d-Y H:i:s");
  $segundos=strtotime('now') - strtotime($date_visitantes) ; // strtotime calcula segundos
  $diferencia_dias=intval($segundos/60/60/24); // con intval calculas los dias
  echo "<b>Cant. seg. hoy: </b>" . strtotime('now') . "<br>";
  echo "<b>Cant. seg. ultima visita: </b>" .  strtotime($date_visitantes) . "<br>";
  echo "<b>Cant. visitas: </b>" . mysql_num_rows($rs_vis) . "<br>";
  echo "<b>La cantidad de segundos entre el </b>".$date_visitantes." y hoy es <b>".$segundos."</b><br>";
  echo "<b>La cantidad de d&iacute;as entre </b>".$date_visitantes." y hoy es <b>".$diferencia_dias."</b>";
}

$sql_ip="INSERT INTO visitantes VALUES (0,'$realip','$fecha','1')";
mysql_query($sql_ip);
?>