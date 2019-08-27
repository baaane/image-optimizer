<?php

namespace Baaane\ImageOptimizer\Domains;

use Baaane\ImageOptimizer\Domains\BaseImageAbstract;

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