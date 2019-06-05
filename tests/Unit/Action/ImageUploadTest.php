<?php

use Tests\TestCase;
use \Mockery as Mockery;
use Library\ImageUploader\ImageUpload;
use Library\ImageUploader\ImageOptimization;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageUploadTest extends TestCase
{	
	public function setUp(): void
    {
    	parent::setUp();
    	
    	$this->directory = __DIR__. '/_files/';

        $_FILES = [
        	'filename' => [
                'name' => [
                	0 => 'uploaded-image.jpg',
                	1 => 'uploaded-image1.jpg',
                ],
                'type' => [
                	0 => 'image/jpeg',
                	1 => 'image/jpeg',
                ],
                'size' => [
                	0 => 542,
                	1 => 542,
                ],
                'tmp_name' => [
                	0 => __DIR__. '/_files/test.jpg',
                	1 => __DIR__. '/_files/test1.jpg',
                ],
                'error' => [
                	0 => 0,
                	1 => 0,
               	],
               	'new_name' => [
               		0 => 'uploaded-image',
                	1 => 'uploaded-image1',
               	]
       		]
        ];

	    $this->mocked_upload = Mockery::mock(new ImageUpload($this->directory));
    }

    /**
     * @test
     */
    public function it_should_upload_and_resize_image()
    {   
        $data = $this->mocked_upload->upload($_FILES['filename']);
        
        for ($i=0; $i < count($data); $i++) { 
        	@unlink($data[$i]['thumbnail']);
        	@unlink($data[$i]['mobile']);
        	@unlink($data[$i]['desktop']);
        }

        $this->assertTrue(count($data) > 0);
    }

    /**
     * @test
     */
    public function it_should_rename_upload_resize_image()
    {   
        $data = $this->mocked_upload->upload($_FILES['filename']);
        
        for ($i=0; $i < count($data); $i++) { 
        	@unlink($data[$i]['thumbnail']);
        	@unlink($data[$i]['mobile']);
        	@unlink($data[$i]['desktop']);
        }

        $this->assertTrue(count($data) > 0);
    }

   	/**
	 * will remove the uploaded images
	 */
    public function tearDown(): void
    {
        unset($_FILES);
    }
}