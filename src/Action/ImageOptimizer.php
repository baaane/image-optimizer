<?php

namespace Baaane\ImageOptimizer\Action;

use Exception;
use Illuminate\Http\Request;
use Baaane\ImageOptimizer\Core\Upload;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Baaane\ImageOptimizer\Action\MobileImageSize;
use Baaane\ImageOptimizer\Action\DesktopImageSize;
use Baaane\ImageOptimizer\Action\ThumbnailImageSize;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Baaane\ImageOptimizer\Builder\ReflectionClassBuilder;
use Baaane\ImageOptimizer\Exceptions\ImageOptimizerException;
use Baaane\ImageOptimizer\Exceptions\InvalidImageTypeException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class ImageOptimizer
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
     * @var string|null $filepath 
     */
	private $filepath = NULL;

	/**
     * @var boolean $deleteFile 
     */
	private $deleteFile = FALSE;

	/**
     * @var boolean $changeBackground 
     */
	private $changeBackground = FALSE;

	/**
	 * Path
	 *
	 * @param string $filepath
	 *
	 */
	public function __construct($filepath)
	{
		$this->filepath = (isset($filepath) ? $filepath : NULL);
	}

	/**
	 * Set path
	 *
	 * @param string $path
	 *
	 * @return string
	 *
	 */
	public function setPath($filepath)
	{
		$this->filepath = (isset($filepath) ? $filepath : NULL);
		return $this;
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
			throw new ImageOptimizerException($data['error']);
		}

		if(!isset($data['error']) ){
			throw ImageOptimizerException::noErrorKey();
		}

		try {

			$this->checkImageType($data);
			$uploader 	= new Upload($this->filepath);
			$filedata 	= $uploader->handle($data);
			$data = $this->resize($filedata, $data);
			
			if($this->deleteFile === TRUE) {
				$this->deleteUploadedFile($filedata);
			}
			
			return $data;
	
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * Upload the image
	 *
	 * @param array $data
	 * @return array
	 *
	 */
	public function uploadRequestFile($data)
	{	
		$data = [
			'name' => $data->getClientOriginalName(),
	        'type' => $data->getClientMimeType(),
	        'size' => $data->getClientSize(),
	        'tmp_name' => $data->getRealPath(),
	        'error' => $data->getError(),
		];

		return $result = $this->upload($data);
	}

	/**
	 * Resizing the image 	Thumbnail|Mobile|Desktop	
	 *
	 * @param array $filedata
	 *
	 * @return array
	 *
	 */
	public function resize($filedata, $size)
	{
		foreach ($this->imageClassSize as $key => $value) {
			$builder = ReflectionClassBuilder::create($this->imageClassSize[$key]);
			$data[] = $builder->get($filedata,$size);

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
	 * Set delete file true
	 *
	 * @return boolean
	 */
	public function deleteOriginalFile()
	{
		$this->deleteFile = TRUE;

		return $this;
	}

	/**
	 * Delete original file
	 *
	 * @param array $filedata
	 *
	 */
	public function deleteUploadedFile($filedata)
	{
		@unlink($filedata['filepath']);
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
	 * @param array $data_array
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
