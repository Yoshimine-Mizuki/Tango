<?php header("Content-Type:text/html;charset=utf-8"); ?>

<?php 

    $name = ( string )filter_input( INPUT_POST, 'data' );
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $error = "document.getElementById( 'sub' ).innerHTML = '<span>:(</span><br>You have an error.';";

    $pieces = explode( ',', $name );

    if ( $pieces[0] == 'code' ) {

        if ( ( strpos( $ua, 'iPhone' ) !== false ) or ( strpos( $ua, 'iPad' ) !== false ) ) {
            if ( $pieces[1] == 'iPhone' or $pieces[1] == 'iPad' ) {
                print(file_get_contents('code/script.js'));
            } else {
                echo $error;
            }
        } else {
            echo $error;
        }

    } else {

        $url = 'mysql1.webcrow-php.netowl.jp';
        $user = 'astrongame_db';
        $password = 'Unlock';

        $link = mysqli_connect( $url, $user, $password );
        if ( ! $link ) die( mysql_error() );

        $db_selected = mysqli_select_db($link, $user);
        if ( ! $db_selected ) die( mysql_error() );

        mysqli_set_charset( $link, 'utf8' );

        $query = 'SELECT `table` FROM subject WHERE ID = '.$pieces[1];
        $result = mysqli_query( $link, $query );
        if ( ! $result ) die( mysqli_error( $link ) );

        $table = mysqli_fetch_row( $result );

    }

    switch ( $pieces[0] ) {

        case '0':
            $query = 'SELECT correct FROM '.$table[0].' WHERE correct != 0';
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            $correct = mysqli_num_rows( $result );

            $query = 'SELECT ID FROM '.$table[0];
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            $all = mysqli_num_rows( $result );

            $rate = $corrent / $all * 100;

            $format = '%d,%d,%d,';
            printf( $format, $correct, $all, $rate );

            $query = 'SELECT category,title,num FROM record WHERE category = '.$pieces[1].' ORDER BY  `ID` ASC';
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            $cnt = 1;

            while ( $row = mysqli_fetch_assoc( $result ) ) {

                $query = 'SELECT correct FROM '.$table[0].' WHERE correct != 0 AND ID BETWEEN '.$cnt.' AND '.( $cnt + $row['num'] - 1 ).' ORDER BY  `ID` ASC';
                $re = mysqli_query( $link, $query );
                $rate = mysqli_fetch_row( $re );
                
                if ( ! $rate ) {
                    $rate = '0';
                } else {
                    $rate = mysqli_num_rows( $re );
                }

                echo $row['title'].'/'.$rate.'/'.$row['num'].',';

                $cnt += $row['num'];

            }

            break;

        case '1':
            switch ( $pieces[4] ) {

                case '2':
                    $para = 'correct = 0 AND';
                    break;
                case '3':
                    $para = '`check` = 1 AND';
                    break;
                default:
                    $para = '';
                    break;

            }

            $min = $pieces[2];
            $max = ( $pieces[2] + $pieces[3] - 1 );

            $query = 'SELECT COUNT( `correct` = 1 or null ) AS num, COUNT( `check` = 1 or null ) AS num2 FROM '.$table[0].' WHERE ID BETWEEN '.$min.' AND '.$max;
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            $row = mysqli_fetch_assoc( $result );
            echo $row['num'].'#'.$row['num2'].'#';

            $query = 'SELECT word,mean,correct,`check`,`explain` FROM '.$table[0].' WHERE '.$para.' ID BETWEEN '.$min.' AND '.$max.' ORDER BY `ID` ASC';
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            $arr = array();
            $len = mysqli_num_rows( $result );

            if ( $pieces[4] == '4' ) {

                for ( $i = 0; $i < $len; $i++ ) { 

                    $row = mysqli_fetch_row( $result );
                    echo $row[0].'^'.$row[1].'^'.$row[2].'^'.$row[3].'^'.$row[4].'@';
                    
                }
                
                break;
                
            }

            for ( $i = 0; $i < $len; $i++ ) $arr[] = $i;

            for ( $i = ( $len - 1 ); $i > 0; $i-- ) { 

                $j = mt_rand( 0, $i );
                $tmp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $tmp;

            }

            if ( $pieces[5] > 1 & $len > 5 ) $len = ( $pieces[5] - 1 ) * 5;
            for ( $i = 0; $i < $len; $i++ ) { 

                mysqli_data_seek( $result, $arr[$i] );
                $row = mysqli_fetch_row($result);
                echo $row[0].'^'.$row[1].'^'.$row[2].'^'.$row[3].'^'.$row[4].'@';
                
            }

            if ( $len < 5 ) {

                $query = 'SELECT word,mean,correct,`check`,`explain` FROM '.$table[0].' WHERE ID BETWEEN '.$min.' AND '.$max.' ORDER BY  `ID` ASC';
                $result = mysqli_query( $link, $query );

                for ( $i=0; $i < $pieces[3]; $i++ ) $arr[] = $i;

                for ($i = $pieces[3] - 1; $i > 0; $i--) { 

                    $j = mt_rand( 0, $i );
                    $tmp = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $tmp;

                }

                for ($i=0; $i < ( 5 - $len ); $i++) { 

                    mysqli_data_seek( $result, $arr[$i] );
                    $row = mysqli_fetch_row($result);
                    echo $row[0].'^'.$row[1].'^'.$row[2].'^'.$row[3].'^'.$row[4].'@';

                }

            }

            break;

        case '2':
            $query = 'UPDATE '.$table[0].' SET correct = "1" WHERE word = "'.$pieces[2].'"';
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            break;

        case '3':
            $query = 'UPDATE '.$table[0].' SET `check` = "'.$pieces[3].'" WHERE word = "'.$pieces[2].'"';
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            break;

        case '4':
            $query = 'SELECT * FROM subject';
            $result = mysqli_query( $link, $query );
            if ( ! $result ) die( mysqli_error( $link ) );

            while ( $row = mysqli_fetch_row( $result ) ) {

                $query = 'SELECT correct FROM '.$row[2].' WHERE correct != 0';
                $result1 = mysqli_query( $link, $query );
                if ( ! $result1 ) die( mysqli_error( $link ) );

                $correct = mysqli_num_rows( $result1 );

                $query = 'SELECT ID FROM '.$row[2];
                $result2 = mysqli_query( $link, $query );
                if ( ! $result2 ) die( mysqli_error( $link ) );

                $all = mysqli_num_rows( $result2 );

                echo $row[1].'/'.$row[2].'/'.$correct.'/'.$all.'/'.$row[3].'/'.$row[4].'/'.$row[5].',';

            }

            break;

    }

 ?>