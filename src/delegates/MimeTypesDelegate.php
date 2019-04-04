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
	 * Get the instance of the class for which the delegate operates.
	 *
	 * @access public
	 * @param Hiraeth\Application $app The application instance for which the delegate operates
	 * @return object The instance of the class for which the delegate operates
	 */
	public function __invoke(Hiraeth\Application $app): object
	{
		$builder = Mimey\MimeMappingBuilder::create();

		foreach ($app->getConfig('*', 'mime.types', []) as $types) {
			foreach ($types as $extension => $mime_type) {
				$builder->add($mime_type, $extension);
			}
		}

		return new Mimey\MimeTypes($builder->getMapping());
	}
}
