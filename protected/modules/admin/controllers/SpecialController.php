<?php
class SpecialController extends AdminController
{
    public function actionCreate($id = 0)
    {
        $id = (int)$id;
        if ($id > 0) {
            $model = AdminSpecial::model()->findByPk($id);
            $this->adminTitle = t('edit_special', 'admin');
        }
        else {
            $model = new AdminSpecial();
            $this->adminTitle = t('create_special', 'admin');
        }
        
        if (request()->getIsPostRequest() && isset($_POST['AdminSpecial'])) {
            $model->attributes = $_POST['AdminSpecial'];
            $model->thumbnail = CUploadedFile::getInstance($model, 'thumbnail');
            
	        $attributes = $model->attributes;
	        if (!($model->thumbnail instanceof CUploadedFile))
	            unset($attributes['thumbnail']);
	        $attributes = array_keys($attributes);
	        if ($model->save(true, $attributes) && $model->saveThumbnail() !== false) {
	            user()->setFlash('save_special_result', t('save_special_success', 'admin', array('{name}'=>$model->name)));
	            $this->redirect(request()->getUrl());
	        }
        }
        
        $this->render('create', array('model'=>$model));
    }
    
    public function actionList()
    {
        $data = AdminSpecial::fetchList(null, true, true);
         
        $this->render('list', $data);
    }
    

    public function actionSetState($id, $callback)
    {
        $id = (int)$id;
        $model = AdminSpecial::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(500);
         
        $model->state = ($model->state == SPECIAL_STATE_ENABLED) ? SPECIAL_STATE_DISABLED : SPECIAL_STATE_ENABLED;
        if ($model->state == AdminSpecial::STATE_ENABLED) {
            $model->create_time = $_SERVER['REQUEST_TIME'];
            $attributes = array('state', 'create_time');
        }
        else
            $attributes = array('state');
         
        $model->save(true, $attributes);
        if ($model->hasErrors())
            throw new CHttpException(500);
        else {
            $data = array(
                'errno' => BETA_NO,
                'label' => t($model->state == SPECIAL_STATE_ENABLED ? 'special_enabled' : 'special_disabled', 'admin')
            );
            BetaBase::jsonp($callback, $data);
        }
    }

    public function actionSetDelete($id, $callback)
    {
        $id = (int)$id;
        $model = AdminSpecial::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(500);
    
        if ($model->delete()) {
            $data = array(
                'errno' => BETA_NO,
                'label' => t('delete_success', 'admin'),
            );
            BetaBase::jsonp($callback, $data);
        }
        else
            throw new CHttpException(500);
    }
}