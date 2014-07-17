<?php namespace Extendr\Elasticache;
// namespace Illuminate\Cache;
use Illuminate\Cache;
use Memcache;

/**
*
*/
class ElasticacheConnector
{
	/**
	 * Create a new Memcache connection.
	 *
	 * @param array  $servers
	 * @return \Memcache
	 */
	public function connect(array $servers)
	{

		$memcache = $this->getMemcache();

		// Set Elasticache options here
		if (defined('\Memcache::OPT_CLIENT_MODE') && defined('\Memcache::DYNAMIC_CLIENT_MODE')) {
			$memcached->setOption(\Memcache::OPT_CLIENT_MODE, \Memcache::DYNAMIC_CLIENT_MODE);
		}


		// For each server in the array, we'll just extract the configuration and add
		// the server to the Memcached connection. Once we have added all of these
		// servers we'll verify the connection is successful and return it back.
		foreach ($servers as $server)
		{
			$memcache->addServer($server['host'], $server['port'], $server['weight']);
		}

		if ($memcache->getVersion() === false)
		{
			throw new \RuntimeException("Could not establish Memcache connection.");
		}

		return $memcache;
	}

	/**
	 * Get a new Memcache instance.
	 *
	 * @return \Memcache
	 */
	protected function getMemcache()
	{
		return new Memcache;
	}

}