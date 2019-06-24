<?php

namespace Baaane\ImageUploader\Domains;

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
	 * @param string $tmp_name
	 * @return object
	 *
	 */
	public function info($tmp_name)
	{
		$data = call_user_func($this->info_parameter, $tmp_name);
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
	public function create($new, $final)
	{
		call_user_func_array($this->create_parameter, array($new, $final, $this->quality));
		$data = rtrim($final);
		return $data;
	}
}