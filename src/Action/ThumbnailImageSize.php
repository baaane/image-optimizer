<?php

namespace Baaane\ImageUploader\Action;

use Baaane\ImageUploader\Action\BaseAction;

class ThumbnailImageSize extends BaseAction
{	

	/**
     * @var string $name 
     */
	protected $name = 'thumbnail';

	/**
     * @var string $width 
     */
	protected $width = 300;

	/**
     * @var string $height 
     */
	protected $height = 300;
}