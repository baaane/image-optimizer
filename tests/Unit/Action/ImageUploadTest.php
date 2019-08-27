<?php

use Tests\TestCase;
use Illuminate\Http\Request;
use Baaane\ImageOptimizer\Action\ImageOptimizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadTest extends TestCase
{	
	public function setUp(): void
    {
    	parent::setUp();
    	
    	$this->directory = __DIR__. '/_files';

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

	    $this->mocked_upload = new ImageOptimizer($this->directory);
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
            'new_size' => [
                $this->mocked_upload->setThumbnailSize(200,200)
                                    ->setMobileSize(691,961)
                                    ->setDesktopSize(800,750)
                                    ->get(),
                $this->mocked_upload->setThumbnailSize()
                                    ->setMobileSize(345,789)
                                    ->setDesktopSize(0,0)
                                    ->get(),
            ]
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
     * @test
     */
    public function it_should_set_path_and_upload()
    {   
        $data = $this->mocked_upload->reArray($_FILES['filename']);
        $result = [];
        for ($i=0; $i < count($data) ; $i++) { 
            $result[] = $this->mocked_upload->setPath($this->directory)->upload($data[$i]);
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
    public function it_should_delete_original_file_after_upload()
    {   
        $data = $this->mocked_upload->reArray($_FILES['filename']);
        $result = [];
        for ($i=0; $i < count($data) ; $i++) { 
            $result[] = $this->mocked_upload->deleteOriginalFile()->upload($data[$i]);
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
    public function it_should_accept_file_request()
    {   

        $request = app(Request::class);
        $request->files->replace($_FILES);
        $data = $request->file('filename');
        $result = [];
        for ($i=0; $i < count($data) ; $i++) { 
            $result[] = $this->mocked_upload->uploadRequestFile($data[$i]);
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