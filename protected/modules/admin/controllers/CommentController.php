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
	    $data = AdminComment::fetchList($criteria);
	    
	    $this->adminTitle = t('latest_comment', 'admin');
	    
	    $this->render('list', $data);
	}
	
	public function actionList($postid)
	{
	    $postid = (int)$postid;
	    
	    $post = AdminPost::model()->findByPk($postid);
	    if ($post === null)
	        throw new CHttpException(404, t('post_is_not_exist', 'admin'));
	    
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('post_id' => $postid));
	    
	    $data = AdminComment::fetchList($criteria);
	    $data['post'] = $post;
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
	        $this->adminTitle = t('comment_search_result', 'admin');
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
	
	    $model->state = abs($model->state - COMMENT_STATE_ENABLED);
	    $model->create_time = $_SERVER['REQUEST_TIME'];
	    $model->save(true, array('state'));
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($model->state == COMMENT_STATE_DISABLED ? 'setshow' : 'sethide', 'admin')
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
	    $model->create_time = $_SERVER['REQUEST_TIME'];
	    $model->save(true, array('recommend', 'create_time'));
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
	
	/**
	 * 批量审核评论
	 * @param array $ids 评论ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiVerify($callback)
	{
	    $ids = (array)request()->getPost('ids');
	    
	    $successIds = $failedIds = array();
	    $attributes = array(
	        'state' => COMMENT_STATE_ENABLED,
	        'create_time' => $_SERVER['REQUEST_TIME'],
	    );
	    foreach ($ids as $id) {
    	    $result =Comment::model()->updateByPk($id, $attributes);
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
	
	/**
	 * 批量推荐评论
	 * @param array $ids 评论ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiRecommend($callback)
	{
	    $ids = (array)request()->getPost('ids');
	    
	    $successIds = $failedIds = array();
	    $attributes = array(
	        'state' => COMMENT_STATE_ENABLED,
	        'recommend' => BETA_YES,
	        'create_time' => $_SERVER['REQUEST_TIME'],
	    );
	    foreach ($ids as $id) {
    	    $result =Comment::model()->updateByPk($id, $attributes);
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
	
	/**
	 * 批量设置推荐评论
	 * @param array $ids 评论ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiHottest($callback)
	{
	    $ids = (array)request()->getPost('ids');
	    
	    $successIds = $failedIds = array();
	    foreach ($ids as $id) {
	        $model = AdminComment::model()->findByPk($id);
	        if ($model === null) continue;
	        
	        $model->state = COMMENT_STATE_ENABLED;
	        $model->up_nums += param('upNumsOfCommentIsHot');
	        
    	    $result = $model->save(true, array('state', 'up_nums'));
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

