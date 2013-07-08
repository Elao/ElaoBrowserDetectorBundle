<?php

namespace Elao\BrowserDetectorBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Elao\BrowserDetectorBundle\Model\Browser;

/**
 * Browser Detector service
 */
class BrowserDetector
{
    const BROWSER_INCOMPATIBLE         = 0;
    const BROWSER_PARTIALLY_COMPATIBLE = 1;
    const BROWSER_COMPATIBLE           = 2;

    /**
     * Is Browscap enabled
     * @var boolean
     */
    private $browscapEnabled;

    /**
     * Browser
     * @var Browser
     */
    private $browser;

    /**
     * Browsers requirements
     * @var array
     */
    private $requirements;

    /**
     * Browser compatibility
     * @var boolean
     */
    private $compatibility;

    /**
     * Constructor
     * @param boolean $browscapEnabled Is browscap enabled
     */
    public function __construct($browscapEnabled)
    {
        $this->browscapEnabled = $browscapEnabled;
        $this->browser         = new Browser();
        $this->requirements    = array(
            'incompatible'         => array(),
            'partially_compatible' => array(),
        );
    }

    public function loadConfiguration($config)
    {
        foreach ($config as $support => $requirement) {
            foreach ($requirement as $name => $version) {
                $this->requirements[$support][ucwords($name)] = $this->parseVersion($version);
            }
        }
    }

    public function parseVersion($version)
    {
        if (!empty($version) && preg_match('/^([<>]=?)?(.+)/', $version, $matches)) {
            $versionNumber = floatval($matches[2]);

            switch ($matches[1]) {
                case '<=':
                    $test = 'isEqualOrEarlierThan';
                    break;
                case '<':
                    $test = 'isEarlierThan';
                    break;
                case '>=':
                    $test = 'isEqualOrLaterThan';
                    break;
                case '>':
                    $test = 'isLaterThan';
                    break;
                default:
                    $test = 'isExactly';
                    break;
            }

            return array(
                'test'    => $test,
                'version' => $versionNumber,
            );
        } else {
            return array();
        }
    }

    /**
     * Set the request
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->setBrowser($this->createBrowserFromRequest($request));
    }

    /**
     * Create Browser from Request
     * @param  Request $request
     * @return Browser
     */
    public function createBrowserFromRequest(Request $request)
    {
        return $this->createBrowserFromUserAgent($request->headers->get('user-agent'));
    }

    /**
     * Create Browser from user-agent directive
     * @param  string $request
     * @return Browser
     */
    public function createBrowserFromUserAgent($userAgent)
    {
        $data = $this->browscapEnabled ? get_browser($userAgent, true) : array();

        return new Browser($data);
    }

    /**
     * Get the current Browser
     * @return Browser
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    public function setBrowser($browser)
    {
        $this->browser       = $browser;
        $this->compatibility = self::BROWSER_COMPATIBLE;

        foreach ($this->requirements['incompatible'] as $browser => $req) {
            if ($this->browser->matches($browser, $req)) {
                $this->compatibility = self::BROWSER_INCOMPATIBLE;
                break;
            }
        }

        if ($this->compatibility !== self::BROWSER_INCOMPATIBLE) {
            foreach ($this->requirements['partially_compatible'] as $browser => $req) {
                if ($this->browser->matches($browser, $req)) {
                    $this->compatibility = self::BROWSER_PARTIALLY_COMPATIBLE;
                    break;
                }
            }
        }
    }

    /**
     * Is the current browser compatible ?
     * @return boolean
     */
    public function isCompatible()
    {
        return $this->compatibility === self::BROWSER_COMPATIBLE;
    }

    /**
     * Is the current browser partially compatible ?
     * @return boolean
     */
    public function isPartiallyCompatible()
    {
        return $this->compatibility === self::BROWSER_PARTIALLY_COMPATIBLE;
    }

    /**
     * Is the current browser incompatible ?
     * @return boolean
     */
    public function isIncompatible()
    {
        return $this->compatibility === self::BROWSER_INCOMPATIBLE;
    }
}
