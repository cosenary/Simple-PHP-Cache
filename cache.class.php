<?php

/**
 * Simple Cache class
 * API Documentation:
 *
 * @author Christian Metz
 * @since 22.12.2011
 * @copyright Christian Metz - MetzWeb Networks
 * @version 1.0
 */

class Cache {

  /**
   * The path to the cache file folder
   *
   * @var string
   */
  private $_cachepath = 'cache/';

  /**
   * The name of the default cache file
   *
   * @var string
   */
  private $_cachename = 'default';

  /**
   * The cache file extension
   *
   * @var string
   */
  private $_extension = 'cache';

  /**
   * Default constructor
   *
   * @param string/array [optional] $config
   * @return void
   */
  public function __construct($config = null) {
    if (true === isset($config)) {
      if (is_string($config)) {
        $this->setCache($config);
      } else if (is_array($config)) {
        $this->setCache($config['name']);
        $this->setCachePath($config['path']);
        $this->setExtension($config['extension']);
      }
    }
  }

  /**
   * Check whether data accociated with a key
   *
   * @param string $key
   * @return boolean
   */
  public function isCached($key) {
    if (true === $this->_loadCache()) {
      $cachedData = $this->_loadCache();
      return isset($cachedData[$key]['data']);
    }
  }

  /**
   * Store data in the cache
   *
   * @param string $key
   * @param mixed $data
   * @return object
   */
  public function store($key, $data) {
    $storeData = array(
      'time' => time(),
      'data' => $data
    );
    if (true === is_array($this->_loadCache())) {
      $dataArray = $this->_loadCache();
      $dataArray[$key] = $storeData;
    } else {
      $dataArray = array($key => $storeData);
    }
    $cacheData = json_encode($dataArray);
    file_put_contents($this->getCacheDir(), $cacheData);
    return $this;
  }

  /**
   * Retrieve cached data by its key
   * 
   * @param string $key
   * @param boolean [optional] $timestamp
   * @return string
   */
  public function retrieve($key, $timestamp = false) {
    $cachedData = $this->_loadCache();
    (false === $timestamp) ? $type = 'data' : $type = 'time';
    return $cachedData[$key][$type];
  }

  /**
   * Erase cached entry by its key
   * 
   * @param string $key
   * @return object
   */
  public function erase($key) {
    if (true === is_array($this->_loadCache())) {
      $cacheData = $this->_loadCache();
      if (true === isset($cacheData[$key])) {
        unset($cacheData[$key]);
        $cacheData = json_encode($cacheData);
        file_put_contents($this->getCacheDir(), $cacheData);
      } else {
        throw new Exception("Error: erase() - Key '{$key}' not found.");
      }
    }
    return $this;
  }

  /**
   * Load appointed cache
   * 
   * @return mixed
   */
  private function _loadCache() {
    if (true === file_exists($this->getCacheDir())) {
      $file = file_get_contents($this->getCacheDir());
      return json_decode($file, true);
    } else {
      return false;
    }
  }

  /**
   * Get the cache directory path
   * 
   * @return string
   */
  public function getCacheDir() {
    $filename = $this->getCache();
    $filename = preg_replace('/[^0-9a-z\.\_\-]/i', '', strtolower($filename));
    return $this->getCachePath().$this->_getHash($filename).'.'.$this->getExtension();
  }

  /**
   * Get the filename hash
   * 
   * @return string
   */
  private function _getHash($filename) {
    return sha1($filename);
  }

  /**
   * Cache path Setter
   * 
   * @param string $path
   * @return object
   */
  public function setCachePath($path) {
    $this->_cachepath = $path;
    return $this;
  }

  /**
   * Cache path Getter
   * 
   * @return string
   */
  public function getCachePath() {
    return $this->_cachepath;
  }

  /**
   * Cache name Setter
   * 
   * @param string $name
   * @return object
   */
  public function setCache($name) {
    $this->_cachename = $name;
    return $this;
  }

  /**
   * Cache name Getter
   * 
   * @return void
   */
  public function getCache() {
    return $this->_cachename;
  }

  /**
   * Cache file extension Setter
   * 
   * @param string $ext
   * @return object
   */
  public function setExtension($ext) {
    $this->_extension = $ext;
    return $this;
  }

  /**
   * Cache file extension Getter
   * 
   * @return string
   */
  public function getExtension() {
    return $this->_extension;
  }
}

?>