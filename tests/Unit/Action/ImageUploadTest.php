<?php

use Tests\TestCase;
use \Mockery as Mockery;
use Library\Baaane\ImageUploader\Action\ImageUploadGenerator;

class ImageUploadTest extends TestCase
{	
	public function setUp(): void
    {
    	parent::setUp();
    	
    	$this->directory = __DIR__. '/_files/';

        $_FILES = [
            'filename' => [
                'name' => 'uploaded-image.jpg',
                'type' => 'image/jpeg',
                'size' => 542,
                'tmp_name' =>   __DIR__. '/_files/test.jpg',
                'error' => 0,
            ]
        ];

	    $this->mocked_upload = Mockery::mock(new ImageUploadGenerator($this->directory));
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
        $_POST['new_name'] = [
            'new_name' => 'new_name1'
        ];

        $data_merge = array_merge($_FILES['filename'], $_POST['new_name']);

        $data = $this->mocked_upload->upload($data_merge);

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