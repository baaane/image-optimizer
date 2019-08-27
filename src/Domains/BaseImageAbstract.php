<?php

namespace Baaane\ImageOptimizer\Domains;

abstract class BaseImageAbstract
{
	/**
     * @var string $info_parameter 
     */
	protected $info_parameter;

	/**
     * @var string $create_parameter 
     */
	protected $create_parameter;

	/**
     * @var string $quality 
     */
	protected $quality;

	/**
	 * Get the image information 
	 *
	 * @param string $filepath
	 * @return object
	 *
	 */
	public function info($filepath)
	{
		$data = call_user_func($this->info_parameter, $filepath);
		return $data;
	}

	/**
	 * Create new image
	 *
	 * @param string $new
	 * @param string $final
	 * @return string
	 *
	 */
	public function create($img, $final)
	{
		// Create new empty image
		$new = imagecreatetruecolor($img['new_width'], $img['new_height']);

		imagealphablending( $new, false );
		imagesavealpha( $new, true );

		// Resample old into new
		imagecopyresampled($new, $img['image'], 0, 0, 0, 0, $img['new_width'], $img['new_height'], $img['old_width'], $img['old_height']);

		call_user_func_array($this->create_parameter, array($new, $final, $this->quality));

		$data = rtrim($final);

		return $data;

		imagedestroy($new);
	}
}