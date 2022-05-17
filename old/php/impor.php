<?php 
    echo "<pre>";

        $a = '名詞・副詞2.csv';

        $file = new SplFileObject( $a ); 
        $file->setFlags(SplFileObject::READ_CSV);
         
        foreach ($file as $key => $line) {
            
            $num = 0;

            foreach( $line as $str ){
                
                $records[ $key ][] = $str;

            }
     
        }

        $after = '1';
        $j = 240;

        for ($i=0; $i < (count( $records )-1); $i++) { 

            // echo "INSERT INTO dou(`word`,`mean`) VALUE('".trim($records[$i][0], '﻿"')."','".$records[$i][1]."');<br>";
            // echo "UPDATE kob SET `explain` = '".$records[$i][0]."' WHERE ID = ".($i).";<br>";

            $before = $records[$i][0];

            if ( $before == $after ) {
                $exp = $exp. $records[$i][1].'<br>'.$records[$i][2].'<br><br>';
            } else {
                echo "UPDATE kob SET `explain` = '".$exp . "' WHERE ID = ".($j).";<br>";
                $exp = $records[$i][1].'<br>'.$records[$i][2].'<br><br>';
                $j++;
            }

            $after = $records[$i][0];

        }
 
    echo "</pre>";
 ?>