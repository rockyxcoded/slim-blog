<?php
namespace App\Mp3Lib;

use App\Helpers\FileUloader;

class PHP_Mp3Library
{
	protected $mp3Handler;
	protected $mp3Writter;
	protected $removeTags;
	
	public function __construct($removeTags = true)
	{
		$this->removeTags = $removeTags;
		$this->mp3Handler = new getID3();
		$this->mp3Handler->setOption(array('encoding' => 'UTF-8'));

		$this->mp3Writter = new getid3_writetags();
	}

	public function writeTags($filename, $mp3_songname, $mp3_artist, $mp3_album, $mp3_year, $mp3_genre, $mp3_comment, $default_cover)
	{
		$this->mp3Writter->filename       = $filename;
		$this->mp3Writter->tagformats     = array('id3v1', 'id3v2.3');
		$this->mp3Writter->overwrite_tags = true;
		$this->mp3Writter->tag_encoding   = 'UTF-8';
		$this->mp3Writter->remove_other_tags = true;

		$mp3_data['title'][]   = $mp3_songname.' || Yabamusic.com';
		$mp3_data['artist'][]  = $mp3_artist;
		$mp3_data['album'][]   = $mp3_album;
		$mp3_data['year'][]    = $mp3_year;
		$mp3_data['genre'][]   = $mp3_genre;
		$mp3_data['comment'][] = $mp3_comment;
		$mp3_data['attached_picture'][0]['data'] = file_get_contents($default_cover);
		$mp3_data['attached_picture'][0]['picturetypeid'] = "image/jpeg";
		$mp3_data['attached_picture'][0]['description'] = "Downloaded from yabamusic.com";
		$mp3_data['attached_picture'][0]['mime'] = "image/jpeg";

		$mp3_writter->tag_data = $mp3_data;

		return ($mp3Writter->WriteTags()) ? true : false;
	}

	public function getDuration($filenamePath)
    {
        $fileInfo = $this->mp3Handler->analyze($filenamePath);
        return isset($fileInfo['playtime_seconds']) ? $fileInfo['playtime_seconds'] : 0;
    }

    public function getErrors()
    {
    	return $this->mp3Writter->errors;
    }

    public function getWarnings()
    {
    	return $this->mp3Writter->warnings;
    }
}