<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Test for PMA_warnMissingExtension() from libraries/core.lib.php
 * PMA_warnMissingExtension warns or fails on missing extension.
 *
 * @package PhpMyAdmin-test
 */

/*
 * Include to test.
 */
require_once 'libraries/core.lib.php';

class PMA_warnMissingExtension_test extends PHPUnit_Framework_TestCase
{

    protected function setUp() {
        require_once './libraries/Error_Handler.class.php';
        $GLOBALS['error_handler'] = new PMA_Error_Handler();
    }

    function testMissingExtentionFatal(){
        $ext = 'php_ext';
        $warn = 'The <a href="' . PMA_getPHPDocLink('book.' . $ext . '.php') . '" target="Documentation"><em>'.$ext.'</em></a> extension is missing. Please check your PHP configuration.';

        ob_start();
        PMA_warnMissingExtension($ext, true);
        $printed = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThan(0, strpos($printed, $warn));
    }

    function testMissingExtentionFatalWithExtra(){
        $ext = 'php_ext';
        $extra = 'Appended Extra String';

        $warn = 'The <a href="' . PMA_getPHPDocLink('book.' . $ext . '.php') . '" target="Documentation"><em>'.$ext.'</em></a> extension is missing. Please check your PHP configuration.'.' '.$extra;

        ob_start();
        PMA_warnMissingExtension($ext, true, $extra);
        $printed = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThan(0, strpos($printed, $warn));
    }
}
