<?php
require "ExternalLibr/crawler-detect/src/Fixtures/AbstractProvider.php";
require "ExternalLibr/crawler-detect/src/Fixtures/Exclusions.php";
require "ExternalLibr/crawler-detect/src/Fixtures/Crawlers.php";
require "ExternalLibr/crawler-detect/src/Fixtures/Headers.php";
require "ExternalLibr/crawler-detect/src/CrawlerDetect.php";
require "ExternalLibr/mobiledetectlib/Mobile_Detect.php";
require "ExternalLibr/agent/src/Agent.php";


use Jenssegers\Agent\Agent;
//use Jaybizzle\CrawlerDetect\Fixtures;
$xeAgent = new Agent();
$is_desktop = $xeAgent->isDesktop();
$is_phone = $xeAgent->isPhone();
$is_robot = $xeAgent->isRobot();

$is_browser = $xeAgent->browser();
$is_version_b = $xeAgent->version($is_browser);

$is_platform = $xeAgent->platform();
$is_version_p = $xeAgent->version($is_platform);

$is_device = $xeAgent->device(); // works on mobile
$is_languages = $xeAgent->languages();

$is_tablet = $xeAgent->isTablet();
$is_mobile = $xeAgent->isMobile();
//$xeAgent->isAndroidOS();
//$xeAgent->isNexus();
//$xeAgent->isSafari();

//$xeAgent->is('Windows');
//$xeAgent->is('Firefox');
//$xeAgent->is('iPhone');
//$xeAgent->is('OS X');
?>