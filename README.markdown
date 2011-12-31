# Simple PHP Cache #

## About ##

A light, simple but powerful PHP5 Cache Class which uses the filesystem for caching.  
Your feedback is always welcome.

> This is a first Alpha version!

## Requirements ##

- PHP 5.2.x or higher

## Introduction ##

Basically the caching class stores its data in files in the JSON format. These files will be created if you store data under a Cache name.

If you set a new Cache name with `setCache()`, a new cache file will be generated. The Cache will store all further data in the new file. The Setter method allows you to switch between the differnet Cache files.

## Quick Start ##

### Setup Cache class ###

It's not much trouble to setup the Cache.  
First create a writable directory `cache/` and include the Cache class:

    <?php
        require_once 'cache.class.php';
        
        // Setup 'default' Cache
        $c = new Cache();
    ?>

Now we've setup the Cache instance and can start caching!  

    <?php
        // Store a string
        $c->store('hello', 'Hello World!');
        
        // Generate a new Cache file with the name 'newcache'
        $c->setCache('newcache');
        
        // Store an array
        $c->store('movies', array(
          'description' => 'Movies I like',
          'Action' => array(
            'Tropic Thunder',
            'Bad Boys',
            'Crank'
          )
        ));
        
        // Get cached data by its key
        $result = $c->retrieve('movies');
        
          // Display the cached array
          echo '<pre>';
          print_r($result);
          echo '<pre>';
        
        // Switch back to the first Cache
        $c->setCache('mycache');
        
        // Update entry simply by overwriting an existing key
        $c->store('hello', 'Hello everybody out there!');
        
        // Erase entry by its key
        $c->erase('hello');
    ?>

You can also make use of the Method Chaining feature, introduced in PHP5.  
So you can do something like that:

    <?php
        $c->setCache('mycache')      // Generate new file
          ->store('hello', 'world')  // Store data sting
          ->retrieve('hello');       // Retrieve cached data
    ?>

## Available methods ##

### Setup the Cache ###

`new Cache(<array>/<string>)`  

`string` gives you the basic setup.  
It's the name of your Cache (standard Cache name is *'default'*):

    new Cache('YOUR-CACHE-NAME');

`array` allows you to define multiple optional parameters:

    new Cache(array(
      'name'      => 'YOUR-CACHE-NAME',
      'path'      => 'cache/',
      'extension' => '.cache'
    ));

If you don't define a Cache name with the constructor or the `setCache()` method, it'll be 'default'.

### Store data ###

`store($key, $data, <$expiration>)`

- The `key` value defines a tag with which the cached data will be associated.
- The `data` value can either be a *string* or an *array*.
- The `expiration` value allows you to define a expiration time.

To change data you can override it by using the same key identifier.  
Beside the data, the Cache will also store a timestamp.

A sample Cache entry looks like this:

    {
      "christmas": {
        "time": 1324664631,
        "expire" => 28000,
        "data": "A great time to bake cookies."
      }
    }

### Retrieve data ###

`retrieve($key, <true>/<false>)`  

Get cached data or time by its key.  
To retrieve the timestamp of a key, set the second parameter to `true`.

### Erase data ###

For erasing cached data are these three methods available:

- `erase($key)` Erases a single entry by its key.
- `eraseExpired()` Erases all expired entries.

    // Returns the count of erased entries
    echo $c->eraseExpired().' expired items erased!';

- `eraseAll()` Erases all entries from the Cache file.

### Check cached data ###

`isCached($key)`  

Check whether any data is accociated with the given key.  
Returns `true` or `false`.

### Set Cache name ###

`setCache($name)`  

If you want to switch to another Cache or create a new one, then use this method to set a new Cache name.

### Set Cache path ###

`setCachePath($path)`  

The path to the Cache folder must end with a backslash: `my_path_to_the_cache_folder/`

### Get Cache file path ###

`getCacheDir()`  

The method returns the path to your current Cache file (the Cache name is always sh1 encoded):

    cache/7505d64a54e061b7acd54ccd58b49dc43500b635.cache

## Benchmarks ##

*Coming soon...*

> If you've done one, please let me know.

## History ##

**Simple Cache 1.1 - 01/01/2012**

- `change` The extension config has to start now with a dot.
- `feature` Added expiration handling to the `store()` method
- `feature` Added the methods `eraseExpired()` and `eraseAll()`
- `feature` Added method to make sure that a writable directory exists

**Simple Cache 1.0 - 29/12/2011**

- `release` First public version
- `feature` Added timestamp option to the `retrieve()` method

**Simple Cache 0.9 - 25/12/2011**

- `update` Added Quick Start guide to the documentation
- `feature` Added Method Chaining possibility
- `bug` Fixed constructor configuration string/array handling

**Simple Cache 0.8 - 24/12/2011**

- `release` First internal beta version (tested)
- `feature` Added Setter and Getter methods
- `update` Detailed documentation

**Simple Cache 0.5 - 22/12/2011**

- `release` First internal alpha version
- `update` Small documentation

## Credits ##

Copyright (c) 2011/12 - Programmed by Christian Metz / @cosenary[http://twitter.com/cosenary](http://twitter.com/cosenary)  
Released under the [BSD License](http://www.opensource.org/licenses/bsd-license.php).