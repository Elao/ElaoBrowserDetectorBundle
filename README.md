Elao BrowserDetector Bundle
===========================

## Deprecated : please use https://github.com/piwik/device-detector instead.

## Changelog

* 1.1.0
	* BrowserCap and Browser ar now in a separate **ElaoBrowserDetector** component
	* Rename some parameters
	* Fix composer

Installation:
-------------
Require the bundle via composer:

    "require": {
		"elao/browser-detector-bundle": "1.1.*"
	}


Add the bundle to your AppKernel.php:

	new Elao\Bundle\BrowserDetectorBundle\ElaoBrowserDetectorBundle()

Configuration:
--------------
Register the browsers that are not and/or partially supported by your application:

	elao_browser_detector:
    	browsers:
        	partially_compatible:
            	"Internet Explorer": "<9"
           		"Opera": ~
        	incompatible:
           		"IE": "<=7"

Accepted version format:

-   none : any version number, ex: "Firefox": ~ (any Firefox version will match)
-	'n' : exact version number, ex: "Firefox": '3.6' (only Firefox 3.6 will match)
-	'>n' : strictly later, ex: "Firefox": '>3.6' (Firefox 3.6 will not match, Firefox 3.7 will)
-	'<n' : strictly earlier, ex: "Firefox": '<3.6' (Firefox 3.6 will not match, Firefox 3.5 will)
-	'>=n' : equal or later version, ex: "Firefox": '>=3.6' (Firefox 3.6 and 3.7 will match)
-   '<=n' : equal or earlier version, ex: "Firefox": '<=3.6' (Firefox 3.6 and 3.5 will match)


How it works:
-------------
-	The bundle listen to the *kernel.request* event.
-	It gets the *user-agent* http header directive from the request on each master request.
-	It use the php [get_browser](http://php.net/manual/function.get-browser.php) function (based on the [browscap.ini](http://tempdownloads.browserscap.com/) file) to detect wich browser is used.
-	It instantiate an _Elao\BrowserDetector\\**Browser**_ object that will resolve compatibility of the current browser based your configuration.

Usage:
------
### The BrowserDetector service
Get the BrowserDetector service or have it injected in your service: **elao.browser_detector**

	$browserDetector = $container->get('elao_browser_detector');
	// or
	<argument type="service" id="elao_browser_detector" />

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
    isExactly(int $version)
	isLaterThan(int $version)
	isEqualOrLaterThan(int $version)
	isEarlierThan(int $version)
	isEqualOrEarlierThan(int $version)
