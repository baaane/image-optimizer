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
        0 => 'new_name1',
        1 => 'new_name2',
    ]
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
     * @test
     */
    public function it_should_validate_image()
    {   
        $_POST['new_name'] = [
            'new_name' => 'new_name1'
        ];

        $data_merge = array_merge($_FILES['filename'], $_POST['new_name']);

        $data_reArray = $this->mocked_upload->reArrayFiles($data_merge);

        for ($i=0; $i < count($data_reArray); $i++) { 
            $data[] = $this->mocked_upload->checkImageType($data_reArray[$i]);
        }
        
        $this->assertTrue($data[0]);
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
            // 'mobile'    => ['0,0' , '500,200'],
            'desktop'   => ['1920, 1080', '800,750'],
            'thumbnail' => ['300, 300', '200,200']
        ];

        $data_merge = array_merge($_FILES['filename'], $name, $size);
        $data = $this->mocked_upload->upload($data_merge);

        for ($i=0; $i < count($data); $i++) { 
            // @unlink($data[$i]['thumbnail']);
            // @unlink($data[$i]['mobile']);
            // @unlink($data[$i]['desktop']);
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