<?php
 class umiSelectionsParser implements iUmiSelectionsParser {private function __construct() {}public static function runSelection(umiSelection $vef5714e0519bfaa645cdff7d28843b70) {static $v41275a535677f79ff347e01bc530c176;if ($vef5714e0519bfaa645cdff7d28843b70->result !== false) return $vef5714e0519bfaa645cdff7d28843b70->result;$v59f8ce5cb01404063bd7eb308df3b7dc = self::parseSelection($vef5714e0519bfaa645cdff7d28843b70);if (!$v59f8ce5cb01404063bd7eb308df3b7dc['result']) return false;$result = l_mysql_query($v59f8ce5cb01404063bd7eb308df3b7dc['result']);$v9b207167e5381c47682c6b4f58a623fb = Array();while ($vf1965a857bc285d26fe22023aa5ab50d = mysql_fetch_row($result)) {list($v7057e8409c7c531a1a6e9ac3df4ed549) = $vf1965a857bc285d26fe22023aa5ab50d;if(isset($vf1965a857bc285d26fe22023aa5ab50d[1])) {if(!$v41275a535677f79ff347e01bc530c176) {$v41275a535677f79ff347e01bc530c176 = permissionsCollection::getInstance();}$v41275a535677f79ff347e01bc530c176->pushElementPermissions($v7057e8409c7c531a1a6e9ac3df4ed549, $vf1965a857bc285d26fe22023aa5ab50d[1]);}$v7057e8409c7c531a1a6e9ac3df4ed549 = intval($v7057e8409c7c531a1a6e9ac3df4ed549);if(in_array($v7057e8409c7c531a1a6e9ac3df4ed549, $v9b207167e5381c47682c6b4f58a623fb) == false) {$v9b207167e5381c47682c6b4f58a623fb[] = $v7057e8409c7c531a1a6e9ac3df4ed549;}}if($vef5714e0519bfaa645cdff7d28843b70->excludeNestedPages) {$v9b207167e5381c47682c6b4f58a623fb = self::excludeNestedPages($v9b207167e5381c47682c6b4f58a623fb);}$vef5714e0519bfaa645cdff7d28843b70->result = $v9b207167e5381c47682c6b4f58a623fb;if(defined("DISABLE_CALC_FOUND_ROWS")) {if(DISABLE_CALC_FOUND_ROWS) {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT FOUND_ROWS()";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);list($ve2942a04780e223b215eb8b663cf5353) = mysql_fetch_row($result);$vef5714e0519bfaa645cdff7d28843b70->count = $ve2942a04780e223b215eb8b663cf5353;}}if ($vef5714e0519bfaa645cdff7d28843b70->optimize_root_search_query) {$vef5714e0519bfaa645cdff7d28843b70->count = false;}return $vef5714e0519bfaa645cdff7d28843b70->result;}public static function runSelectionCounts(umiSelection $vef5714e0519bfaa645cdff7d28843b70) {if ($vef5714e0519bfaa645cdff7d28843b70->count !== false) return $vef5714e0519bfaa645cdff7d28843b70->count;$v59f8ce5cb01404063bd7eb308df3b7dc = self::parseSelection($vef5714e0519bfaa645cdff7d28843b70);if (!$v59f8ce5cb01404063bd7eb308df3b7dc['count']) return false;if ($ve2942a04780e223b215eb8b663cf5353 = cacheFrontend::getInstance()->loadSql($v59f8ce5cb01404063bd7eb308df3b7dc['count'])) {return $ve2942a04780e223b215eb8b663cf5353;}$result = l_mysql_query($v59f8ce5cb01404063bd7eb308df3b7dc['count']);if (list($ve2942a04780e223b215eb8b663cf5353) = mysql_fetch_row($result)) {$vef5714e0519bfaa645cdff7d28843b70->count = intval($ve2942a04780e223b215eb8b663cf5353);cacheFrontend::getInstance()->saveSql($v59f8ce5cb01404063bd7eb308df3b7dc['count'], $vef5714e0519bfaa645cdff7d28843b70->count);return $vef5714e0519bfaa645cdff7d28843b70->count;}else {return false;}}public static function parseSelection(umiSelection $vef5714e0519bfaa645cdff7d28843b70) {if(!defined('MAX_SELECTION_TABLE_JOINS')) {define('MAX_SELECTION_TABLE_JOINS', 10);}$vef5714e0519bfaa645cdff7d28843b70->sql_cond__need_content = false;$vef5714e0519bfaa645cdff7d28843b70->sql_cond__need_hierarchy = $vef5714e0519bfaa645cdff7d28843b70->getForceCond();$vef5714e0519bfaa645cdff7d28843b70->sql_cond__domain_ignored = $vef5714e0519bfaa645cdff7d28843b70->getIsDomainIgnored();$vef5714e0519bfaa645cdff7d28843b70->sql_cond__lang_ignored = $vef5714e0519bfaa645cdff7d28843b70->getIsLangIgnored();$vef5714e0519bfaa645cdff7d28843b70->sql_cond__total_joins = 0;$vef5714e0519bfaa645cdff7d28843b70->sql_cond__content_tables_loaded = 0;$vef5714e0519bfaa645cdff7d28843b70->sql_arr_for_mark_used_fields = array();$vef5714e0519bfaa645cdff7d28843b70->sql_arr_for_and_or_part = array();$vef5714e0519bfaa645cdff7d28843b70->sql_part__hierarchy = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__element_type = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__object_type = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__owner = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__objects = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__elements = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__perms = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__props_and_names = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__lang_cond = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__domain_cond = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__unactive_cond = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__perms_tables = "";$vef5714e0519bfaa645cdff7d28843b70->sql_part__content_tables = "";$vef5714e0519bfaa645cdff7d28843b70->sql_kwd_distinct = "";$vef5714e0519bfaa645cdff7d28843b70->sql_kwd_distinct_count = "";$vef5714e0519bfaa645cdff7d28843b70->sql_kwd_straight_join = "";$vef5714e0519bfaa645cdff7d28843b70->sql_select_expr = "";$vef5714e0519bfaa645cdff7d28843b70->sql_table_references = "";$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_required = "";$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_common = "";$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_additional = "";$vef5714e0519bfaa645cdff7d28843b70->sql_order_by = "";$vef5714e0519bfaa645cdff7d28843b70->sql_limit = "";self::makeLimitPart($vef5714e0519bfaa645cdff7d28843b70);self::makeHierarchyPart($vef5714e0519bfaa645cdff7d28843b70);self::makeElementTypePart($vef5714e0519bfaa645cdff7d28843b70);self::makeOwnerPart($vef5714e0519bfaa645cdff7d28843b70);self::makeObjectsPart($vef5714e0519bfaa645cdff7d28843b70);self::makeElementsPart($vef5714e0519bfaa645cdff7d28843b70);self::makePermsParts($vef5714e0519bfaa645cdff7d28843b70);self::makePropPart($vef5714e0519bfaa645cdff7d28843b70);self::makeObjectTypePart($vef5714e0519bfaa645cdff7d28843b70);self::makeOrderPart($vef5714e0519bfaa645cdff7d28843b70);self::makeNamesPart($vef5714e0519bfaa645cdff7d28843b70);self::makePropsAndNames($vef5714e0519bfaa645cdff7d28843b70);self::makeHierarchySpecificConds($vef5714e0519bfaa645cdff7d28843b70);if ($vef5714e0519bfaa645cdff7d28843b70->sql_cond__total_joins >= 59) {return Array("result" => false, "count" => false);}self::makeDistinctKeywords($vef5714e0519bfaa645cdff7d28843b70);self::makeStraitJoinKeyword($vef5714e0519bfaa645cdff7d28843b70);self::makeSelectExpr($vef5714e0519bfaa645cdff7d28843b70);self::makeTables($vef5714e0519bfaa645cdff7d28843b70);self::makeWhereConditions($vef5714e0519bfaa645cdff7d28843b70);$v1126b3d9572018ac34b2e234c00dc2c3 = "";$v7dabf5c198b0bab2eaa42bb03a113e55 = sizeof($vef5714e0519bfaa645cdff7d28843b70->usedContentTables);if($v7dabf5c198b0bab2eaa42bb03a113e55 > 1) {for($v865c0c0b4ab0e063e5caa3387c1a8741 = 0;$v865c0c0b4ab0e063e5caa3387c1a8741 < $v7dabf5c198b0bab2eaa42bb03a113e55 - 1;$v865c0c0b4ab0e063e5caa3387c1a8741++) {$v43b5c9175984c071f30b873fdce0a000 = $vef5714e0519bfaa645cdff7d28843b70->usedContentTables[$v865c0c0b4ab0e063e5caa3387c1a8741];$vd0cab90d8d20d57e2f2b9be52f7dd25d = $vef5714e0519bfaa645cdff7d28843b70->usedContentTables[$v865c0c0b4ab0e063e5caa3387c1a8741 + 1];$v1126b3d9572018ac34b2e234c00dc2c3 .= " AND {$v43b5c9175984c071f30b873fdce0a000}.obj_id = {$vd0cab90d8d20d57e2f2b9be52f7dd25d}.obj_id";}}$v16efe07aeec5bc36c29c1116370aaf55 = "";if(defined("DISABLE_CALC_FOUND_ROWS")) {if(DISABLE_CALC_FOUND_ROWS) {$v16efe07aeec5bc36c29c1116370aaf55 = "SQL_CALC_FOUND_ROWS";}}if($vef5714e0519bfaa645cdff7d28843b70->sql_part__perms_tables) {$vef5714e0519bfaa645cdff7d28843b70->sql_kwd_distinct = "";$vef5714e0519bfaa645cdff7d28843b70->sql_group_by = " GROUP BY h.id";}else {$vef5714e0519bfaa645cdff7d28843b70->sql_group_by = "";}$vac5c74b64b4b8352ef2f181affb5ac2a = <<<SQL
				SELECT {$vef5714e0519bfaa645cdff7d28843b70->sql_kwd_straight_join} {$v16efe07aeec5bc36c29c1116370aaf55}  {$vef5714e0519bfaa645cdff7d28843b70->sql_kwd_distinct}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_select_expr}
				FROM
					{$vef5714e0519bfaa645cdff7d28843b70->sql_table_references}
				WHERE
					{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_required}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_common}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_additional}
					{$v1126b3d9572018ac34b2e234c00dc2c3}
				{$vef5714e0519bfaa645cdff7d28843b70->sql_group_by}
				{$vef5714e0519bfaa645cdff7d28843b70->sql_order_by}
				{$vef5714e0519bfaa645cdff7d28843b70->sql_limit}
SQL;
				SELECT {$vef5714e0519bfaa645cdff7d28843b70->sql_kwd_straight_join} 
					COUNT({$vef5714e0519bfaa645cdff7d28843b70->sql_kwd_distinct_count}{$vef5714e0519bfaa645cdff7d28843b70->sql_select_count_expr})
				FROM
					{$vef5714e0519bfaa645cdff7d28843b70->sql_table_references}
				WHERE
					{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_required}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_common}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_additional}
					{$v1126b3d9572018ac34b2e234c00dc2c3}
