<?php

use Tests\TestCase;
use \Mockery as Mockery;
use Library\Baaane\ImageUploader\Action\ImageUploader;

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
                ]
            ]
        ];

	    $this->mocked_upload = Mockery::mock(new ImageUploader($this->directory));
    }

    /**
     * @test
     */
    public function it_should_upload_and_resize_image()
    {   
        $data = $this->mocked_upload->reArray($_FILES['filename']);
        $result = [];
        for ($i=0; $i < count($data) ; $i++) { 
            $result[] = $this->mocked_upload->upload($data[$i]);
        }

        for ($i=0; $i < count($result); $i++) { 
            @unlink($result[$i]['thumbnail']);
            @unlink($result[$i]['mobile']);
            @unlink($result[$i]['desktop']);
        }

        $this->assertTrue(count($result) > 0);
    }

    /**
     * @test
     */
    public function it_should_rename_upload_resize_image()
    {   
        $name = [
            'new_name' => ['new1', 'new2']
        ];

        $data_merge = array_merge($_FILES['filename'], $name);

        $data = $this->mocked_upload->reArray($data_merge);
        $result = [];
        for ($i=0; $i < count($data) ; $i++) { 
            $result[] = $this->mocked_upload->upload($data[$i]);
        }

        for ($i=0; $i < count($result); $i++) { 
            @unlink($result[$i]['thumbnail']);
            @unlink($result[$i]['mobile']);
            @unlink($result[$i]['desktop']);
        }

        $this->assertTrue(count($result) > 0);
    }

    /**
     * @test
     */
    public function it_should_validate_image()
    {   
        $name = [
            'new_name' => ['new1', 'new2']
        ];

        $data_merge = array_merge($_FILES['filename'], $name);

        $data = $this->mocked_upload->reArray($data_merge);
        for ($i=0; $i < count($data); $i++) { 
            $result[] = $this->mocked_upload->checkImageType($data[$i]);
            $this->assertTrue($result[$i]);
        }
    }

    /**
     * @test
     */
    public function it_should_customize_the_image_size()
    {   
        $name = [
            'new_name' => ['new1', 'new2']
        ];

        $size = [ 
            'mobile'    => ['200x200' , '300x200'],
            'desktop'   => ['1920x1080', '800x750'],
            'thumbnail' => ['0x0', '200x200']
        ];

        $data_merge = array_merge($_FILES['filename'], $name, $size);

        $data = $this->mocked_upload->reArray($data_merge);

        $result = [];
        for ($i=0; $i < count($data) ; $i++) { 
            $result[] = $this->mocked_upload->upload($data[$i]);
        }

        for ($i=0; $i < count($result); $i++) { 
            @unlink($result[$i]['thumbnail']);
            @unlink($result[$i]['mobile']);
            @unlink($result[$i]['desktop']);
        }

        $this->assertTrue(count($result) > 0);
    }

   	/**
	 * will remove the uploaded images
	 */
    public function tearDown(): void
    {
        unset($_FILES);
    }
}