<?php

namespace Hiraeth\Mime;

use Mimey;
use Hiraeth;

/**
 *
 */
class MimeTypesDelegate implements Hiraeth\Delegate
{
	/**
	 * Get the class for which the delegate operates.
	 *
	 * @static
	 * @access public
	 * @return string The class for which the delegate operates
	 */
	static public function getClass(): string
	{
		return Mimey\MimeTypes::class;
	}


	/**
	 *
	 */
	public function __construct(Hiraeth\Application $app)
	{
		$this->app = $app;
	}


	/**
	 * Get the instance of the class for which the delegate operates.
	 *
	 * @access public
	 * @param Hiraeth\Broker $broker The dependency injector instance
	 * @return object The instance of the class for which the delegate operates
	 */
	public function __invoke(Hiraeth\Broker $broker): object
	{
		$builder = Mimey\MimeMappingBuilder::create();

		foreach ($this->app->getConfig('*', 'mime.types', []) as $types) {
			foreach ($types as $extension => $mime_type) {
				$builder->add($mime_type, $extension);
			}
		}

		return new Mimey\MimeTypes($builder->getMapping());
	}
}
