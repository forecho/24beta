<?php
abstract class DActiveRecord
{
    protected static $db;
    
    private $_new = false;
    private $_pk;
    private static $_models = array();
    private $_c;
    private $_alias = 't';
    
    public function __construct()
    {
        $this->setIsNewRecord(true);
        $this->_pk = $this->primaryKey();
        
        $this->init();
        $this->afterConstruct();
    }
    
    protected function afterConstruct() {}
	
    public function __set($var, $value)
    {
        $this->$var = $value;
    }
    
    public function __get($val)
    {
        $method = 'get' . ucfirst(strtolower($val));
        return $this->$method();
    }
    
    public function __isset($var)
    {
    	return isset($this->$var);
    }
    
    public function  __unset($var)
    {
    	unset($this->$var);
    }
    
    /**
     * return DActiveRecord
     * @param string $class
     * @return DActiveRecord instance of DActiveRecord Subclass
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
	
	public function init() {}
	

	/**
	 * Returns if the current record is new.
	 * @return boolean whether the record is new and should be inserted when calling {@link save}.
	 * This property is automatically set in constructor and {@link populateRecord}.
	 * Defaults to false, but it will be set to true if the instance is created using
	 * the new operator.
	 */
	public function getIsNewRecord()
	{
		return $this->_new;
	}

	/**
	 * Sets if the record is new.
	 * @param boolean $value whether the record is new and should be inserted when calling {@link save}.
	 * @see getIsNewRecord
	 */
	public function setIsNewRecord($value)
	{
		$this->_new = $value;
	}
	
	/**
	 * 返回主键
	 * @return null|string|array 目前只支持单个主键，字符串
	 * @todo 目前只支持单个主键
	 */
    public function primaryKey()
	{
	    $pks = $this->pk();
		return $pks ? $pks : null;
	}
	
	/**
	 * 将返回的数组转化为DActiveRecord对象
	 * @param array $attributes 数据数组
	 * @param boolean $callAfterFind 是否执行afterFind方法
	 * @return DActiveRecord
	 */
	public function makeRecord($attributes, $callAfterFind = true)
	{
	    if ($attributes !== false) {
	        $record = $this->instantiate();
	        $record->init();
	        
	        foreach ($attributes as $k => $v)
	            $record->$k = $v;
	        if ($callAfterFind) $record->afterFind();
	        
	        return $record;
	    }
	    else
	        return null;
	}
	
	/**
	 * 将返回的数据列表转化为DActiveRecord对象数组
	 * @param array $data 数据数组
	 * @param boolean $callAfterFind 是否执行afterFind方法
	 * @return array DActiveRecord对象数组
	 */
	public function makeRecords($data, $callAfterFind = true)
	{
	    $records = array();
	    foreach ($data as $attributes) {
	        $record = $this->makeRecord($attributes, true);
	        if ($record !== null)
				$records[] = $record;
	    }
	    return empty($records) ? null : $records;
	}

    /**
	 * Returns the command builder used by this AR.
	 * @return DDbCommandBuilder the command builder used by this AR
	 */
	public function getCommandBuilder()
	{
		return $this->getDbConnection()->getSchema()->getCommandBuilder();
	}
	
	protected function instantiate()
	{
		$class = get_class($this);
		$model = new $class();
		return $model;
	}
	
	/**
	 * Returns the query criteria associated with this model.
	 * @param boolean $createIfNull whether to create a criteria instance if it does not exist. Defaults to true.
	 * @return CDbCriteria the query criteria that is associated with this model.
	 * This criteria is mainly used by {@link scopes named scope} feature to accumulate
	 * different criteria specifications.
	 * @since 1.0.5
	 */
	public function getDbCriteria($createIfNull = true)
	{
		if ($this->_c === null) {
			if ($createIfNull)
				$this->_c = new DDbCriteria();
		}
		return $this->_c;
	}
	
	/**
	 * Returns the table alias to be used by the find methods.
	 * In relational queries, the returned table alias may vary according to
	 * the corresponding relation declaration. Also, the default table alias
	 * set by {@link setTableAlias} may be overridden by the applied scopes.
	 * @param boolean $quote whether to quote the alias name
	 * @param boolean $checkScopes whether to check if a table alias is defined in the applied scopes so far.
	 * This parameter must be set false when calling this method in {@link defaultScope}.
	 * An infinite loop would be formed otherwise.
	 * @return string the default table alias
	 * @since 1.1.1
	 */
	public function getTableAlias($quote = false, $checkScopes = true)
	{
		if ($checkScopes && ($criteria=$this->getDbCriteria(false)) !== null && $criteria->alias != '')
			$alias = $criteria->alias;
		else
			$alias = $this->_alias;
		return $quote ? $this->getDbConnection()->getSchema()->quoteTableName($alias) : $alias;
	}
	
	/**
	 * Performs the actual DB query and populates the AR objects with the query result.
	 * This method is mainly internally used by other AR query methods.
	 * @param CDbCriteria $criteria the query criteria
	 * @param boolean $all whether to return all data
	 * @return mixed the AR objects populated with the query result
	 * @since 1.1.7
	 */
	protected function query($criteria, $all = false)
	{
        $this->beforeFind();
		if (!$all) $criteria->limit = 1;
		$command = $this->getCommandBuilder()->createFindCommand($this->tableName(), $criteria);
		return $all ? $this->makeRecords($command->queryAll(), true) : $this->makeRecord($command->queryRow());
	}
	
