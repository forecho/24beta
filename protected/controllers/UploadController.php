<?php
class UploadController extends Controller
{
    public function actionImage()
    {
        if (user()->checkAccess('upload_file')) {
            $upload = CUploadedFile::getInstanceByName('imgFile');
            $this->uploadImage($upload, Upload::TYPE_PICTURE, 'images');
        }
        else {
            $data = array(
                'error' => 1,
                'message' => t('you_do_not_have_enough_permissions'),
            );
            echo CJSON::encode($data);
            exit(0);
        }
    }
    
    private function uploadImage(CUploadedFile $upload, $fileType = Upload::TYPE_UNKNOWN, $additional = 'images')
    {
        $filename = BetaBase::uploadImage($upload, $additional);
        if ($filename === false || !$this->afterUploaded($upload, $filename['url'], $fileType)) {
            $data = array(
                'error' => 1,
                'message' => t('upload_file_error')
            );
        }
        else {
            $data = array(
                'error' => 0,
                'url' => fbu($filename['url']),
            );
        }
        echo CJSON::encode($data);
        exit(0);
    }
    
    private function uploadFile(CUploadedFile $upload, $fileType = Upload::TYPE_UNKNOWN, $additional = 'files')
    {
        $filename = BetaBase::uploadFile($upload, $additional);
        if ($filename === false || !$this->afterUploaded($upload, $filename['url'], $fileType)) {
            $data = array(
                'error' => 1,
                'message' => t('upload_file_error')
            );
        }
        else {
            $data = array(
                'error' => 0,
                'url' => fbu($filename['url']),
            );
        }
        echo CJSON::encode($data);
        exit(0);
    }
    
    private function afterUploaded(CUploadedFile $upload, $fileUrl, $fileType = Upload::TYPE_UNKNOWN)
    {
        $key = param('sess_post_create_token');
        $postCreatetoken = app()->session[$key];
        $model = new Upload();
        $model->post_id = is_numeric($postCreatetoken) ? (int)$postCreatetoken : 0;
        $model->file_type = $fileType;
        $model->url = $fileUrl;
        $model->user_id = (int)user()->id;
        $model->token = $postCreatetoken;
        return $model->save();
    }
}