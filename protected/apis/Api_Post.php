<?php
/**
 * 笔记Api接口
 * @author Chris
 * @copyright cdcchen@gmail.com
 * @package api
 */


class Api_Post extends ApiBase
{
    public function show()
    {
        self::requireGet();
        $this->requiredParams('postid');
        $params = $this->filterParams(array('postid', 'fields'));
        
        try {
            $postid = (int)$params['postid'];
	        $cmd = app()->getDb()->createCommand()
	            ->select(empty($params['fields']) ? '*' : $params['fields'])
	            ->from('{{post}}')
	            ->where('id = :postid', array(':postid'=>$postid));
	            
	        $data = $cmd->queryRow();
	        return $data;
        }
        catch (Exception $e) {
        	throw new ApiException('系统错误', ApiError::SYSTEM_ERROR, $params['debug']);
        }
    }
    
    public function getListOfCategory()
    {
        self::requireGet();
        $this->requiredParams(array('cid'));
        $params = $this->filterParams(array('cid', 'fields'));
        
    	try {
	        $criteria = new CDbCriteria();
	        $criteria->select = (isset($params['fields']) && $params['fields']) ? $params['fields'] : '*';
	        $criteria->order = 'create_time desc, id desc';
	        $criteria->addColumnCondition(array('category_id'=>$params['cid']));
	        $data = Post::model()->findAll($criteria);
	        return $data;
        }
        catch (Exception $e) {
        	throw new ApiException('系统错误', ApiError::SYSTEM_ERROR);
        }
    }
    
    public function delete()
    {
    	self::requirePost();
    	$this->requireLogin();
        $this->requiredParams(array('postid'));
        $params = $this->filterParams(array('postid'));
        
        try {
	        return Post::model()->findByPk($params['postid'])->delete();
        }
        catch (Exception $e) {
        	throw new ApiException('系统错误', ApiError::SYSTEM_ERROR);
        }
    }
   
    public function create()
    {
    	self::requirePost();
//    	$this->requireLogin();
    	$this->requiredParams(array('content', 'token', 'channel_id'));
    	$params = $this->filterParams(array('content', 'tags', 'channel_id', 'category_id', 'pic', 'token'));
    	
    	$post = new Post('api');
    	$post->channel_id = (int)$params['channel_id'];
    	$post->category_id = (int)$params['category_id'];
    	$post->content = $params['content'];
    	$post->tags = $params['tags'];
    	$post->create_time = $_SERVER['REQUEST_TIME'];
    	$post->state = Post::STATE_DISABLED;
    	$post->up_score = mt_rand(3, 15);
    	$post->down_score = mt_rand(0, 2);
    	
    	try {
    	    $url = trim($params['pic']);
        	if (!empty($url)) {
        	    $path = CDBase::makeUploadPath('pics');
        	    $info = parse_url($url);
                $extensionName = pathinfo($info['path'], PATHINFO_EXTENSION);
                $file = CDBase::makeUploadFileName('');
                $bigFile = 'big_' . $file;
                $filename = $path['path'] . $file;
                $bigFilename = $path['path'] . $bigFile;
                
        	    $curl = new CdCurl();
        	    $curl->get($url);
        	    $data = $curl->rawdata();
        	    $curl->close();
        	    $im = new CdImage();
        	    $im->load($data);
        	    unset($data, $curl);
        	    $im->saveAsJpeg($filename, 50);
        	    $post->pic = fbu($path['url'] . $im->filename());
        	    $im->revert()->saveAsJpeg($bigFilename);
        	    $post->big_pic = fbu($path['url'] . $im->filename());
        	}
        	else
        	    $post->pic = $post->big_pic = '';
    	}
        catch (CException $e) {
            var_dump($e);
        }
    	
    	try {
    		return (int)$post->save();
    	}
    	catch (ApiException $e) {
    		throw new ApiException('系统错误', ApiError::SYSTEM_ERROR);
    	}
    }
    
}