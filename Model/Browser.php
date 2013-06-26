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
    public function __construct($data)
    {
        $this->name       = ucwords($data['browser']);
        $this->platform   = ucwords($data['platform']);
        $this->version    = $data['version'];
        /*$this->cookies    = $data['cookies'] === '1';
        $this->javascript = $data['javascript'] === '1';
        $this->cssVersion = $data['cssversion'];*/
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
        if ($this->name != ucwords($name)) {
            return false;
        }

        return $version !== null ? $this->version == $version : true;
    }

    /**
     * Is later than
     * @param  string  $name    Browser name
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isLaterThan($name, $version)
    {
        if ($this->name != ucwords($name)) {
            return false;
        }

        return $this->version > $version;
    }

    /**
     * Is later than or equal
     * @param  string  $name    Browser name
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isEqualOrLaterThan($name, $version)
    {
        if ($this->name != ucwords($name)) {
            return false;
        }

        return $this->version >= $version;
    }

    /**
     * Is earlier than
     * @param  string  $name    Browser name
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isEarlierThan($name, $version)
    {
        if ($this->name != ucwords($name)) {
            return false;
        }

        return $this->version < $version;
    }

    /**
     * Is earlier than or equal
     * @param  string  $name    Browser name
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isEqualOrEarlierThan($name, $version)
    {
        if ($this->name != ucwords($name)) {
            return false;
        }

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
