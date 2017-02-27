<?php
/**
 * URL redirector to avoid leaking Referer with some sensitive information.
 */

require_once './libraries/core.lib.php';
require_once './libraries/php-gettext/gettext.inc';

/**
 * Gets core libraries and defines some variables
define('PMA_MINIMUM_COMMON', true);
require_once './libraries/common.inc.php';
/**
 * JavaScript escaping.
 */
require_once './libraries/js_escape.lib.php';

if (! PMA_isValid($_GET['url'])
    || ! preg_match('/^https?:\/\/[^\n\r]*$/', $_GET['url'])
    || ! PMA_isAllowedDomain($_GET['url'])
) {
    header('Location: ' . $cfg['PmaAbsoluteUri']);
} else {
    // JavaScript redirection is necessary. Because if header() is used
    //  then web browser sometimes does not change the HTTP_REFERER
    //  field and so with old URL as Referer, token also goes to
    //  external site.
    $url = htmlspecialchars($_GET['url']);
    echo "<script type='text/javascript'>
            window.onload=function(){
                window.location='" . PMA_escapeJsString($_GET['url']) . "';
            }
        </script><noscript><meta http-equiv='refresh' content='0;url=$url' /></noscript>";
    // Display redirecting msg on screen.
    printf(__('Taking you to <a href="%s">%s</a>.'), $url, $url);
}
die();
?>