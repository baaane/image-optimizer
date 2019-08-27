<?php

namespace Baaane\ImageOptimizer\Domains;

use Baaane\ImageOptimizer\Domains\BaseImageAbstract;

class ImagePng extends BaseImageAbstract
{
	
	/**
     * @var string $info_parameter 
     */
	protected $info_parameter = "imagecreatefrompng";

	/**
     * @var string $create_parameter 
     */
	protected $create_parameter = "imagepng";

	/**
     * @var string $quality 
     */
	protected $quality;
}