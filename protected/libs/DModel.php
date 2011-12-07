<?php
/**
 * @author chendong
 *
 * @abstract
 * @version 1.0
 */
abstract class DModel
{
    private static $_models;
    private $_pk;
    private $_db;
    private $_cmd;
    private $_attributes;
    
    function __construct()
    {
        // @todo update insert 使用
//        $this->setIsNewRecord(true);
        $this->_pk = $this->pk();
        
        $this->init();
    }
    

    public function __set($name, $value)
    {
        if ($this->setAttribute($name, $value) === false) {
            $setter = 'set' . ucfirst(strtolower($name));
    		if (method_exists($this, $setter))
    			return $this->$setter($value);
		}
    }
    
    public function __get($name)
    {
        if (isset($this->_attributes[$name]))
			return $this->_attributes[$name];
		else {
            $getter = 'get' . ucfirst(strtolower($name));
            return $this->$getter();
		}
    }
    
    public function __isset($name)
    {
        $getter = 'get' . ucfirst(strtolower($name));
    	return isset($this->_attributes[$name]) || method_exists($this, $getter) || false;
    }
    
    public function  __unset($name)
    {
        $setter = 'set' . ucfirst(strtolower($name));
        $getter = 'get' . ucfirst(strtolower($name));
    	if (in_array($name, $this->columns()))
			unset($this->_attributes[$name]);
		elseif (method_exists($this, $setter))
			$this->$setter(null);
	    elseif (method_exists($this, $getter))
	        throw new CException(Yii::t('yii','Property "{class}.{property}" is read only.',
				array('{class}'=>get_class($this), '{property}'=>$name)));
		else
			throw new CException(Yii::t('yii','Property "{class}.{property}" is not defined.',
				array('{class}'=>get_class($this), '{property}'=>$name)));
    }
    
    /**
     * Initializes this model.
     */
    public function init()
    {
    }
    
    /**
     * Returns the static model of the specified DModel class.
     * @param string $class
     * @param Dmodel
     */
    public static function model($class = __CLASS__)
    {
        if (isset(self::$_models[$class]))
			return self::$_models[$class];
		else {
			$model = self::$_models[$class] = new $class(null);
			return $model;
		}
    }
    
    /**
     * Return app db component
     * @return CDbConnection
     */
    public function getDb()
    {
        if ($this->_db)
            return $this->_db;
        else
            return $this->_db = Yii::app()->getDb();
    }
    
    /**
     * return db command object
     * @param string $query
     * @return CDbCommand
     */
    public function getDbCommand($query = null)
    {
        if ($this->_cmd)
            return $this->_cmd;
        else
            return $this->_cmd = Yii::app()->getDb()->createCommand($query);
    }
    
    /**
	 * Sets the parameters about query caching.
	 * This is a shortcut method to {@link CDbConnection::cache()}.
	 * It changes the query caching parameter of the {@link dbConnection} instance.
	 * @param integer $duration the number of seconds that query results may remain valid in cache.
	 * If this is 0, the caching will be disabled.
	 * @param CCacheDependency $dependency the dependency that will be used when saving the query results into cache.
	 * @param integer $queryCount number of SQL queries that need to be cached after calling this method. Defaults to 1,
	 * meaning that the next SQL query will be cached.
	 * @return DModel the active record instance itself.
	 */
    public function cache($duration, $dependency=null, $queryCount=1)
	{
		$this->getDb()->cache($duration, $dependency, $queryCount);
		return $this;
	}

    /**
     * fetch the rows by pk
     * @param mixed $pk
     * @param mixed $select string|array
     * @param array $params
     * @param boolean $fetchAssociative
     * @return array the record found. Null if none is found.
     */
    public function queryByPk($pk, $select = '*', $params = array(), $fetchAssociative = true)
    {
        $cmd = $this->getDbCommand()
            ->select($select)
            ->where($this->pk() . ' = :value', array(':value'=>$pk));
        return $this->query($cmd, $params, $fetchAssociative);
    }
    
    /**
     * Executes the SQL statement and returns the first row of results.
     * @param CDbCommand $cmd
     * @param array $params
     * @param boolean $fetchAssociative
     * @return array the record found. Null if none is found.
     */
    public function query(CDbCommand $cmd, $params = array(), $fetchAssociative = true)
    {
        return $cmd->from($this->table() . ' t')
            ->limit(1)->queryRow($fetchAssociative, $params);
    }
    
    /**
     * Executes the SQL statement and returns all rows.
     * @param CDbCommand $cmd
     * @param array $params
     * @param boolean $fetchAssociative
     * @return array the record found. An empty array if none is found.
     */
    public function queryAll(CDbCommand $cmd, $params = array(), $fetchAssociative = true)
    {
        $this->beforeFind();
        $cmd->from($this->table() . ' t');
        return $cmd->queryAll($fetchAssociative, $params);
    }

