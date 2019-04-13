<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 04.04.19
 * Time: 22:55
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model {

    public $image;

    public function rules()
    {
        return [
          [['image'], 'required'],
          [['image'], 'file', 'extensions' => 'jpg,png']
        ];
    }

    public function uploadFile(UploadedFile $file, $currentImage)
    {

        $this->image = $file;

        if ($this->validate())
        {
            $this->delCurImage($currentImage);

            return $this->saveImage();
        }

        return false;
    }

    private function getFolder($file = '')
    {
        return Yii::getAlias('@web') . 'uploads/' . $file;
    }

    private function genFileName()
    {
        return strtolower(md5(uniqid($this->image->baseName)) . "." . $this->image->extension);
    }

    public function delCurImage($currentImage)
    {
        if (isset($currentImage)) {
            $old_file_path = $this->getFolder($currentImage);
            file_exists($old_file_path) ? unlink($old_file_path) : null;
        }
    }

    public function saveImage()
    {
        $filename = $this->genFileName();
        $this->image->saveAs($this->getFolder($filename));

        return $filename;
    }


}