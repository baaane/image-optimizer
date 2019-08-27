<?php

namespace Baaane\ImageOptimizer\Action;

use Baaane\ImageOptimizer\Action\BaseAction;

class MobileImageSize extends BaseAction
{

	/**
     * @var string $name 
     */
	protected $name = 'mobile';

	/**
     * @var string $width 
     */
	protected $width = 690;

	/**
     * @var string $height 
     */
	protected $height = 960;
}