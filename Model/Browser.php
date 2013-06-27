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
        if ($this->name != ucwords($name)) {
            return false;
        }

        return $version !== null ? $this->version == $version : true;
    }

    /**
     * Test if the browser matches this name and version requirements
     * @param  string   $name   The browser name
     * @param  array    $req    The version requirements
     * @return boolean
     */
    public function matches($name, $req)
    {
        if (!$this->is($name)) {
            return false;
        }

        if (isset($req['test']) && isset($req['version']) && !empty($req['version']) && method_exists($this, $req['test'])) {
            return $this->{$req['test']}($req['version']);
        }

        return true;
    }

    /**
     * Is exactly
     * @param  string  $version Browser version
     * @return boolean          Result
     */
    public function isExactly($version)
    {
        return $this->version == $version;
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
