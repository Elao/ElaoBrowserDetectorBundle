<?php

namespace Elao\BrowserDetectorBundle\Model;

/**
 * Browser model
 */
class Browser
{
    private $name;

    /**
     * Constructor
     * @param array $data Browser data
     */
    public function __construct($data = array())
    {
        if (isset($data['browser'])) {
            $this->name = ucwords($data['browser']);
        }

        if (isset($data['platform'])) {
            $this->platform = ucwords($data['platform']);
        }

        if (isset($data['version'])) {
            $this->version = $data['version'];
        }
    }

    /**
     * Get the name of the Browser
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the version of the Browser
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the platform of the Browser
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Is exactly
     * @param  string  $name    Browser name
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function is($name, $version = null)
    {
        return $version !== null ? $this->version == $version : true;
    }

    /**
     * Is later than
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isLaterThan($version)
    {
        return $this->version > $version;
    }

    /**
     * Is later than or equal
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isEqualOrLaterThan($version)
    {
        return $this->version >= $version;
    }

    /**
     * Is earlier than
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isEarlierThan($version)
    {
        return $this->version < $version;
    }

    /**
     * Is earlier than or equal
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isEqualOrEarlierThan($version)
    {
        return $this->version <= $version;
    }

    /**
     * Test if the browser platform matches the given platform
     * @param  string  $platform The platform to match
     * @return boolean
     */
    public function isPlatform($platform)
    {
        return $this->platform == ucwords($platform);
    }
}
