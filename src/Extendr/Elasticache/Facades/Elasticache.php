<?php namespace Extendr\Elasticache\Facades;

use Illuminate\Support\Facades\Facade;

/**
* ExtendedCache
*/
class ElastiCache extends Facade
{
	/**
     * Get the registered name of the component.
     *
     * @return string
     */
	protected static function getFacadeAccessor() { return 'elasticache'; }
}