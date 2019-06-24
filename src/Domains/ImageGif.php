<?php

namespace Baaane\ImageUploader\Domains;

use Baaane\ImageUploader\Domains\BaseImageAbstract;

class ImageGif extends BaseImageAbstract
{
	
	/**
     * @var string $info_parameter 
     */
	protected $info_parameter = "imagecreatefromgif";

	/**
     * @var string $create_parameter 
     */
	protected $create_parameter = "imagegif";

	/**
     * @var string $quality 
     */
	protected $quality = 100;
}