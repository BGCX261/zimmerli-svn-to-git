<?php
class mysqlQueryResult implements IQueryResult {private $resource  = null;private $fetchType = IQueryResult::FETCH_ARRAY;public function __construct($_mysqlResultResource, $_fetchType = IQueryResult::FETCH_ARRAY) {$this->resource  = $_mysqlResultResource;$this->fetchType = $_fetchType;}public function getIterator() {return new mysqlQueryResultIterator($this->resource, $this->fetchType);}public function setFetchType($v78897dfaf41a79226c8c760832b0f4ba) {if($v78897dfaf41a79226c8c760832b0f4ba > 3) $this->fetchType = IQueryResult::FETCH_ARRAY;else $this->fetchType = $v78897dfaf41a79226c8c760832b0f4ba;}public function getFetchType() {return $this->fetchType;}public function fetch() {$result = null;switch($this->fetchType) {case IQueryResult::FETCH_ARRAY  : $result = mysql_fetch_array($this->resource);break;case IQueryResult::FETCH_ROW    : $result = mysql_fetch_row($this->resource);break;case IQueryResult::FETCH_ASSOC  : $result = mysql_fetch_assoc($this->resource);break;case IQueryResult::FETCH_OBJECT : $result = mysql_fetch_object($this->resource);break;}return $result;}public function length() {return mysql_num_rows($this->resource);}};class mysqlQueryResultIterator implements IQueryResultIterator {private $resource = null;private $number   = 0;private $rowcount = 0;private $fetchType = IQueryResult::FETCH_ARRAY;function __construct($_mysqlResultResource, $_fetchType = IQueryResult::FETCH_ARRAY) {$this->resource = $_mysqlResultResource;$this->fetchType = $_fetchType;$this->rowcount = $this->resource ? mysql_num_rows($this->resource) : 0;}function rewind() {if($this->resource && (mysql_num_rows($this->resource) > 0)) {mysql_data_seek($this->resource, 0);}$this->number  = 0;}function valid() {return $this->number < $this->rowcount;}function key() {return $this->number;}function current() {switch($this->fetchType) {case IQueryResult::FETCH_ARRAY  : return mysql_fetch_array($this->resource);case IQueryResult::FETCH_ROW    : return mysql_fetch_row($this->resource);case IQueryResult::FETCH_ASSOC  : return mysql_fetch_assoc($this->resource);case IQueryResult::FETCH_OBJECT : return mysql_fetch_object($this->resource);}}function next() {$this->number++;}};?>
