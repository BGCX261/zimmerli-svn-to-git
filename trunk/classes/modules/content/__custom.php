<?php

abstract class __custom_content
{

	public function articles_list()
	{
		$pages = new selector('pages');
		$pages->where('hierarchy')->page('/kollekcii/');
		$res = '';
		foreach ($pages as $page)
			$res.= '
                <li>
                  <div class="img">
					<div class="i-wrap">
						<img src="' . "{$page->foto}" . '" alt="" />
					</div>
                  </div>
                  <div class="op">
					<h2><a href="/catalog1/?fields_filter[kollekciya]=' . "{$page->col_id}" . '">' . "{$page->name}" . '</a></h2>
					' . "{$page->kontent}" . '
                  </div>
                </li>
      ';


		return $res;
	}

	/**
     * Функция выводит меню в соответствии с иерархией
     * @param string $template имя файла шаблона
     * @param int $pid id страницы
     */
    public function get_site_menu($template = "default", $pid = false)
	{
		if (!$pid)
		{
		    $pid = 30;
		}
		$hierarchy = umiHierarchy::getInstance();
		if (!in_array($pid, array(113,114,115,116)))
		{
		    $pid = 30;
		} else
		{
		    return $this->get_site_menu_account($pid);
		}
		$aChilds = $hierarchy->getChilds((int) $pid, false, true, 10);
		
		$sResult = '<nav id="catalog">
			<div class="cat '.$pid.'">
			    ';
		$sResult .= $this->build_menu_by_child($aChilds);
		
		$sResult .= '</div>
		    </nav>';
		return $sResult;
	}
	public function build_menu_by_child ($aChilds = false)
	{
		if (!$aChilds || !is_array($aChilds))
		{
		    return;
		}
		$hierarchy = umiHierarchy::getInstance();
		$currentElementId = cmsController::getInstance()->getCurrentElementId();
		$allParents = $hierarchy->getAllParents($currentElementId, true);

        // получаем список коллекций для последующего использования
        $catfunc=cmsController::getInstance()->getModule('catalog');
        $collections=$catfunc->getGuideList(126, '', 1);
        // образец массива результата                
        //Array ( [620] => Business Class [622] => Pure Comfort [623] => Pureness [617] => Richelieu [618] => Royal Classic [627] => Royal Star [619] => Sea Island [625] => Silk De Luxe [626] => Timeless [621] => Urban Chic [624] => Wool & Silk )   
        
		foreach ($aChilds as $iChildId => $child)
		{
			//Рисуем меню первого уровня
			$child_element = $hierarchy->getElement($iChildId);
			if ($child_element instanceof umiHierarchyElement)
			{
				if ((int)$child_element->getObjectTypeId() != 78)// элемент не является товаром
				{
					$name = $child_element->getName();
					$altname = $child_element->getAltName();
					$link = $hierarchy->getPathById($iChildId);

                    // TODOOOOOOOOO
                    // а вот здесь тебе нужно сделать запрос - получить количество
                    // товаров данного раздела для каждой коллекции из массива $collections
                    // и после каждого раздела в меню вывести список коллекций, где кол-во
                    // товара не равно нулю, а после названия коллекции - цифру кол-ва товаров.
                    // ссылка с названия коллекции: ссылка раздела + ?fields_filter[kollekciya]=617
                    // по ходу еще надо будет поменять то, что пункты меню могут быть ссылками, а
                    // могут открываться - теперь все названия разделов будут только открываться 
                    // и показывать коллекции
                    
					$sResult .= "<ul id=\"$altname\">
					    ";
					//print_r($child_element);die;
					if (in_array($iChildId, $allParents))
					{
					    //Если раздел открыт
					    $sResult .= "<li class=\"opened\"><a href=\"$link\">$name</a>";
                   
                        
                                
					} else
					{
					    //Если раздел не открыт
					    $sResult .= "<li><a href=\"$link\">$name</a>";
					}
					if ($child_element->getParentId()!=30)// это второй уровень каталога
					{
					    //Получаем количество товаров в данной категории по коллекциям
					    
					    
					    $col_menu='';
					    foreach ($collections as $id => $collection_name)
					    {
						
						$pages = new selector('pages');
						$pages->where('hierarchy')->page($link)->childs(3);
			
						//print_r($pages); die;
						$count=0;
						foreach($pages as $page)
						{
						    if ($page->getValue('kollekciya')==$id) $count++;
						}    
						    //echo "<a href=\"{$page->link}\">{$page->getValue('kollekciya')}</a>\n";
						    //die;
						//$pages->where('kollekciya')->equals($id);
						//$count = $pages->length;
						
						if ($count)
						{
						    $kol=getRequest('fields_filter');
						    if ($kol['kollekciya']==$id and $link=='/'.getRequest('path')) $opened='class="opened'; else $opened='';
						    $col_menu .= '<li '.$opened.'"><a href="'.$link.'?fields_filter[kollekciya]='.$id.'">'.$collection_name.' <span>'.$count.'</span></a></li>
							';
						}
					    }
					    if ($col_menu!='') $sResult.='<ul>'.$col_menu.'</ul>';	
					}    
					if (count($child))
					{
					    $sResult .= $this->build_menu_by_child($child).'</li>
						';
					} else
					{	    
					    $sResult .= '</li>
						';
					}
					$sResult .= "</ul>
					    ";
				}
				
			}
			$hierarchy->unloadElement($iChildId);
		}
		return $sResult;
	}
	
