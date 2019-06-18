<?php

namespace Baaane\ImageUploader\Action;

use Exception;
use Baaane\ImageUploader\Core\Upload;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Baaane\ImageUploader\Action\MobileImageSize;
use Baaane\ImageUploader\Action\DesktopImageSize;
use Baaane\ImageUploader\Action\ThumbnailImageSize;
use Baaane\ImageUploader\Builder\ReflectionClassBuilder;
use Baaane\ImageUploader\Exceptions\ImageUploaderException;
use Baaane\ImageUploader\Exceptions\InvalidImageTypeException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class ImageUploader
{
	/**
	 * Different class sizes
	 *
	 * @var array $imageClassSize
	 *
	 */
	private $imageClassSize = [
		'thumbnail' => ThumbnailImageSize::class,
		'mobile'	=> MobileImageSize::class,
		'desktop'	=> DesktopImageSize::class,
	];

    /**
     * File path
     *
     * @param string $filePath
     */
    public function __construct($filePath = NULL)
    {
        $this->filePath = rtrim($filePath);
    }

	/**
	 * Upload the image
	 *
	 * @param array $data
	 * @return array
	 *
	 */
	public function upload(array $data)
	{	
		if($data['error'] > 0 ){
			throw new ImageUploaderException($data['error']);
		}

		if(!isset($data['error']) ){
			throw ImageUploaderException::noErrorKey();
		}

		try {

			$this->checkImageType($data);
			$upload = new Upload($this->filePath);
			$fileData = $upload->handle($data);
			$result = $this->resize($fileData, $data);

			return $result;
	
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * Resizing the image 	Thumbnail|Mobile|Desktop	
	 *
	 * @param array $data
	 *
	 * @return array
	 *
	 */
	public function resize($fileData, $size)
	{
		foreach ($this->imageClassSize as $key => $value) {
			$builder = ReflectionClassBuilder::create($this->imageClassSize[$key]);
			$data[] = $builder->get($fileData,$size);

			foreach ($data as $dkey => $dvalue) {
				$this->image_optimization($dvalue);
				$result[$key] = $dvalue;
			}
		}
		return $result;	
	}

	/**
	 * Set width and height
	 *
	 * @param int|null $width
	 * @param int|null $height
	 *
	 * @return array
	 *
	 */
	public function setThumbnailSize($width = NULL, $height = NULL)
	{
		$width 	= (isset($width) ? $width : 0);
		$height = (isset($height) ? $height : 0);
		$this->result['thumbnail'] = ['width' => $width, 'height' => $height];

		return $this;
	}

	/**
	 * Set width and height
	 *
	 * @param int|null $width
	 * @param int|null $height
	 *
	 * @return array
	 *
	 */
	public function setMobileSize($width = NULL, $height = NULL)
	{
		$width 	= (isset($width) ? $width : 0);
		$height = (isset($height) ? $height : 0);
		$this->result['mobile'] = ['width' => $width, 'height' => $height];

		return $this;
	}

	/**
	 * Set width and height
	 *
	 * @param int|null $width
	 * @param int|null $height
	 *
	 * @return array
	 *
	 */
	public function setDesktopSize($width = NULL, $height = NULL)
	{
		$width 	= (isset($width) ? $width : 0);
		$height = (isset($height) ? $height : 0);
		$this->result['desktop'] = ['width' => $width, 'height' => $height];

		return $this;
	}

	/**
	 * Get all size
	 *
	 * @return array
	 */
	public function get()
	{
		return $data = $this->result;
	}


	/**
	 * Re-arrange the array	
	 *
	 * @param array $data
	 *
	 * @return array
	 *
	 */
	public function reArray(&$data_array)
	{
		$data = [];
        foreach($data_array as $key => $value){
            foreach($value as $vkey => $vvalue){
                $data[$vkey][$key] = $vvalue;
            }
        }
	    return $data;
	}

	/**
	 * Validate image
	 *
	 * @param array $data
	 *
	 * @return boolean
	 *
	 */
	public function checkImageType($data)
	{
		$allowed_ext = [
			'jpeg',
			'png',
			'gif'
		];

    	$uploadFile = new UploadedFile($data['tmp_name'], $data['name']);
    	
		// Get image file extension
    	$file_mime = $uploadFile->guessExtension();

    	// Validate file input to check if is with valid extension
		if(!in_array($file_mime, $allowed_ext)){
			throw InvalidImageTypeException::checkMimeType($file_mime);
		}

		return TRUE;
	}

	/**
     * Optimize the file
     *
     * @param string $filename with path
     */
	private function image_optimization($filename)
	{
		$optimizerChain = OptimizerChainFactory::create();
		$optimizerChain->optimize($filename);
	}
}
