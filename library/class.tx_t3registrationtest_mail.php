<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 15/10/12
 * Time: 12:42
 * To change this template use File | Settings | File Templates.
 */
class tx_t3registrationtest_mail {

    protected $host;

    protected $username;

    protected $password;

    public function initialize() {
        $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3registration_test']);
        $this->host = '{' . $configuration['pop3Server'] . ':143/imap}INBOX';
        $this->username = $configuration['pop3Username'];
        $this->password = $configuration['pop3Password'];
        debug($configuration);
    }

    public function searchForIncomingEmailByGUID($guid) {
        /* try to connect */
        debug($this->host);
        debug($this->username);
        debug($this->password);
        $inbox = imap_open($this->host, $this->username, $this->password) or die('Cannot connect to Gmail: ' . imap_last_error());

        /* grab emails */
        $emails = imap_search($inbox, 'ALL');
        debug($guid);

        /* if emails are returned, cycle through each... */
        if ($emails) {

            /* begin output var */
            $output = '';

            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach ($emails as $email_number) {

                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox, $email_number, 0);
                debug($overview);

                if (preg_match('/GUID=([a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4})/iUs',$overview[0]->subject)) {
                    $message = imap_fetchbody($inbox, $email_number, 2);
                    $message = quoted_printable_decode($message);
                    if (strstr($message, 'T3Registration Staff')) {
                        /* output the email header information */
                        $output .= '<div class="toggler ' . ($overview[0]->seen ? 'read' : 'unread') . '">';
                        $output .= '<span class="subject">' . $overview[0]->subject . '</span> ';
                        $output .= '<span class="from">' . $overview[0]->from . '</span>';
                        $output .= '<span class="date">on ' . $overview[0]->date . '</span>';
                        $output .= '</div>';

                        /* output the email body */
                        $output .= '<div class="body">' . $message . '</div>';


                    }
                    debug($message);
                }

            }

            /* close the connection */
            imap_close($inbox);
            exit;
        }
    }

}
