<?php
 class umiObjectProxy {protected $object;protected function __construct(umiObject $va8cfde6331bd59eb2ac96f8911c4b666) {$this->object = $va8cfde6331bd59eb2ac96f8911c4b666;}public function getId() {return $this->object->getId();}public function setName($vb068931cc450442b63f5b3d276ea4297) {$this->object->setName($vb068931cc450442b63f5b3d276ea4297);}public function getName() {return $this->object->getName();}public function setValue($v46b9e6004c49d9cc040029c197cab278, $v2063c1608d6e0baf80249c42e2be5804) {return $this->object->setValue($v46b9e6004c49d9cc040029c197cab278, $v2063c1608d6e0baf80249c42e2be5804);}public function getValue($v46b9e6004c49d9cc040029c197cab278) {return $this->object->getValue($v46b9e6004c49d9cc040029c197cab278);}public function isFilled() {return $this->object->isFilled();}public function getObject() {return $this->object;}public function commit() {return $this->object->commit();}public function delete() {$v5891da2d64975cae48d175d1e001f5da = umiObjectsCollection::getInstance();return $v5891da2d64975cae48d175d1e001f5da->delObject($this->getId());}public function __get($v23a5b8ab834cb5140fa6665622eb6417) {switch($v23a5b8ab834cb5140fa6665622eb6417) {case 'id':  return $this->getId();case 'name': return $this->getName();default:  return $this->getValue($v23a5b8ab834cb5140fa6665622eb6417);}}public function __set($v23a5b8ab834cb5140fa6665622eb6417, $v2063c1608d6e0baf80249c42e2be5804) {switch($v23a5b8ab834cb5140fa6665622eb6417) {case 'name': return $this->setName($v2063c1608d6e0baf80249c42e2be5804);default:  return $this->setValue($v23a5b8ab834cb5140fa6665622eb6417, $v2063c1608d6e0baf80249c42e2be5804);}}public function __destruct() {$this->object->commit();}};?>