<?php header("Content-Type:text/html;charset=utf-8"); ?>

<?php 

    $url = 'mysql1.webcrow-php.netowl.jp';
    $user = 'astrongame_db';
    $password = 'Unlock';

    $link = mysqli_connect( $url, $user, $password );
    if ( ! $link ) die( 'Warning: Connect '.mysql_error() );

    $db_selected = mysqli_select_db($link, $user);
    if ( ! $db_selected ) die( 'Warning: Select DB'.mysql_error() );

    mysqli_set_charset( $link, 'utf8' );

    $query = 'SELECT word,mean,correct,`check` FROM sys WHERE ID BETWEEN 1 AND 50 ORDER BY  `ID` ASC';
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            $arr = array();
            $len = mysqli_num_rows( $result );

            for ( $i=0; $i < $len; $i++ ) $arr[] = $i;

            for ($i = ( $len - 1 ); $i > 0; $i--) { 

                $j = mt_rand( 0, $i );
                $tmp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $tmp;

            }

            for ($i=0; $i < $len; $i++) { 

                mysqli_data_seek( $result, $arr[$i] );
                $row = mysqli_fetch_row($result);
                echo $row[0].'^'.$row[1].'^'.$row[2].'^'.$row[3].'@';
                
            }

 ?>