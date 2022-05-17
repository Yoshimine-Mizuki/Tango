<?php header( 'Content-Type:text/html;charset=utf-8' ); ?>

<?php
    $name = ( string )filter_input( INPUT_POST, 'data' );

    $to = 'yosimine0503@gmail.com';
    $subject = 'フィードバック';
    $message = $name;

    mb_language( 'Japanese' );
    mb_internal_encoding( 'UTF-8' );

    mb_send_mail( $to, $subject, $message );

    if ( $name == '0' ) {

        print( file_get_contents( 'code/sample.js' ) );

    } else {

        $url = 'mysql1.webcrow-php.netowl.jp';
        $user = 'astrongame_db';
        $password = 'Unlock';

        $link = mysqli_connect( $url, $user, $password );
        if ( ! $link ) die( mysql_error() );

        $db_selected = mysqli_select_db($link, $user);
        if ( ! $db_selected ) die( mysql_error() );

        mysqli_set_charset( $link, 'utf8' );

        $query = 'SELECT filename FROM store WHERE ID = '.$name;
        $result = mysqli_query( $link, $query );
        if ( ! $result ) die( mysqli_error( $link ) );

        $filename =  mysqli_fetch_row( $result );

        print( file_get_contents( 'code/'.$filename[0] ) );

    }
    
 ?>