    /**
     * fetch the rows by pk
     * @param mixed $pk
     * @param mixed $select string|array
     * @param array $params
     * @param boolean $fetchAssociative
     * @return DModel the record found. Null if none is found.
     */
    public function findByPk($pk, $select = '*', $params = array(), $fetchAssociative = true)
    {
        return $this->toModel($this->queryByPk($pk, $select, $params, $fetchAssociative));
    }
    
    /**
     * fetch the model
     * @param CDbCommand $cmd
     * @param array $params
     * @param boolean $fetchAssociative
     * @return DModel the record found. Null if none is found.
     */
    public function find(CDbCommand $cmd, $params = array(), $fetchAssociative = true)
    {
        return $this->toModel($this->query($cmd, $params, $fetchAssociative));
    }
    
    /**
     * fetch the models
     * @param CDbCommand $cmd
     * @param array $params
     * @param boolean $fetchAssociative
     * @return DModel the record found. Null if none is found.
     */
    public function findAll(CDbCommand $cmd, $params = array(), $fetchAssociative = true)
    {
        return $this->toModels($this->queryAll($cmd, $params, $fetchAssociative));
    }
    
    public function count($conditions = '', $params = array())
    {
        if ($conditions instanceof CDbCommand) {
            return $conditions->select('count(*)')
                ->from($this->table() . ' t')
                ->queryScalar();
        }
        
        $cmd = $this->getDbCommand()
            ->select('count(*)')
            ->from($this->table() . ' t');
        if ($conditions)
            $cmd->where($conditions, $params);
        return $cmd->queryScalar();
    }
    
    /**
     * init model
     * @return DModel
     */
    protected function instantiate()
	{
		$class = get_class($this);
		$model = new $class();
		return $model;
	}
    
	/**
	 * make data array row to model
	 * @param array $row
	 * @param boolean $callAfterFind
	 * @return DModel the dmodel object found. Null if no record is found.
	 */
    public function toModel($row, $callAfterFind = true)
    {
        $this->beforeFind();
        if ($row !== false && is_array($row)) {
            $model = $this->instantiate();
            $model->init();
            foreach ($row as $key => $value)
                $model->$key = $value;
                
            if ($callAfterFind)
                $model->afterFind();
            return $model;
        }
        else
            return null;
    }
    
    /**
	 * make data array row to models
	 * @param array $row
	 * @param boolean $callAfterFind
	 * @return array array list of dmodels. An empty array is returned if none is found.
     */
    public function toModels($rows, $callAfterFind = true)
    {
        if ($rows) {
            foreach ($rows as $row) {
                if (is_array($row))
                    $models[] = $this->toModel($row, $callAfterFind);
                else
                    throw new CDbException('$row is not a associative array');
            }
        }
        else
            $models = array();
        return $models;
    }
    
    public function insert($attributes = null)
    {
        if ($this->beforeSave()) {
            $result = $this->getDbCommand()->insert($this->table(), $this->getAttributes($attributes)) > 0;
            if ($result)
                $this->{$this->pk()} = Yii::app()->db->getLastInsertID();
            return $result;
        }
        else
            return false;
    }
    
    /**
     * update the row
     * @param array $columns example: array(name => value)
     * @return boolean whether the deletion is successful.
     */
    public function update($attributes = null)
    {
        if ($this->beforeSave()) {
            $pk = $this->pk();
            $result = $this->updateByPk($this->$pk, $this->getAttributes($attributes)) > 0;
            $this->afterSave();
            return $result;
        }
        else
            return false;
    }
    
    public function updateByPk($pk, $columns, $conditions = '', $params = array())
    {
        if (is_numeric($pk) || is_string($pk))
            $pk = array($pk);
        $where = array('in', $this->pk(), $pk);
        if ($conditions)
            $where = array('and', $where, $conditions);
        
        return $this->updateAll($columns, $where, $params);
    }
    
    /**
     * update rows by attributes
     * @param array $attributes example array(name => value)
     * @param mixed $conditions string|array
     * @param array $params
     * @return integer number of rows affected by the execution.
     */
    public function updateAllByAttributes($columns, $attributes, $conditions = '', $params = array())
    {
        foreach ((array)$attributes as $key => $value)
            $where[] = "$key = :$key";
        $where = implode(' and ', $where);
        $where = array('and', $where, $conditions);
        $params = array_merge($params, $conditions);
        
        return $this->updateAll($columns, $conditions, $params);
    }
    
