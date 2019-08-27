<?php

namespace Baaane\ImageOptimizer\Action;

use Baaane\ImageOptimizer\Action\BaseAction;

class DesktopImageSize extends BaseAction
{

	/**
     * @var string $name 
     */
	protected $name = 'desktop';

	/**
     * @var string $width 
     */
	protected $width = 1920;

	/**
     * @var string $height 
     */
	protected $height = 1080;
}