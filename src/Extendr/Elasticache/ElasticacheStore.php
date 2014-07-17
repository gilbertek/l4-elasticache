<?php namespace Extendr\Elasticache;

use Memcache;

/**
* ElasticacheStore
*/
class ElasticacheStore extends \Illuminate\Cache\TaggableStore implements \Illuminate\Cache\StoreInterface
{

	/**
	 * The memcache instance.
	 *
	 * @var \memcache
	 */
	protected $memcache;

	/**
	 * A string that should be prepended to keys.
	 *
	 * @var string
	 */
	protected $prefix;

	/**
	 * Create a new memcache store.
	 *
	 * @param  \memcache  $memcache
	 * @param  string     $prefix
	 * @return void
	 */
	public function __construct(Memcache $memcache, $prefix = '')
	{
		$this->memcache = $memcache;
		$this->prefix = strlen($prefix) > 0 ? $prefix.':' : '';
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @access public
	 * @param mixed $key
	 * @param mixed $default (default: null)
	 * @param int $minutes (default: 30)
	 * @return void
	 */
	public function get($key, $default = null, $minutes = 30)
	{
		if($value = $this->memcache->get($this->prefix.$key)) {

			return $value;
		}

		if(!is_null($default)) {

			$this->memcache->set($this->prefix.$key, $default, $minutes);

			return $default;
		}
	}

	/**
	 * Store an item in the cache for a given number of minutes.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  int     $minutes
	 * @return void
	 */
	public function put($key, $value, $minutes)
	{
		$this->memcache->set($this->prefix.$key, $value, 0, $minutes * 60);
	}

	/**
	 * Increment the value of an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function increment($key, $value = 1)
	{
		return $this->memcache->increment($this->prefix.$key, $value);
	}

	/**
	 * Decrement the value of an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function decrement($key, $value = 1)
	{
		return $this->memcache->decrement($this->prefix.$key, $value);
	}

	/**
	 * Store an item in the cache indefinitely.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function forever($key, $value)
	{
		return $this->put($key, $value, 0);
	}

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function forget($key)
	{
		$this->memcache->delete($this->prefix.$key);
	}

	/**
	 * Remove all items from the cache.
	 *
	 * @return void
	 */
	public function flush()
	{
		$this->memcache->flush();
	}

	/**
	 * Get the underlying memcache connection.
	 *
	 * @return \memcache
	 */
	public function getMemcache()
	{
		return $this->memcache;
	}

	/**
	 * Get the cache key prefix.
	 *
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}
}