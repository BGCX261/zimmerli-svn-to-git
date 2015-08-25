<?php

abstract class __custom_catalog {

  //TODO: Write here your own macroses
  public function is_new($id) {
    $page = umiHierarchy::getInstance()->getElement($id);
    $res = '';
    if ($page->new_item and ($page->new_item_before == '' or $page->new_item_before->timestamp >= time()))
      $res = '<span class="new"></span>';
    umiHierarchy::getInstance()->unloadElement($id);
    return $res;
  }

  public function search_by_size() {
    $pages = new selector('objects');
    $pages->types('object-type')->name('guide', 'guide');
    $pages->where('id')->equals('125');
    //$pages->limit(0,3);    
    $res = '';

    foreach ($pages as $page) {
      print_r($page);
      die;
    }


    return $res;
  }

  public function getGuideList($id, $template = 'guidelist', $arrayOnly = false) {
    if (!$id)
      return null; //id справочника

    $o = umiObjectsCollection::getInstance();
    $items = $o->getGuidedItems($id);
    if (!sizeof($items))
      return null;

    if ($arrayOnly)
      return $items;
    list($guide_block, $guide_item) = def_module::loadTemplates("catalog/{$template}.tpl", "guide_block", "guide_item");

    $s = '';
    $block_array = array();

    foreach ($items as $k => $v) {
      $line_array = array();
      $line_array['id'] = $k;
      $line_array['name'] = $items[$k];
      $s .= def_module::parseTemplate($guide_item, $line_array);
    }
    $block_array['lines'] = $s;
    unset($items);
    $s = def_module::parseTemplate($guide_block, $block_array);
    return $s;
  }

  public function size_table() {
    $page = umiHierarchy::getInstance()->getElement(112);
    //print_r($page);die;
    
    $res=$page->getValue('content');
    umiHierarchy::getInstance()->unloadElement($id);
    return $res;
  }

}

;
?>