	public function get_site_menu_account ($pid)
	{
	    $hier = umiHierarchy::getInstance();
	    $sResult = '<nav id="catalog">
		    <div class="cat personal">
			<div class="cat personal">
				<h4>Личный кабинет</h4>
			';
	    $aChilds = $hier->getChilds((int) $hier->getParent($pid), false, true, 1);
	    foreach ($aChilds as $iChildId => $value)
	    {
		$sClasses = '';
		if ($iChildId == $pid)
		{
		    $sClasses .= 'active';
		}
		$child_element = $hier->getElement($iChildId);
		if ($child_element instanceof umiHierarchyElement)
		{
		    $name = $child_element->getName();
		    $link = $hier->getPathById($iChildId);
		    switch ($iChildId)
		    {
			case 114:
			    $sClasses .= ' my-orders';
			    break;
			case 115:
			    $sClasses .= ' my-info';
			    break;
			case 116:
			    $sClasses .= ' my-wishes';
			    break;
		    }
		    $sResult .= '<a class="'.$sClasses.'" href="'.$link.'">'.$name.'<span></span></a>';
		}
	    }
	    $sResult .= '</div>
		</nav>';
	    return $sResult;
	}


	public function slider()
	{
		$pages = new selector('pages');
		$pages->where('hierarchy')->page('/');
		$res = '';
		foreach ($pages as $page)
			$res.= '
                <li><img src="' . "{$page->photo}" . '" alt="" /></li>
      ';


		return $res;
	}

	public function leaders_list()
	{
		$pages = new selector('pages');
		$pages->types('hierarchy-type')->name('catalog', 'object');
		$pages->where('bestseller')->equals('1');
		$pages->limit(0, 6);
		$res = '';
		foreach ($pages as $page)
			$res.= '
  <div class="item">
		<a href="' . "{$page->link}" . '">
			<img src="' . "{$page->pic1}" . '" alt="' . "{$page->name}" . '" />
			<span><b>' . "{$page->name}" . '</b></span>
		</a>
	</div>               

      ';


		return $res;
	}

	public function novelty_list()
	{
		$pages = new selector('pages');
		$pages->types('hierarchy-type')->name('catalog', 'object');
		$pages->where('new_item')->equals('1');
		//$pages->limit(0,3);    
		$res = '';
		$i = 0;
		foreach ($pages as $page)
		{
			if ($page->new_item_before == '' or $page->new_item_before->timestamp >= time())
			{
				$res.= '
  <div class="item">
		<a href="' . "{$page->link}" . '">
			<img src="' . "{$page->pic1}" . '" alt="' . "{$page->name}" . '" />
			<span><b>' . "{$page->name}" . '<!--new_item_before--></b></span>
		</a>
	</div>               

      ';
				$i++;
			}
			if ($i == 3)
				break;
		}


		return $res;
	}

}

;
?>