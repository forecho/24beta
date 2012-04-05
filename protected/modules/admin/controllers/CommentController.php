<?php

class CommentController extends AdminController
{
    public function filters()
    {
        return array(
        'ajaxOnly + setVerify, delete, setRecommend, multiDelete',
        'postOnly + setVerify, delete, setRecommend, multiDelete',
        );
    }
    
	public function actionLatest($hours = 48)
	{
	    $hours = (int)$hours;
	    
	    $criteria = new CDbCriteria();
	    $time = $_SERVER['REQUEST_TIME'] - $hours*60*60;
	    $criteria->addCondition('t.create_time > ' . $time);
	    
	    $data = AdminComment::fetchList($criteria);
	    
	    $this->adminTitle = t('latest_comment', 'admin');
	    
	    $this->render('list', $data);
	}
	
	public function actionVerify()
	{
	    $count = (int)$count;
	    $criteria = new CDbCriteria();
	    $criteria->scopes = 'noverify';
	    
	    $data = AdminComment::fetchList($criteria);
	    
	    $this->adminTitle = t('verify_comment', 'admin');
	    
	    $this->render('list', $data);
	}

	public function actionSearch()
	{
	    $form = new CommentSearchForm();
	     
	    if (isset($_GET['CommentSearchForm'])) {
	        $form->attributes = $_GET['CommentSearchForm'];
	        if ($form->validate())
	            $data = $form->search();
	        user()->setFlash('table_caption', t('comment_search_result', 'admin'));
	    }
	     
	    $this->render('search', array('form'=>$form, 'data'=>$data));
	}
	
	public function actionRecommend()
	{
	    $count = (int)param('adminCommentCountOfPage');
	    $criteria = new CDbCriteria();
	    $criteria->scopes = 'recommend';
	    $criteria->limit = $count;
	     
	    $data = AdminComment::fetchList($criteria);
	     
	    $this->adminTitle = t('recommend_comment', 'admin');
	     
	    $this->render('list', $data);
	}
	
	public function actionSetVerify($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminComment::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	
	    $model->state = abs($model->state - AdminComment::STATE_ENABLED);
	    $model->save(true, array('state'));
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($model->state == AdminComment::STATE_DISABLED ? 'setshow' : 'sethide', 'admin')
	        );
	        echo $callback . '(' . CJSON::encode($data) . ')';
	        exit(0);
	    }
	}
	
	public function actionSetRecommend($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminComment::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	
	    $model->recommend = abs($model->recommend - BETA_YES);
	    $model->save(true, array('recommend'));
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($model->recommend == BETA_NO ? 'set_recommend_comment' : 'cancel_recommend_comment', 'admin')
	        );
	        echo $callback . '(' . CJSON::encode($data) . ')';
	        exit(0);
	    }
	}

	public function actionDelete($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminComment::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	    
	    $result = $model->delete();
	    $data = array(
	        'errno' => $result ? BETA_NO : BETA_YES,
	    );
	    echo $callback . '(' . CJSON::encode($data) . ')';
	    exit(0);
	}
	
	/**
	 * 批量删除评论
	 * @param array $ids 评论ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiDelete($callback)
	{
	    $ids = (array)request()->getPost('ids');
	    $successIds = $failedIds = array();
	    foreach ($ids as $id) {
    	    $model = AdminComment::model()->findByPk($id);
    	    if ($model === null)
    	        continue;
    	    
    	    $result = $model->delete();
    	    if ($result)
        	    $successIds[] = $id;
    	    else
    	        $failedIds[] = $id;
	    }
	    $data = array(
	        'success' => $successIds,
	        'failed' => $failedIds,
	    );
	    echo $callback . '(' . CJSON::encode($data) . ')';
	    exit(0);
	}
	
}