    /**
     * update the rows
     * @param array $columns example: array(name => value)
     * @param mixed $conditions string|array
     * @param array $params
     * @return integer number of rows affected by the execution.
     */
    public function updateAll($columns, $conditions = '', $params = array())
    {
        return $this->getDbCommand()->update($this->table(), $columns, $conditions, $params);
    }
    
    public function updateCounters(array $counters, $conditions, $params = array())
    {
        foreach ($counters as $key => $value)
            $columns[$key] = "$key + $value";
        return $this->getDbCommand()
            ->update($this->table(), $columns, $conditions, $params);
    }
    
    /**
     * delete the row
     * @return boolean whether the deletion is successful.
     */
    public function delete()
    {
        if ($this->beforeDelete()) {
            $pk = $this->pk();
            $result = $this->deleteByPk($this->$pk) > 0;
            $this->afterDelete();
            return (bool)$result;
        }
        else
            return false;
    }
    
    /**
     * delete the row by primary key
     * @param mixed $pk integer|string|array
     * @param mixed $conditions string|array
     * @param array $params
     * @return integer number of rows affected by the execution.
     */
    public function deleteByPk($pk, $conditions = '', $params = array())
    {
        if (is_numeric($pk) || is_string($pk))
            $pk = array($pk);
        $where = array('in', $this->pk(), $pk);
        if ($conditions)
            $where = array('and', $where, $conditions);
            
        return $this->deleteAll($where, $params);
    }
    
    /**
     * delete rows by attributes
     * @param array $attributes example array(name => value)
     * @param mixed $conditions string|array
     * @param array $params
     * @return integer number of rows affected by the execution.
     */
    public function deleteAllByAttributes($attributes, $conditions = '', $params = array())
    {
        foreach ((array)$attributes as $key => $value)
            $where[] = "$key = :$key";
        $where = implode(' and ', $where);
        $where = array('and', $where, $conditions);
        $params = array_merge($params, $conditions);
        
        return $this->deleteAll($conditions, $params);
    }
    
    /**
     * execute a delete sql
     * @param string|array $conditions
     * @param array $params
     * @return integer number of rows affected by the execution.
     */
    public function deleteAll($conditions = '', $params = array())
    {
        return $this->getDbCommand()->delete($this->table(), $conditions, $params);
    }
    
	/**
	 * Checks whether this AR has the named attribute
	 * @param string $name attribute name
	 * @return boolean whether this AR has the named attribute (table column).
	 */
	public function hasAttribute($name)
	{
		return in_array($name, $this->columns());
	}

	/**
	 * Returns the named attribute value.
	 * If this is a new record and the attribute is not set before,
	 * the default column value will be returned.
	 * If this record is the result of a query and the attribute is not loaded,
	 * null will be returned.
	 * You may also use $this->AttributeName to obtain the attribute value.
	 * @param string $name the attribute name
	 * @return mixed the attribute value. Null if the attribute is not set or does not exist.
	 * @see hasAttribute
	 */
	public function getAttribute($name)
	{
		if (property_exists($this, $name))
			return $this->$name;
		elseif (isset($this->_attributes[$name]))
			return $this->_attributes[$name];
	}

	/**
	 * Sets the named attribute value.
	 * You may also use $this->AttributeName to set the attribute value.
	 * @param string $name the attribute name
	 * @param mixed $value the attribute value.
	 * @return boolean whether the attribute exists and the assignment is conducted successfully
	 * @see hasAttribute
	 */
	public function setAttribute($name, $value)
	{
		if (property_exists($this, $name))
			$this->$name = $value;
		elseif ($this->hasAttribute($name))
			$this->_attributes[$name] = $value;
		else
			return false;
		return true;
	}
	
	public function setAttributes($values)
	{
	    if (!is_array($values)) return false;
	    foreach ($values as $key => $value)
	        $this->$key = $value;
	}
	
    public function getAttributes($names = true)
    {
        $attributes = $this->_attributes;
        foreach ($this->columns() as $column)
            if (property_exists($this, $column))
                $attributes[$column] = $this->$column;
            elseif ($names === true && !isset($attributes[$column]))
				$attributes[$column] = null;
				
	    if (is_array($names)) {
			$attrs = array();
			foreach ($names as $name) {
				if (property_exists($this, $name))
					$attrs[$name] = $this->$name;
				else
					$attrs[$name] = isset($attributes[$name]) ? $attributes[$name] : null;
			}
			return $attrs;
		}
		else
			return $attributes;
    }
    
    protected function beforeFind()
    {
    }
    
    protected function afterFind()
    {
    }
    
    protected function beforeDelete()
    {
        return true;
    }
    
    protected function afterDelete()
    {
    }
    
    protected function beforeSave()
    {
        return true;
    }
    
    protected function afterSave()
    {
    }
    
    abstract public function table();
    abstract public function columns();
    abstract public function pk();
}
