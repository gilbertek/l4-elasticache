<?php  namespace Extendr\Elasticache;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\Manager;

/**
 * ElasticacheManager
 */


class ElasticacheManager extends CacheManager {

	/**
     * Create an instance of the Memcached cache driver.
     *
     * @return \Illuminate\Cache\MemcachedStore
     */
    protected function createMemcacheDriver()
	{
		$servers = $this->app['config']['cache.memcache'];

		$memcache = $this->app['elasticache.connector']->connect($servers);

		return $this->repository(new ElasticacheStore($memcache, $this->getPrefix()));
	}

}