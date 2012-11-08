<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 02/09/12
 * Time: 19:38
 * To change this template use File | Settings | File Templates.
 */

/* connect to gmail */
$hostname = '{mail.immaginario.com:143/imap}INBOX';
$username = 'apptest@t3registration.com';
$password = 'foxtrot1973';
/*$hostname = '{imap.gmail.com:993/ssl/novalidate-cert}';
$username = 'apptest@bernardin.it';
$password = 'foxtrot1973';*/


/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* grab emails */
$emails = imap_search($inbox,'ALL');

/* if emails are returned, cycle through each... */
if($emails) {

    /* begin output var */
    $output = '';

    /* put the newest emails on top */
    rsort($emails);

    /* for every email... */
    foreach($emails as $email_number) {

        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox,$email_number,0);
        $message = imap_fetchbody($inbox,$email_number,2);
        $message = quoted_printable_decode($message);
        if(strstr($message,'T3Registration Staff')){
        /* output the email header information */
        $output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
        $output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
        $output.= '<span class="from">'.$overview[0]->from.'</span>';
        $output.= '<span class="date">on '.$overview[0]->date.'</span>';
        $output.= '</div>';

        /* output the email body */
        $output.= '<div class="body">'.$message.'</div>';
        }
    }

    echo $output;
}

/* close the connection */
imap_close($inbox);
