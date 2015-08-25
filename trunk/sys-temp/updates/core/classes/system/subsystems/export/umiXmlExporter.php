<?php
 class umiXmlExporter implements iUmiXmlExporter {private $objects, $elements, $dump, $source_id;public function __construct() {$this->source_id =  umiImportRelations::getInstance()->addNewSource(strtoupper(md5($this->getSiteName())));}public function setElements($v0565942fb39be0978d5774cfa5320fcb) {if(is_array($v0565942fb39be0978d5774cfa5320fcb)) {foreach ($v0565942fb39be0978d5774cfa5320fcb as $v65c10911d8b8591219a21ebacf46da01) $this->elements[] = ($v65c10911d8b8591219a21ebacf46da01 instanceof umiHierarchyElement) ? $v65c10911d8b8591219a21ebacf46da01->getId() : $v65c10911d8b8591219a21ebacf46da01;$this->fillObjects($this->elements);return true;}else {trigger_error("First argument must be an array.", E_USER_WARNING);return false;}}public function setObjects($v96c3e113f86dfac469d4412a3a3b2517) {if(is_array($v96c3e113f86dfac469d4412a3a3b2517)) {foreach ($v96c3e113f86dfac469d4412a3a3b2517 as $vbe8f80182e0c983916da7338c2c1c040) $this->objects[] = ($vbe8f80182e0c983916da7338c2c1c040 instanceof umiObject) ? $vbe8f80182e0c983916da7338c2c1c040->getId() : $vbe8f80182e0c983916da7338c2c1c040;return true;}else {trigger_error("First argument must be an array.", E_USER_WARNING);return false;}}public function run() {if (is_array($this->elements)) {$v6a7f245843454cf4f28ad7c5e2572aa2 = $this->parseElements();}else {$v6a7f245843454cf4f28ad7c5e2572aa2 = "";}$v5891da2d64975cae48d175d1e001f5da = $this->parseObjects();$vad5f82e879a9c5d6b5b442eb37e50551  = $this->getDomainPath() . "/";$v08b89d3caec7cf7e0564ae3bf9683308 = $this->getSiteName();$v0afd9202ba86aa11ce63ad7007e7990b = strtoupper(md5($v08b89d3caec7cf7e0564ae3bf9683308));$v5dc123223f4465124f5eab5e97d72725 = new umiDate(time());$vd1701d1bb6704c552b420dae7dd7f10b = $v5dc123223f4465124f5eab5e97d72725->getFormattedDate("U");$ve9a61fb3cc6ea8c818ee0df10f5a8347  = $v5dc123223f4465124f5eab5e97d72725->getFormattedDate("r");$ve76021b36d9fe4320c6fa8690f158a5a  = $v5dc123223f4465124f5eab5e97d72725->getFormattedDate(DATE_ATOM);$vb9ef165b255673dde47bff07f4390fb1 = '<' . '?xml version="1.0" encoding="utf-8"?' . '>';$vb9ef165b255673dde47bff07f4390fb1 .= <<<END

<umicmsDump>
	<siteName><![CDATA[{$v08b89d3caec7cf7e0564ae3bf9683308}]]></siteName>
	<domain>{$vad5f82e879a9c5d6b5b442eb37e50551}</domain>
	<sourceId><![CDATA[{$v0afd9202ba86aa11ce63ad7007e7990b}]]></sourceId>

	<generateTime>
			<timestamp><![CDATA[{$vd1701d1bb6704c552b420dae7dd7f10b}]]></timestamp>
			<RFC><![CDATA[{$ve9a61fb3cc6ea8c818ee0df10f5a8347}]]></RFC>
			<UTC><![CDATA[{$ve76021b36d9fe4320c6fa8690f158a5a}]]></UTC>
	</generateTime>

{$v6a7f245843454cf4f28ad7c5e2572aa2}

{$v5891da2d64975cae48d175d1e001f5da}

</umicmsDump>
END;
	<object id="{$vaf31437ce61345f416579830a98c91e5}" typeId="{$v87306dd4235ed712ebc07fe169b76f83}" isLocked="{$v975a727c9c61eaed4d1a08613b177ca8}">
		<name><![CDATA[{$v8aa5703199edd89cb7041c8f375f2c0e}]]></name>

{$v267678086336c1646720ce11b42efe04}
{$vd59a2244b2acdab008cbf3397e3f376a}

	</object>


END;
		<propertiesBlock isLocked="{$v2705faa7cf2cc5a2ad39111317b9cb84}" isPublic="{$v5c836eaf9a3ec923fc13d2784e3168e9}">
			<name><![CDATA[{$veeeb23fbd23e52a6a6ff78b9f18cbc4e}]]></name>
			<title><![CDATA[{$vd7362b6e3ba1f2a7c022a9d864601ecc}]]></title>

{$v9ff69144c9c536063fb2753e2242da46}
		</propertiesBlock>


END;

						<store id="{$vb7cd129c427cf6ae86798630b98d06aa}">
							<amount>{$ve9f40e1f1d1658681dad2dac4ae0971e}</amount>
						</store>

END;
					<storesBlock>
						{$v61af09f34bc001f3b6d9139687a723fd}
					</storesBlock>
END;

			<property isLocked="{$ve2763042762c80c9a6b0be4da2cbe6f2}" isPublic="{$v2dda6d1dda7c17f80b9a8f3e1bae58f9}">
				<name><![CDATA[{$v73f329f154a663bfda020aadcdd0b775}]]></name>
				<title><![CDATA[{$v133479bebf56554d434d59f53992e221}]]></title>

				<fieldType><![CDATA[{$v983560f49ede87197144b22c810a5087}]]></fieldType>
				<isMultiple>{$v5c4e252909242b24243818048235620d}</isMultiple>
				<isIndexed>{$v4302d2aed2186d4c573c94c3833e5ea6}</isIndexed>
				<isFilterable>{$vde794a8a1ac8e400923460b137ddac76}</isFilterable>

				<guideId>{$v9e670cc5a0728bf2df6a7753fc9a40f4}</guideId>

				<tip><![CDATA[{$v5d17718c024b76565e2df33fced306ea}]]></tip>

				<values>
{$vf09cc7ee3a9a93273f4b80601cafb00c}
				</values>
			</property>
END;
							<value>
								<timestamp><![CDATA[{$v3a6d0284e743dc4a9b86f97d6dd1a3bf['timestamp']}]]></timestamp>
								<RFC><![CDATA[{$v3a6d0284e743dc4a9b86f97d6dd1a3bf['RFC']}]]></RFC>
								<UTC><![CDATA[{$v3a6d0284e743dc4a9b86f97d6dd1a3bf['UTC']}]]></UTC>
							</value>

END;
							<value{$v7ffc4d510260a8544e5550e62ec56bc1}><![CDATA[{$v2063c1608d6e0baf80249c42e2be5804}]]></value>

END;
							<value>
								<timestamp><![CDATA[{$v3a6d0284e743dc4a9b86f97d6dd1a3bf['timestamp']}]]></timestamp>
								<RFC><![CDATA[{$v3a6d0284e743dc4a9b86f97d6dd1a3bf['RFC']}]]></RFC>
								<UTC><![CDATA[{$v3a6d0284e743dc4a9b86f97d6dd1a3bf['UTC']}]]></UTC>
							</value>

END;
							<value><![CDATA[{$v2063c1608d6e0baf80249c42e2be5804}]]></value>

END;
							<value id="{$vb80bb7740288fda1f201890375a60c8f}"{$v2a304a1348456ccd2234cd71a81bd338}><![CDATA[{$v2063c1608d6e0baf80249c42e2be5804}]]></value>
END;
	<element id="{$ve7398137766d8a8621035454620c1317}" parentId="{$ve05b19ee2921f914301c26bcc4fc8d5a}" objectId="{$vaf31437ce61345f416579830a98c91e5}" is_visible="{$ve1c6c9ef2fcbe75f26f815c4ef2e60b4}" is_active="{$v4264c638e0098acb172519b0436db099}">
		<name><![CDATA[{$vb068931cc450442b63f5b3d276ea4297}]]></name>
		<link><![CDATA[{$v2a304a1348456ccd2234cd71a81bd338}]]></link>
		<altName><![CDATA[{$vd84ff935144e00c3e1d395c2379aca47}]]></altName>

		<templateId><![CDATA[{$vd02e12eb6d6c3f6ebd763197df01e211}]]></templateId>
		<templatePath><![CDATA[{$vf9bdb7221804d6d17b654ec67c5a0735}]]></templatePath>
		<lang prefix="{$v753527be46567ad90a4203cf4b40d70e}"><![CDATA[{$vff8b918bc674d6a658430241e4a74574}]]></lang>
		<domain><![CDATA[{$vf9b9218cbe221f8b9f1292474aa6f3e4}]]></domain>

		<behaviour>
			<title><![CDATA[{$v571927edeba34435dcef63324b2a4f86}]]></title>
			<module><![CDATA[{$v5cde3b79e1c913665469de8dc2f1f8b6}]]></module>
			<method><![CDATA[{$v28843f287b7e7d3ee4ad0be8761e325d}]]></method>
		</behaviour>

		<updateTime>
				<timestamp><![CDATA[{$v2e10faa7211633841eebf971b7056c0b}]]></timestamp>
				<RFC><![CDATA[{$vd4f11866a8f58f1071bd3ae29c935c5a}]]></RFC>
				<UTC><![CDATA[{$vc10cb84e1a90ce84ef3ee424c2b1a2ef}]]></UTC>
		</updateTime>
	</element>


END;