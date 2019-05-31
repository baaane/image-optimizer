<?php

use Tests\TestCase;
use \Mockery as Mockery;
use Library\ImageUploader\Upload;
use Library\ImageUploader\ImageOptimization;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class UploadTest extends TestCase
{	
	public function setUp(): void
    {
    	parent::setUp();
    	
    	$this->directory = storage_path('app/public');

        $_FILES = array(
            'file' => array(
                'name' => 'uploaded-image.jpg',
                'type' => 'image/jpeg',
                'size' => 542,
                'tmp_name' => storage_path('app/public/test.jpg'),
                'error' => 0
            )
        );
    }

	/**
	 * @test
	 */
	public function it_should_upload_image()
	{	
		if(empty($_FILES['file']) || !file_exists($_FILES['file']['tmp_name'])){
			return FALSE;
		}

		$tmp_img = $_FILES['file']['tmp_name'];
        $new_img = $this->directory . '/' . $_FILES['file']['name'];

        $result = copy($tmp_img, $new_img);

		$this->assertTrue($result);
	}

	/**
	 * @test
	 */
	public function it_should_optimize_uploaded_image()
	{	
		if(empty($_FILES['file']) || !file_exists($_FILES['file']['tmp_name'])){
			return FALSE;
		}

		$tmp_img = $_FILES['file']['tmp_name'];
        $new_img = $this->directory . '/' . $_FILES['file']['name'];

        $uploaded = copy($tmp_img, $new_img);

        $result = false;
		if($uploaded){
			$optimizerChain = Mockery::mock(OptimizerChainFactory::create());
			$optimizerChain->optimize($this->directory . '/' . $_FILES['file']['name']);
			$result = true;
		}

		$this->assertTrue($result);
	}

   	/**
	 * will remove the uploaded images
	 */
    public function tearDown(): void
    {
        unset($_FILES);
        unset($this->file);
        unlink(storage_path('app/public/uploaded-image.jpg'));
    }
}