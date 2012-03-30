<?php

class CommentController extends AdminController
{
    public function init()
    {
        $this->layout = 'comment';
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionLatest($hours)
	{
	    $hours = (int)$hours;
	    
	    $criteria = new CDbCriteria();
	    $time = $_SERVER['REQUEST_TIME'] - $hours*60*60;
	    $criteria->addCondition('t.create_time > ' . $time);
	    
	    $data = AdminComment::fetchList($criteria);
	    
	    $this->adminTitle = t('latest_comment_in_hours', 'admin', array('{hours}'=>$hours));
	    
	    $this->render('list', $data);
	}
	
	public function actionVerify()
	{
	    $count = (int)$count;
	    $criteria = new CDbCriteria();
	    $criteria->scopes = 'noverify';
	    
	    $data = AdminComment::fetchList($criteria);
	    
	    $this->adminTitle = t('recommend_comment', 'admin', array('{count}'=>$count));
	    
	    $this->render('list', $data);
	}
	
	public function actionSearch()
	{
	    
	}
	
	public function actionRecommend($count)
	{
	    $count = (int)$count;
	    $criteria = new CDbCriteria();
	    $criteria->scopes = 'recommend';
	    $criteria->limit = $count;
	     
	    $data = AdminComment::fetchList($criteria);
	     
	    $this->adminTitle = t('recommend_comment', 'admin', array('{count}'=>$count));
	     
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
}

