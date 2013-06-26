<?php

namespace Elao\BrowserDetectorBundle\Service;

use Elao\BrowserDetectorBundle\Model\Browser;

/**
 * Browser Detector service
 */
class BrowserDetector
{
    /**
     * Is Browscap enabled
     * @var boolean
     */
    private $browscapEnabled;

    /**
     * Constructor
     * @param boolean $browscapEnabled Is browscap enabled
     */
    public function __construct($browscapEnabled)
    {
        $this->browscapEnabled = $browscapEnabled;
    }

    /**
     * Get browser name based on User-Agent directive
     * @param  string $userAgent The user-agent directive
     * @return string            The browser name
     */
    public function getBrowser($userAgent)
    {
        if ($this->browscapEnabled) {
            return new Browser(get_browser($userAgent, true));
        } else {
            return false;
        }
    }
}
