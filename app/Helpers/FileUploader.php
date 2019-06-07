<?php
namespace App\Helpers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class FileUploader
{
	
	
	/**
	 * Moves the uploaded file to the upload directory and assigns it a unique name
	 * to avoid overwriting an existing uploaded file.
	 *
	 * @param string $directory directory to which the file is moved
	 * @param UploadedFile $uploaded file uploaded file to move
	 * @return string filename of moved file
	 */
	public function upload($directory, UploadedFile $uploadedFile) 
	{
		if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
	        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
		    $basename = bin2hex(random_bytes(8)); 
		    $filename = sprintf('%s.%0.8s', $basename, $extension);
		    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

	        return $filename;
	    }
	}

	public function uploadFromUrl($url, $folder, $title = null)
	{
		$extension = $this->getExtension($url);

		if (is_null($title)) {
			$title = bin2hex(random_bytes(10));
		}

		$file = stri_slug($title). '.' .$extension;

		return (copy($url, $folder . $file)) ? $file : false;
	}


	public function uploadVideoFromUrl($url, $folder, $title)
	{
		$extension = $this->getExtension($url);
		$file = stri_slug($title). '.' .$extension;

		return (copy($url, $folder.$file)) ? $file : false;
	}

	function getExtension($file)
	{
		return pathinfo(
			$file, PATHINFO_EXTENSION
		);
	}
}