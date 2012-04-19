<?php
class UploadController extends Controller
{
    public function actionImage()
    {
        // @todo 此处有个权限验证
        if (user()->checkAccess('upload_file')) {
            $upload = CUploadedFile::getInstanceByName('imgFile');
            $this->uploadFile($upload, Upload::TYPE_PICTURE, 'images');
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
    
    private function uploadFile(CUploadedFile $upload, $fileType = Upload::TYPE_UNKNOWN, $additional = null)
    {
        $file = BetaBase::makeUploadFilePath(param('uploadBasePath'), $upload->extensionName, 'images');
        $filePath = $file['path'];
        if ($upload->saveAs($filePath, $deleteTempFile)) {
            $this->afterUploaded($upload, $file, $fileType);
            $data = array(
                'error' => 0,
                'url' => fbu($file['url']),
            );
        }
        else
            $data = array(
                'error' => 1,
                'message' => t('upload_file_error')
            );
        
        echo CJSON::encode($data);
        exit(0);
    }
    
    private function afterUploaded(CUploadedFile $upload, $file, $fileType = Upload::TYPE_UNKNOWN)
    {
        $key = param('sess_post_create_token');
        $postCreatetoken = app()->session[$key];
        $model = new Upload();
        $model->post_id = is_numeric($postCreatetoken) ? (int)$postCreatetoken : 0;
        $model->file_type = $fileType;
        $model->url = $file['url'];
        $model->user_id = (int)user()->id;
        $model->token = $postCreatetoken;
        return $model->save();
    }
}