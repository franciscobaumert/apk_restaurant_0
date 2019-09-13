<?php
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
require_once ("menu.php");
$nombres= $_POST['nombres'];  
$a1= recoge1('a1');               
                  $a2 =recoge1('a2');                  
                  $a3 = recoge1('a3');                  
                  $a4 = recoge1('a4'); 
                  $a5 = recoge1('a5');    
                  $a6 =recoge1('a6'); 
                  $a7 = recoge1('a7'); 
                  $a8 = recoge1('a8'); 
                  $a9 =recoge1('a9'); 
                  $a10 =recoge1('a10'); 
                  $a11 = recoge1('a11'); 
                  $a12 = recoge1('a12'); 
                  $a13 = recoge1('a13'); 
                  $a14 =recoge1('a14'); 
                  $a15 =recoge1('a15'); 
                  $a16 =recoge1('a16'); 
                  $a17 =recoge1('a17'); 
                  $a18 =recoge1('a18'); 
                  $a19 =recoge1('a19');
                  $a20 =recoge1('a20');
                  $a21 =recoge1('a21');
                  $a22 =recoge1('a22');
                  $a23 =recoge1('a23');
                  $a24 =recoge1('a24');
                  $a25 =recoge1('a25');
                  $a26 =recoge1('a26');
                  $a27 =recoge1('a27');
                  $a28 =recoge1('a28');
                  $a29 =recoge1('a29');
                  
                  $a30 =recoge1('a30');
                  $a31 =recoge1('a31');
                  $a32 =recoge1('a32');
                  $a33 =recoge1('a33');
                  $a34 =recoge1('a34');
                  $a35 =recoge1('a35');
                  
                  $a36 =recoge1('a36');
                  $a37 =recoge1('a37');
                  $a38 =recoge1('a38');
                  $a39 =recoge1('a39');
                  
                  $a40 =recoge1('a40');
                  $a41 =recoge1('a41');
                  $a42 =recoge1('a42');
                  $a43 =recoge1('a43');
                  $a44 =recoge1('a44');
                  $a45 =recoge1('a45');
                  $a46 =recoge1('a46');
                  $a47 =recoge1('a47');
                  $a48 =recoge1('a48');
                  $a49 =recoge1('a49');
                  $a50 =recoge1('a50');
                  $a51 =recoge1('a51');
                  $a52 =recoge1('a52'); 
                  $a53 =recoge1('a53');                
$c=$a1.".".$a2.".".$a3.".".$a4.".".$a5.".".$a6.".".$a7.".".$a8.".".$a9.".".$a10.".".$a11.".".$a12.".".$a13.".".$a14.".".$a15.".".$a16.".".$a17.".".$a18.".".$a19.".".$a20.".".$a21.".".$a22.".".$a23.".".$a24.".".$a25.".".$a26.".".$a27.".".$a28.".".$a29.".".$a30.".".$a31.".".$a32.".".$a33.".".$a34.".".$a35.".".$a36.".".$a37.".".$a38.".".$a39.".".$a40.".".$a41.".".$a42.".".$a43.".".$a44.".".$a45.".".$a46.".".$a47.".".$a48.".".$a49.".".$a50.".".$a51.".".$a52.".".$a53;      

$sql = "UPDATE users SET accesos='".$c."'
                            WHERE nombres='".$nombres."';";
                    $query_update = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query_update) {
                        header("location:acceso.php?usuario=$nombres&mensaje=Acceso actualizado");
                    } else {
                        header("location:acceso.php?usuario=$nombres&mensaje=No se pudo actualizar");
                    } 

?>       

