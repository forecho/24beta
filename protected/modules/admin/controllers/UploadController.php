<?php
class UploadController extends AdminController
{
    public function actionList()
    {
        $criteria = new CDbCriteria();
        $data = AdminUpload::fetchList($criteria, true, true);
        
        $this->adminTitle = t('upload_file_list', 'admin');
        $this->render('list', $data);
    }
    
    
    public function actionSearch()
    {
        $form = new UploadSearchForm();
        
        if (isset($_GET['UploadSearchForm'])) {
            $form->attributes = $_GET['UploadSearchForm'];
            if ($form->validate())
                $data = $form->search();
            user()->setFlash('table_caption', t('user_search_result', 'admin'));
        }
        
        $this->adminTitle = t('search_result', 'admin');
        $fileTypes = AdminUpload::typeLabels();
        $this->render('search', array(
            'form' => $form,
            'data' => $data,
            'fileTypes' => $fileTypes,
        ));
    }
}