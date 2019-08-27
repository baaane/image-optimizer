<?php

namespace Baaane\ImageOptimizer\Builder;

class ReflectionClassBuilder
{
	/**
	 * Builder
	 *
	 * @param string $data
	 * @return object
	 *
	 */
	public static function create($data)
	{
		try {		
			$reflection = new \ReflectionClass($data);
			$class = $reflection->newInstanceArgs([]);

			return $class;
		} catch (Exception $e) {
			throw new \Exception("Class not found!");
		}
	}
}