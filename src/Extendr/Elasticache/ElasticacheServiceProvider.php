<?php namespace Extendr\Elasticache;

use Illuminate\Support\ServiceProvider;

class ElasticacheServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['elasticache'] = $this->app->share(function($app)
		{
			return new ElastiCacheManager($app);
		});

		$this->app['elasticache.connector'] = $this->app->share(function()
		{
			return new ElastiCacheConnector;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('elasticache.connector');
	}

}
