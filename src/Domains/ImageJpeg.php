<?php

namespace Baaane\ImageUploader\Domains;

use Baaane\ImageUploader\Domains\BaseImageAbstract;

class ImageJpeg extends BaseImageAbstract
{
	
	/**
     * @var string $info_parameter 
     */
	protected $info_parameter = "imagecreatefromjpeg";

	/**
     * @var string $create_parameter 
     */
	protected $create_parameter = "imagejpeg";

	/**
     * @var string $quality 
     */
	protected $quality = 85;
}