<?php

namespace Library\Baaane\ImageUploader\Contracts;

interface ImageActionInterface
{
	/**
	 * Action for resize image
	 *
	 * @return string
	 */
	public function action();
}