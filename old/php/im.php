<?php
$filename[0]='システム英単語_1〜50.csv';
$filename[1]='システム英単語_51〜100.csv';
$filename[2]='システム英単語_101〜150.csv';
$filename[3]='システム英単語_151〜200.csv';
$filename[4]='システム英単語_201〜250.csv';
$filename[5]='システム英単語_251〜300.csv';
$filename[6]='システム英単語_301〜350.csv';
$filename[7]='システム英単語_351〜400.csv';
$filename[8]='システム英単語_401〜450.csv';
$filename[9]='システム英単語_451〜500.csv';
$filename[10]='システム英単語_501〜550.csv';
$filename[11]='システム英単語_551〜600.csv';
$filename[12]='システム英単語_601〜650.csv';
$filename[13]='システム英単語_651〜700.csv';
$filename[14]='システム英単語_701〜750.csv';
$filename[15]='システム英単語_751〜800.csv';
$filename[16]='システム英単語_801〜850.csv';
$filename[17]='システム英単語_851〜900.csv';
$filename[18]='システム英単語_901〜950.csv';
$filename[19]='システム英単語_951〜1000.csv';
$filename[20]='システム英単語_1001〜1050.csv';
$filename[21]='システム英単語_1051〜1100.csv';
$filename[22]='システム英単語_1101〜1150.csv';
$filename[23]='システム英単語_1151〜1200.csv';
$filename[24]='システム英単語_1201〜1250.csv';
$filename[25]='システム英単語_1251〜1300.csv';
$filename[26]='システム英単語_1301〜1350.csv';
$filename[27]='システム英単語_1351〜1400.csv';
$filename[28]='システム英単語_1401〜1450.csv';
$filename[29]='システム英単語_1451〜1500.csv';
$filename[30]='システム英単語_1501〜1550.csv';
$filename[31]='システム英単語_1551〜1600.csv';
$filename[32]='システム英単語_1601〜1650.csv';
$filename[33]='システム英単語_1651〜1700.csv';
$filename[34]='システム英単語_1701〜1750.csv';
$filename[35]='システム英単語_1751〜1800.csv';
$filename[36]='システム英単語_1801〜1850.csv';
$filename[37]='システム英単語_1851〜1900.csv';
$filename[38]='システム英単語_1901〜1950.csv';
$filename[39]='システム英単語_1951〜2000.csv';
$filename[40]='システム英単語_2001〜2021.csv';
 ?>
<?php 
    // ファイル取得
    $fcnt = 0;

        echo "<pre>";
    while ($fcnt < 1){

        $a = '物質の構成1.csv';

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

            echo "INSERT INTO sys(`word`,`mean`) VALUE('".trim($records[$i][0], '﻿"')."','".$records[$i][1]."');<br>";

        }

        $fcnt++;

    }
 
    echo "</pre>";
 ?>