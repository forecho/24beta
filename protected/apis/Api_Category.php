<?php
/**
 * 笔记本Api接口
 * @author Chris
 * @copyright cdcchen@gmail.com
 * @package api
 */

class Api_Category extends ApiBase
{
	public function getone()
	{
		self::requireGet();
        $params = array('cid');
        $params = $this->filterParams(array('cid'));
        
        try {
	        $criteria = new CDbCriteria();
	        $criteria->addColumnCondition(array('id'=>$params['cid']));
	        $data = Category::model()->find($criteria);
	        return $data;
        }
        catch (Exception $e) {
        	throw new ApiException('系统错误', ApiError::SYSTEM_ERROR, $params['debug']);
        }
	}
	
    public function getlist()
    {
        self::requireGet();
        $params = $this->filterParams();
        
    	try {
	        return app()->getDb()->createCommand()
	            ->order('orderid desc, id asc')
	            ->from(Category::model()->tableName())
	            ->queryAll();
        }
        catch (Exception $e) {
        	throw new ApiException('系统错误', ApiError::SYSTEM_ERROR);
        }
    }

    public function create()
    {
    	self::requirePost();
    	$this->requireLogin();
    	$this->requiredParams(array('name'));
    	$params = $this->filterParams(array('name', 'isdefault'));
    	
    	$category = new Category();
    	$category->name = $params['name'];
    	try {
    		return (int)$category->save();
    	}
    	catch (ApiException $e) {
    		throw new ApiException('系统错误', ApiError::SYSTEM_ERROR);
    	}
    }
    
    public function delete()
    {
    	self::requirePost();
    	$this->requireLogin();
        $this->requiredParams(array('cid'));
        $params = $this->filterParams(array('cid'));
        
    	try {
	        return Category::model()->findByPk($params['cid'])->delete();
        }
        catch (Exception $e) {
        	throw new ApiException('系统错误', ApiError::SYSTEM_ERROR);
        }
    }
}
?>