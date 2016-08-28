<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Url;
use app\components\Customs3;

class Imageresize extends Component
{
    private $file = '';
    private $width = 200;
    private $height = 200;
    private $method = 'resize';
    private $mediaFile = '/web/media';

    public function __construct($config = array())
    {
        $this->mediaFile = Yii::$app->basePath . $this->mediaFile;
    }

    public function thump($file, $width, $height, $method)
    {

        if ($json = $this->isJson($file))
            $file = $json->image;

        if (empty($file) || $file === 0)
            $file = 'other/no-profile-image.jpg';

        $filethump = $this->thumpName($width, $height, $method);
        $filename = basename($file);
        $folder = dirname($file);

//        return "https://dw4xox9sj1rhd.cloudfront.net/{$folder}/{$filethump}/{$filename}";
//        return "http://hangshare.media.s3.amazonaws.com/{$folder}/{$filethump}/{$filename}";
        return "https://s3-eu-west-1.amazonaws.com/hangshare-media/{$folder}/{$filethump}/{$filename}";
    }

    public function isJson($string)
    {
        $json = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? $json : false;
    }

    protected function thumpName($width, $height, $method)
    {
        return $width . 'x' . $height . '-' . $method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
}
