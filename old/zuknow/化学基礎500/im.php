
<?php 
    // ファイル取得
    $fcnt = 0;

        echo "<pre>";
    while ($fcnt < 1){

        $a = '化学結合1.csv';

        $file = new SplFileObject( $a ); 
        $file->setFlags(SplFileObject::READ_CSV);
         
        // ファイル内のデータループ
        foreach ($file as $key => $line) {
            
            $num = 0;

            foreach( $line as $str ){
                
                $records[ $key + $fcnt * 50 ][$num] = $str;
                $num++;

            }
     
        }

        for ($i=$fcnt * 50; $i < (count( $records )-1); $i++) { 

            echo "INSERT INTO che(`word`,`mean`,`explain`) VALUE('".trim($records[$i][0], '﻿"')."','".$records[$i][1]."','".$records[$i][2]."');<br>";

        }

        $fcnt++;

    }
 
    echo "</pre>";
 ?>