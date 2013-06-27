Elao Browser Detector Bundle
========================

Installation:
-------------
Require the bundle via composer:

    "require": {
		"elao/browser-detector": "2.3.x-dev"
	}


Add the bundle to your AppKernel.php:

	new Elao\BrowserDetectorBundle\ElaoBrowserDetectorBundle()
	
Configuration:
--------------
Register the browsers that are not and/or partially supported by your application:

	elao_browser_detector:
    	browsers:
        	partially_compatible:
            	"Internet Explorer": "<9"
           		"Opera"
        	incompatible:
           		"Internet Explorer": "<=7"
           		
Accepted version prefix :

-	none : exact version number, ex: "Firefox": '3.6' (only Firefox 3.6 will match)
-	'<' : strictly earlier, ex: "Firefox": '<3.6' (Firefox 3.6 will not match, Firefox 3.7 will)
-	'>' : strictly later, ex: "Firefox": '>3.6' (Firefox 3.6 will not match, Firefox 3.5 will)
-	'<=' : exacte version number, ex: "Firefox": '<=3.6' (Firefox 3.6 and 3.5 will match)
-	'>=' : exacte version number, ex: "Firefox": '>=3.6' (Firefox 3.6 and 3.7 will match)


How it works:
-------------
-	The bundle listen to the *kernel.request* event.
-	It gets the *user-agent* http header directive from the request on each master request.
-	It use the php [get_browser](http://php.net/manual/function.get-browser.php) function (based on the [browscap.ini](http://tempdownloads.browserscap.com/) file) to detect wich browser is used.
-	It instantiate an _Elao\BrowserDetectorBundle\Model\\**Browser**_ object that will resolve compatibility of the current browser based your configuration.

Usage:
------
### The BrowserDetector service
Get the BrowserDetector service or have it injected in your service: **elao.browser_detector**

	$browserDetector = $container->get('elao.browser_detector');
	// or
	<argument type="service" id="elao.browser_detector" />

You're now able to get some compatibility information from the BrowserDetector service:

	// Compatibility issers :
	$browserDetector->isCompatible();
	$browserDetector->isPartiallyCompatible();
	$browserDetector->isIncompatible();
	
### Accessing the current Browser instance

If needed, you can work with the Browser object that provide a various set of helpers methods:

	// Get the current Browser instance:
	$browser = $browserDetector->getBrowser();
	
	// Get the Name of the browser, ex: 'Firefox'
	$browser->getName();
	
	// Get the Version of the browser, ex: '22.0'
	$browser->getVersion();
	
	// Get the platform of the browser, ex: 'MacOsX'
	$browser->getPlatform();
	
	// Compatibility issers:
	is(string $name, int $version = null)
	isPlatform(string $platform)
	isLaterThan(int $version)
	isEqualOrLaterThan(int $version)
	isEarlierThan(int $version)
	isEqualOrEarlierThan(int $version)