SQL;
SELECT DISTINCT h.id
	FROM cms3_hierarchy hp
		{$vef5714e0519bfaa645cdff7d28843b70->sql_table_references}
		WHERE h.type_id IN ({$vca7adb9881c5ed53066501aa82aae638})
			AND (h.rel = 0 OR (h.rel = hp.id AND hp.type_id NOT IN ({$vca7adb9881c5ed53066501aa82aae638}))) {$vef5714e0519bfaa645cdff7d28843b70->sql_part__domain_cond} {$vef5714e0519bfaa645cdff7d28843b70->sql_part__lang_cond}
			AND h.is_deleted = '0'
			{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_required}
			{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_common}
			{$vef5714e0519bfaa645cdff7d28843b70->sql_where_condition_additional}
				{$vef5714e0519bfaa645cdff7d28843b70->sql_order_by}
				{$vef5714e0519bfaa645cdff7d28843b70->sql_limit}
SQL;
SELECT COUNT(DISTINCT h.id) FROM cms3_hierarchy h, cms3_hierarchy hp WHERE h.type_id IN ({$vca7adb9881c5ed53066501aa82aae638}) AND (h.rel = 0 OR (h.rel = hp.id AND hp.type_id NOT IN ({$vca7adb9881c5ed53066501aa82aae638}))) {$vef5714e0519bfaa645cdff7d28843b70->sql_part__domain_cond} {$vef5714e0519bfaa645cdff7d28843b70->sql_part__lang_cond} AND h.is_deleted = '0'
SQL;
					{$ve73bcc9cfc2941d6e1afe96205af0d0e}
					cms3_hierarchy h
					{$v3e4e493f22840daa9ac1724a72ab3e69}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__perms_tables}
SQL;
					cms3_objects o
					{$v3e4e493f22840daa9ac1724a72ab3e69}
SQL;
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__object_type}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__props_and_names}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__owner}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__objects}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__elements}
SQL;
					{$v0e2dd3565df1bb7b04bb23eee21bef0b}
					h.is_deleted = '0'
SQL;
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__hierarchy}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__unactive_cond}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__element_type}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__perms}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__lang_cond}
					{$vef5714e0519bfaa645cdff7d28843b70->sql_part__domain_cond}
SQL;
({$v131eec2e3a1c0cebac938273907d5290} AND hr.level <= '{$vb81e229503292fbbcb3ff39f8fb2ce76}') AND hr.child_id = h.id
SQL;
SELECT  MIN(fg.type_id)
	FROM cms3_fields_controller fc, cms3_object_field_groups fg
	WHERE fc.field_id = {$v945100186b119048837b9859c2c46410} AND fg.id = fc.group_id
SQL;
SELECT of.id
	FROM cms3_object_fields of, cms3_object_field_types oft
		WHERE of.field_type_id = oft.id
		AND oft.data_type IN ('file', 'img_file', 'swf_file')
SQL;