<?php

$kata = ['D','U','M','B','W','A','I','S','I','D'];

function cetakGambar($kata){
	
    echo "<table>";
    $pjg = count($kata);
    for($i=0;$i<$pjg;$i++){
    	echo "<tr>";
    	for($x=0,$y=$pjg-1;$x<$pjg;$x++,$y--){
        		if($x==$i||$y==$i){
                	echo "<td>".$kata[$i]."</td>";
                }
                else{
                	echo "<td>"."="."</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
   }
  ?>
  <html>
  <body>
  <?php
  cetakGambar($kata);
  ?>
  </body>
  </html>