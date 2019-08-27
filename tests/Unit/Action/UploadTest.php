<?php

use Tests\TestCase;
use Baaane\ImageOptimizer\Core\Upload;

class UploadTest extends TestCase
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
                'new_name' => 'new_name1'
            ]
        ];

	    $this->mocked_upload = new Upload($this->directory);
    }

    /**
     * @test
     */
    public function it_should_list_file_info()
    {   
        $data = $this->mocked_upload->handle($_FILES['filename']);
        $result = new \stdClass();
        $result = json_decode(json_encode([$data]));

        $this->assertObjectHasAttribute('name', $result[0]);
        $this->assertObjectHasAttribute('type', $result[0]);
        $this->assertObjectHasAttribute('tmp_name', $result[0]);
        $this->assertObjectHasAttribute('error', $result[0]);
        $this->assertObjectHasAttribute('size', $result[0]);
        $this->assertObjectHasAttribute('path', $result[0]);
    }

	/**
	 * @test
	 */
	public function it_should_upload_file()
	{	
		$data = $this->mocked_upload->handle($_FILES['filename']);
		$result = $this->mocked_upload->upload($data['tmp_name'], $data['path'].'/'.$data['name']);

		$this->assertTrue($result);
		@unlink($data['path'].'/'.$data['name']);
	}

    /**
     * @test
     */
    public function it_should_check_file_exist()
    {   
        $data = $this->mocked_upload->handle($_FILES['filename']);
        $result = $this->mocked_upload->check_file($data['tmp_name']);

        $this->assertTrue($result);
    }

   	/**
	 * will remove the uploaded images
	 */
    public function tearDown(): void
    {
        unset($_FILES);
    }
}