<?php

use Tests\TestCase;
use Library\ImageUploader\ImageOptimization;

class ImageOptimizationTest extends TestCase
{
	/**
	 * @test
	 */
	public function it_should_print_image_test()
	{
		$image = new ImageOptimization();
		$image->index();

		$this->assertTrue($image->index());	
	}
}