	protected function beforeFind()
	{
	}
	
	protected function afterFind()
	{
	}
    
    /**
     * 返回系统 db 对象
     * @return CDbConnection the database connection used by active record.
     */
    public function getDbConnection()
	{
		if (self::$db !== null)
			return self::$db;
		else
			return self::$db = Cdc::app()->getDb();
	}
    
    public function find($condition = '', $params = array())
    {
        $criteria = $this->getCommandBuilder()->createCriteria($condition, $params);
		return $this->query($criteria);
    }
    
	/**
	 * Finds a single active record with the specified SQL statement.
	 * @param string $sql the SQL statement
	 * @param array $params parameters to be bound to the SQL statement
	 * @return CActiveRecord the record found. Null if none is found.
	 */
	public function findBySql($sql, $params = array())
	{
		$this->beforeFind();
		$command = $this->getCommandBuilder()->createSqlCommand($sql, $params);
		return $this->makeRecord($command->queryRow());
	}
	
    
    public function findAll($condition = '', $params = array())
    {
        $criteria = $this->getCommandBuilder()->createCriteria($condition, $params);
		return $this->query($criteria, true);
    }

	/**
	 * Finds all active records using the specified SQL statement.
	 * @param string $sql the SQL statement
	 * @param array $params parameters to be bound to the SQL statement
	 * @return array the records found. An empty array is returned if none is found.
	 */
	public function findAllBySql($sql, $params = array())
	{
		$this->beforeFind();
		$command = $this->getCommandBuilder()->createSqlCommand($sql, $params);
		return $this->makeRecords($command->queryAll());
	}
	
	/** Finds the number of rows satisfying the specified query condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return string the number of rows satisfying the specified query condition. Note: type is string to keep max. precision.
	 */
	public function count($condition = '', $params = array())
	{
		$builder = $this->getCommandBuilder();
		$criteria = $builder->createCriteria($condition, $params);

		return $builder->createCountCommand($this->tableName(), $criteria)->queryScalar();
	}

	/**
	 * Finds the number of rows using the given SQL statement.
	 * This is equivalent to calling {@link CDbCommand::queryScalar} with the specified
	 * SQL statement and the parameters.
	 * @param string $sql the SQL statement
	 * @param array $params parameters to be bound to the SQL statement
	 * @return string the number of rows using the given SQL statement. Note: type is string to keep max. precision.
	 */
	public function countBySql($sql, $params = array())
	{
		return $this->getCommandBuilder()->createSqlCommand($sql, $params)->queryScalar();
	}

	/**
	 * Checks whether there is row satisfying the specified condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return boolean whether there is row satisfying the specified condition.
	 */
	public function exists($condition = '', $params = array())
	{
		$builder = $this->getCommandBuilder();
		$criteria = $builder->createCriteria($condition, $params);
		$criteria->select = '1';
		$criteria->limit = 1;
		return $builder->createFindCommand($this->tableName(), $criteria)->queryRow() !== false;
	}
	
	/**
	 * Updates records with the specified condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * Note, the attributes are not checked for safety and no validation is done.
	 * @param array $data list of attributes (name=>$value) to be updated
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return integer the number of rows being updated
	 */
	public function updateAll($data, $condition = '', $params = array())
	{
		$builder = $this->getCommandBuilder();
		$criteria = $builder->createCriteria($condition, $params);
		$command = $builder->createUpdateCommand($this->tableName(), $data, $criteria);
		return $command->execute();
	}
	

	/**
	 * Updates one or several counter columns.
	 * Note, this updates all rows of data unless a condition or criteria is specified.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param array $counters the counters to be updated (column name=>increment value)
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return integer the number of rows being updated
	 */
	public function updateCounters($counters, $condition = '', $params = array())
	{
		$builder = $this->getCommandBuilder();
		$criteria = $builder->createCriteria($condition, $params);
		$command = $builder->createUpdateCounterCommand($this->tableName(), $counters, $criteria);
		return $command->execute();
	}
	
	/**
	 * Deletes rows with the specified condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return integer the number of rows deleted
	 */
	public function deleteAll($condition = '', $params = array())
	{
		$builder = $this->getCommandBuilder();
		$criteria = $builder->createCriteria($condition, $params);
		$command = $builder->createDeleteCommand($this->tableName(), $criteria);
		return $command->execute();
	}
	
    protected function beforeSave()
	{
	    return true;
	}
	
	public function insert($attributes)
	{
	    $data = array();
	    foreach ($this->columns() as $column)
	        if (property_exists($this, $column))
    	        $data[$column] = $this->$column;
        
	    if ($this->beforeSave()) {
    	    $builder = $this->getCommandBuilder();
    	    $command = $builder->createInsertCommand($this->tableName(), $data);
    	    if ($command->execute()) {
    	        $pk = $this->primaryKey();
    	        if (is_string($pk))
    	            $this->$pk = $builder->getLastInsertID($this->tableName());

    	        $this->setIsNewRecord(false);
    	        $this->afterSave();
    	        return true;
    	    }
	    }
	    
	    return false;
	}
	
    protected function afterSave()
	{
	}
	
	abstract public function tableName();
	abstract public function columns();
	abstract public function pk();
	
}