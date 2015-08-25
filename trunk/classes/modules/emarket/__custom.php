<?php
	abstract class __emarket_custom {
		//TODO: Write here your own macroses
		
		/**
		 * Функция рисует список заказов пользователя
		 * @param string $template Название шаблона
		 * @return mixed Список заказов пользователя
		 */
		public function show_user_orders ($template = 'default')
		{
			list($tpl_block, $tpl_block_empty, $tpl_item, $tpl_order_item) = def_module::loadTemplates("emarket/" . $template, 'orders_block', 'orders_block_empty', 'orders_item', 'orders_order_item');
			$cmsController = cmsController::getInstance();
			$domain = $cmsController->getCurrentDomain();
			$domainId = $domain->getId();

			$sel = new selector('objects');
			$sel->types('object-type')->name('emarket', 'order');
			$sel->where('customer_id')->equals(customer::get()->id);
			$sel->where('name')->isNull(false);
			$sel->where('domain_id')->equals($domainId);

			if ($sel->length == 0)
				$tpl_block = $tpl_block_empty;
			
			$items_arr = array();
			foreach ($sel->result as $selOrder)
			{
				$order = order::get($selOrder->id);
				$item_arr['attribute:id'] = $order->id;
				$item_arr['attribute:name'] = $order->name;
				$item_arr['attribute:type-id'] = $order->typeId;
				$item_arr['attribute:guid'] = $order->GUID;
				$item_arr['attribute:type-guid'] = $order->typeGUID;
				$item_arr['attribute:ownerId'] = $order->ownerId;
				$item_arr['xlink:href'] = $order->xlink;
				$item_arr['attribute:delivery_allow_date'] = date('d.m.Y',$order->getValue('delivery_allow_date')->timestamp);
				//print_r($order->getValue('order_items'));
				
				//Получаем список товаров заказа
				$items = array();
				foreach ($order->getItems() as $orderItem)
				{
//					print_r($order_item); die;
					$item_line = array();
//					print_r(umiHierarchy::getInstance()->getObjectInstances($orderItem->id));
					$item_line['attribute:element_id'] = $orderItem->id;
					$item_line['attribute:name'] = $orderItem->name;
					$item_line['attribute:item_amount'] = $orderItem->getAmount();
//					$item_line['attribute:options'] = $orderItem->getOptions();
//						print_r($order_item->options);
					$items[] = def_module::parseTemplate($tpl_order_item, $item_line, false, $iOrderItemId);
					umiObjectsCollection::getInstance()->unloadObject($iOrderItemId);
				}
				
				$item_arr['subnodes:order_items'] = $items;				

				$items_arr[] = def_module::parseTemplate($tpl_item, $item_arr, false, $order->id);
			}
			return def_module::parseTemplate($tpl_block, array('subnodes:items' => $items_arr));
		}
	};
?>