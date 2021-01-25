<?php
// Before removing this file, please verify the PHP ini setting `auto_prepend_file` does not point to this.

// This file was the current value of auto_prepend_file during the Wordfence WAF installation (Tue, 05 Jan 2021 22:05:18 +0000)
if (file_exists('C:\\wamp64\\www\\school/wordfence-waf.php')) {
	include_once 'C:\\wamp64\\www\\school/wordfence-waf.php';
}
if (file_exists('C:\\wamp64\\www\\school\\wp-content\\plugins\\wordfence/waf/bootstrap.php')) {
	define("WFWAF_LOG_PATH", 'C:\\wamp64\\www\\school/wp-content/wflogs/');
	include_once 'C:\\wamp64\\www\\school\\wp-content\\plugins\\wordfence/waf/bootstrap.php';
}
?>