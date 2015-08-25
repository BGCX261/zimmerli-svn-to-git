<?php

class cmsController extends singleton implements iSingleton, iCmsController
{

    protected $modules = array(), $current_module = false, $current_method = false, $current_mode = false, $current_element_id = false, $current_lang = false, $current_domain = false, $current_templater = false, $calculated_referer_uri = false, $modulesPath, $url_prefix = '', $adminDataSet = array();
	    public $parsedContent = false, $currentTitle = false, $currentHeader = false, $currentMetaKeywords = false, $currentMetaDescription = false, $currentEditElementId = false, $langs = array(), $langs_export = array(), $pre_lang = "", $errorUrl, $headerLabel = false;
    public $isContentMode = false;
    public static $IGNORE_MICROCACHE = false;

    protected function __construct()
    {
	$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();
	showWorkTime("cmscontroller mainconfig init");
	$this->modulesPath = $v2245023265ae4cf87d02c8b6ba991139->includeParam('system.modules');
	showWorkTime("cmscontroller includeparam");
	$this->init();
	showWorkTime("cmscontroller init");
    }

    public static function getInstance($v4a8a08f09d37b73795649038408b5f33 = NULL)
    {
	return parent::getInstance(__CLASS__);
    }

    private function loadModule($v854203cccade0bbe21be239a208aea49)
    {
	$v3d788fa62d7c185a1bee4c9147ee1091 = "//modules/" . $v854203cccade0bbe21be239a208aea49;
	if (!defined("CURRENT_VERSION_LINE"))
	{
	    define("CURRENT_VERSION_LINE", "");
	}if (regedit::getInstance()->getVal($v3d788fa62d7c185a1bee4c9147ee1091) == $v854203cccade0bbe21be239a208aea49)
	{
	    $va8b32a4ad344b2574316ceac9b89c028 = $this->modulesPath . $v854203cccade0bbe21be239a208aea49 . "/class.php";
	    if (file_exists($va8b32a4ad344b2574316ceac9b89c028))
	    {
		require_once $va8b32a4ad344b2574316ceac9b89c028;
		if (class_exists($v854203cccade0bbe21be239a208aea49))
		{
		    $vaeae00c17480e2734db07010c518d054 = new $v854203cccade0bbe21be239a208aea49();
		    $vaeae00c17480e2734db07010c518d054->pre_lang = $this->pre_lang;
		    $vaeae00c17480e2734db07010c518d054->pid = $this->getCurrentElementId();
		    $this->modules[$v854203cccade0bbe21be239a208aea49] = $vaeae00c17480e2734db07010c518d054;
		    return $vaeae00c17480e2734db07010c518d054;
		}
	    } else
	    {
		return false;
	    }
	} else
	{
	    return false;
	}
    }

    public function loadBuildInModule($v52a43e48ec4649dee819dadabcab1bde)
    {
	
    }

    public function getModule($v854203cccade0bbe21be239a208aea49)
    {
	if (!$v854203cccade0bbe21be239a208aea49)
	{
	    return false;
	}if (array_key_exists($v854203cccade0bbe21be239a208aea49, $this->modules))
	{
	    return $this->modules[$v854203cccade0bbe21be239a208aea49];
	} else
	{
	    return $this->loadModule($v854203cccade0bbe21be239a208aea49);
	}
    }

    public function installModule($v8e74155194666debb2f773d1de2ae7fe)
    {
	if (!file_exists($v8e74155194666debb2f773d1de2ae7fe))
	{
	    throw new publicAdminException(getLabel("label-errors-13052"), 13052);
	}require_once $v8e74155194666debb2f773d1de2ae7fe;
	preg_match("|\/modules\/(\S+)\/|i", $v8e74155194666debb2f773d1de2ae7fe, $v9c28d32df234037773be184dbdafc274);
	$v4d1ee841197b38b197ce7dd594ab3333 = $v9c28d32df234037773be184dbdafc274[1];
	if ($v4d1ee841197b38b197ce7dd594ab3333 != $INFO['name'])
	{
	    throw new publicAdminException(getLabel("label-errors-13053"), 13053);
	}$this->checkModuleByName($v4d1ee841197b38b197ce7dd594ab3333);
	$this->checkModuleComponents($COMPONENTS);
	def_module::install($INFO);
    }

    private function checkModuleComponents($v4725dcf446a342f1473a8228e42dfa48)
    {
	if (!is_array($v4725dcf446a342f1473a8228e42dfa48))
	{
	    return false;
	}$v45b963397aa40d4a0063e0d85e4fe7a1 = array();
	foreach ($v4725dcf446a342f1473a8228e42dfa48 as $v700c216fb376666eaeda0c892e8bdc09)
	{
	    $v8c7dd922ad47494fc02c388e12c00eac = preg_replace("/.\/(.+)/", CURRENT_WORKING_DIR . '/' . "$1", $v700c216fb376666eaeda0c892e8bdc09);
	    if (!file_exists($v8c7dd922ad47494fc02c388e12c00eac) || !is_readable($v8c7dd922ad47494fc02c388e12c00eac))
	    {
		$v45b963397aa40d4a0063e0d85e4fe7a1[] = $v8c7dd922ad47494fc02c388e12c00eac;
	    }
	}if (count($v45b963397aa40d4a0063e0d85e4fe7a1))
	{
	    $vcb5e100e5a9a3e7f6d1fd97512215282 = getLabel("label-errors-13058") . "\n";
	    foreach ($v45b963397aa40d4a0063e0d85e4fe7a1 as $v8c7dd922ad47494fc02c388e12c00eac)
	    {
		$vcb5e100e5a9a3e7f6d1fd97512215282 .= getLabel('error-file-does-not-exist', null, $v8c7dd922ad47494fc02c388e12c00eac) . "\n";
	    }throw new coreException($vcb5e100e5a9a3e7f6d1fd97512215282);
	}
    }

    private function checkModuleByName($v854203cccade0bbe21be239a208aea49)
    {
	if (!defined("UPDATE_SERVER"))
	{
	    define("UPDATE_SERVER", base64_decode('aHR0cDovL3VwZGF0ZXMudW1pLWNtcy5ydS91cGRhdGVzZXJ2ZXIv'));
	}$vb1444fb0c07653567ad325aa25d4e37a = regedit::getInstance();
	$v14a0ffee308315f250f040d5b4d48560 = domainsCollection::getInstance();
	$vcaf9b6b99962bf5c2264824231d7a40c = array();
	$vcaf9b6b99962bf5c2264824231d7a40c['type'] = 'get-modules-list';
	$vcaf9b6b99962bf5c2264824231d7a40c['revision'] = $vb1444fb0c07653567ad325aa25d4e37a->getVal("//modules/autoupdate/system_build");
	$vcaf9b6b99962bf5c2264824231d7a40c['host'] = $v14a0ffee308315f250f040d5b4d48560->getDefaultDomain()->getHost();
	$vcaf9b6b99962bf5c2264824231d7a40c['ip'] = getServer('SERVER_ADDR');
	$vcaf9b6b99962bf5c2264824231d7a40c['key'] = $vb1444fb0c07653567ad325aa25d4e37a->getVal("//settings/keycode");
	$v572d4e421e5e6b9bc11d815e8a027112 = UPDATE_SERVER . "?" . http_build_query($vcaf9b6b99962bf5c2264824231d7a40c, '', '&');
	$result = $this->get_file($v572d4e421e5e6b9bc11d815e8a027112);
	if (!$result)
	{
	    throw new publicAdminException(getLabel("label-errors-13054"), 13054);
	}$v0f635d0e0f3874fff8b581c132e6c7a7 = new DOMDocument();
	if (!$v0f635d0e0f3874fff8b581c132e6c7a7->loadXML($result))
	{
	    throw new publicAdminException(getLabel("label-errors-13055"), 13055);
	}$v3d788fa62d7c185a1bee4c9147ee1091 = new DOMXPath($v0f635d0e0f3874fff8b581c132e6c7a7);
	$v07213a0161f52846ab198be103b5ab43 = $v3d788fa62d7c185a1bee4c9147ee1091->query("error");
	if ($v07213a0161f52846ab198be103b5ab43->length != 0)
	{
	    $vc13367945d5d4c91047b3b50234aa7ab = $v07213a0161f52846ab198be103b5ab43->item(0)->getAttribute("code");
	    throw new publicAdminException(getLabel("label-errors-" . $vc13367945d5d4c91047b3b50234aa7ab), $vc13367945d5d4c91047b3b50234aa7ab);
	}$v0eb9b3af2e4a00837a1b1a854c9ea18c = $v3d788fa62d7c185a1bee4c9147ee1091->query("module");
	if ($v0eb9b3af2e4a00837a1b1a854c9ea18c->length == 0)
	{
	    throw new publicAdminException(getLabel("label-errors-13056"), 13056);
	}$v854203cccade0bbe21be239a208aea49 = strtolower($v854203cccade0bbe21be239a208aea49);
	$v0eb9b3af2e4a00837a1b1a854c9ea18c = $v3d788fa62d7c185a1bee4c9147ee1091->query("module[@name='" . $v854203cccade0bbe21be239a208aea49 . "']");
	if ($v0eb9b3af2e4a00837a1b1a854c9ea18c->length != 0)
	{
	    $v22884db148f0ffb0d830ba431102b0b5 = $v0eb9b3af2e4a00837a1b1a854c9ea18c->item(0);
	    if ($v22884db148f0ffb0d830ba431102b0b5->getAttribute("active") != "1")
	    {
		throw new publicAdminException(getLabel("label-errors-13057"), 13057);
	    }
	}
    }

    private function get_file($v572d4e421e5e6b9bc11d815e8a027112)
    {
	try
	{
	    $result = umiRemoteFileGetter::get($v572d4e421e5e6b9bc11d815e8a027112);
	    return $result;
	} catch (Exception $ve1671797c52e15f763380b45e841ec32)
	{
	    throw new publicAdminException(getLabel("label-errors-13041"), 13041);
	}
    }

    public function getSkinPath()
    {
	
    }

    public function getCurrentModule()
    {
	return $this->current_module;
    }

    public function getCurrentMethod()
    {
	return $this->current_method;
    }

    public function getCurrentElementId()
    {
	return $this->current_element_id;
    }

    public function getLang()
    {
	return $this->current_lang;
    }

    public function getCurrentLang()
    {
	return $this->getLang();
    }

    public function getCurrentMode()
    {
	return $this->current_mode;
    }

    public function getCurrentDomain()
    {
	return $this->current_domain;
    }

    public function getCurrentTemplater()
    {
	if (!$this->current_templater instanceof umiTemplater)
	{
	    $this->detectCurrentTemplater();
	}if (!$this->current_templater instanceof umiTemplater)
	{
	    throw new coreException("Can't detect current templater.");
	}return $this->current_templater;
    }

    public function getResourcesDirectory($v64feae0988f5b61c96c305e3c3f04551 = false)
    {
	if ($this->getCurrentMode() == 'admin')
	{
	    if (($v66f6181bcb4cff4cd38fbc804a036db6 = templatesCollection::getInstance()->getDefaultTemplate()) instanceof template)
	    {
		return $v66f6181bcb4cff4cd38fbc804a036db6->getResourcesDirectory($v64feae0988f5b61c96c305e3c3f04551);
	    }return false;
	}if (($v66f6181bcb4cff4cd38fbc804a036db6 = $this->detectCurrentDesignTemplate()) instanceof template)
	{
	    return $v66f6181bcb4cff4cd38fbc804a036db6->getResourcesDirectory($v64feae0988f5b61c96c305e3c3f04551);
	} else
	{
	    return false;
	}
    }

    public function getTemplatesDirectory()
    {
	if (($v66f6181bcb4cff4cd38fbc804a036db6 = $this->detectCurrentDesignTemplate()) instanceof template)
	{
	    return $v66f6181bcb4cff4cd38fbc804a036db6->getTemplatesDirectory();
	} else
	{
	    return CURRENT_WORKING_DIR . "xsltTpls/";
	}
    }

    public function setCurrentTemplater()
    {
	return $this->getCurrentTemplater();
    }

    public function getGlobalVariables($v2d4260a0fcf0c77266e1b8f41bd4080c = false)
    {
	static $v6d9fecd2868e8a635b6d088c3e8068c2;
	if (!$v2d4260a0fcf0c77266e1b8f41bd4080c && !is_null($v6d9fecd2868e8a635b6d088c3e8068c2)) return $v6d9fecd2868e8a635b6d088c3e8068c2;$v6d9fecd2868e8a635b6d088c3e8068c2 = array();
	if ($this->getCurrentMode() == 'admin')
	{
	    return $v6d9fecd2868e8a635b6d088c3e8068c2 = $this->prepareAdminSideGlobalVariables();
	}if (def_module::isXSLTResultMode())
	{
	    return $v6d9fecd2868e8a635b6d088c3e8068c2 = $this->prepareClientSideGlobalVariablesForXSLT();
	} else
	{
	    return $v6d9fecd2868e8a635b6d088c3e8068c2 = $this->prepareClientSideGlobalVariablesForTPL();
	}
    }

    private function prepareAdminSideGlobalVariables()
    {
	$v41275a535677f79ff347e01bc530c176 = permissionsCollection::getInstance();
	$ve4e46deb7f9cc58c7abfb32e5570b6f3 = domainsCollection::getInstance();
	$vb1444fb0c07653567ad325aa25d4e37a = regedit::getInstance();
	$result = array('@module' => $this->current_module, '@method' => $this->current_method, '@lang' => $this->current_lang->getPrefix(), '@lang-id' => $this->current_lang->getId(), '@pre-lang' => $this->pre_lang, '@domain' => $this->current_domain->getHost(), '@domain-id' => $this->current_domain->getId(), '@session-lifetime' => defined('SESSION_LIFETIME') ? SESSION_LIFETIME : 0, '@system-build' => $vb1444fb0c07653567ad325aa25d4e37a->getVal("//modules/autoupdate/system_build"), '@referer-uri' => $this->getCalculatedRefererUri(), '@user-id' => $v41275a535677f79ff347e01bc530c176->getUserId(), '@interface-lang' => ulangStream::getLangPrefix());
	if (defined('CURRENT_VERSION_LINE') && CURRENT_VERSION_LINE == 'demo')
	{
	    $result['@demo'] = 1;
	}if ($vb6ee27ee7fe19b0c0dd907d5f947aa12 = getServer('REQUEST_URI'))
	{
	    $vafbad9dc43d3b9eb8533cd54a4df6a87 = parse_url($vb6ee27ee7fe19b0c0dd907d5f947aa12);
	    $vb6ee27ee7fe19b0c0dd907d5f947aa12 = getArrayKey($vafbad9dc43d3b9eb8533cd54a4df6a87, 'path');
	    $vf7cc8e4882789cf3335d9ed97f208c6f = getArrayKey($vafbad9dc43d3b9eb8533cd54a4df6a87, 'query');
	    if ($vf7cc8e4882789cf3335d9ed97f208c6f)
	    {
		parse_str($vf7cc8e4882789cf3335d9ed97f208c6f, $v5ebb3c9d5620968cde8459888eff1702);
		if (isset($v5ebb3c9d5620968cde8459888eff1702['p']))
		{
		    unset($v5ebb3c9d5620968cde8459888eff1702['p']);
		}if (isset($v5ebb3c9d5620968cde8459888eff1702['xmlMode']))
		{
		    unset($v5ebb3c9d5620968cde8459888eff1702['xmlMode']);
		}$vf7cc8e4882789cf3335d9ed97f208c6f = http_build_query($v5ebb3c9d5620968cde8459888eff1702, '', '&');
		if ($vf7cc8e4882789cf3335d9ed97f208c6f)
		{
		    $vb6ee27ee7fe19b0c0dd907d5f947aa12 .= '?' . $vf7cc8e4882789cf3335d9ed97f208c6f;
		}
	    }$result['@request-uri'] = $vb6ee27ee7fe19b0c0dd907d5f947aa12;
	}$result['@edition'] = CURRENT_VERSION_LINE;
	$result['@disableTooManyChildsNotification'] = (int) mainConfiguration::getInstance()->get('system', 'disable-too-many-childs-notification');
	$va74846e5bcde649f23218b2e062c90a8 = $v41275a535677f79ff347e01bc530c176->isAdmin();
	if (system_is_allowed($this->current_module, $this->current_method))
	{
	    try
	    {
		if ($v22884db148f0ffb0d830ba431102b0b5 = $this->getModule($this->current_module))
		{
		    $v22884db148f0ffb0d830ba431102b0b5->cms_callMethod($this->current_method, NULL);
		}$result['data'] = $this->adminDataSet;
	    } catch (publicException $ve1671797c52e15f763380b45e841ec32)
	    {
		$result['data'] = $ve1671797c52e15f763380b45e841ec32;
	    }
	} elseif ($va74846e5bcde649f23218b2e062c90a8)
	{
	    $result['data'] = new requreMoreAdminPermissionsException(getLabel("error-require-more-permissions"));
	}if (!is_null($ve1d832ee855bdce9643cc79275650e83 = getRequest('domain')))
	{
	    $result['@domain-floated'] = $ve1d832ee855bdce9643cc79275650e83;
	    $result['@domain-floated-id'] = $ve4e46deb7f9cc58c7abfb32e5570b6f3->getDomainId($ve1d832ee855bdce9643cc79275650e83);
	} else
	{
	    if ($this->currentEditElementId)
	    {
		$v8e2dcfd7e7e24b1ca76c1193f645902b = umiHierarchy::getInstance()->getElement($this->currentEditElementId);
		if ($v8e2dcfd7e7e24b1ca76c1193f645902b instanceof umiHierarchyElement)
		{
		    $v72ee76c5c29383b7c9f9225c1fa4d10b = $v8e2dcfd7e7e24b1ca76c1193f645902b->getDomainId();
		    $vad5f82e879a9c5d6b5b442eb37e50551 = $ve4e46deb7f9cc58c7abfb32e5570b6f3->getDomain($v72ee76c5c29383b7c9f9225c1fa4d10b);
		    if ($vad5f82e879a9c5d6b5b442eb37e50551 instanceof iDomain)
		    {
			$result['@domain-floated'] = $va6b64ba4d9e3e0b93a64bb6af8c320cc = $vad5f82e879a9c5d6b5b442eb37e50551->getHost();
		    }
		}
	    } else
	    {
		$result['@domain-floated'] = $result['@domain'];
	    }
	}return $result;
    }

    private function prepareClientSideGlobalVariablesForTPL()
    {
	$v41275a535677f79ff347e01bc530c176 = permissionsCollection::getInstance();
	$v7b975dff6c0134c6f231fd13895c2349 = $this->getCurrentModule();
	$vb6ad8768e9a35023e3d824c5057699d1 = $this->getCurrentMethod();
	$v7552cd149af7495ee7d8225974e50f80 = $this->getCurrentElementId();
	$v8e44f0089b076e18a718eb9ca3d94674 = $v41275a535677f79ff347e01bc530c176->getUserId();
	$v9a0364b9e99bb480dd25e1f0284c8555 = "";
	$va5f3e7671419d689ba41872016aded04 = true;
	if ($v41275a535677f79ff347e01bc530c176->isAllowedMethod($v8e44f0089b076e18a718eb9ca3d94674, $v7b975dff6c0134c6f231fd13895c2349, $vb6ad8768e9a35023e3d824c5057699d1))
	{
	    $va5f3e7671419d689ba41872016aded04 = false;
	    if ($v7552cd149af7495ee7d8225974e50f80)
	    {
		list($v4b43b0aee35624cd95b910189b3dc231) = $v41275a535677f79ff347e01bc530c176->isAllowedObject($v8e44f0089b076e18a718eb9ca3d94674, $v7552cd149af7495ee7d8225974e50f80);
		$va5f3e7671419d689ba41872016aded04 = !$v4b43b0aee35624cd95b910189b3dc231;
	    }
	}if ($va5f3e7671419d689ba41872016aded04)
	{
	    header("Status: 401 Unauthorized");
	    $this->setCurrentModule('users');
	    $this->setCurrentMethod('login');
	    if (!$vf1e554b2b6ec1274154d202f76bf0e74 = $this->getModule('users'))
	    {
		throw new coreException('Module "users" not found.');
	    }$v9a0364b9e99bb480dd25e1f0284c8555 = $vf1e554b2b6ec1274154d202f76bf0e74->login();
	} else
	{
	    $v22884db148f0ffb0d830ba431102b0b5 = $this->getModule($v7b975dff6c0134c6f231fd13895c2349);
	    try
	    {
		$v9a0364b9e99bb480dd25e1f0284c8555 = $v22884db148f0ffb0d830ba431102b0b5->cms_callMethod($vb6ad8768e9a35023e3d824c5057699d1, array());
	    } catch (publicException $ve1671797c52e15f763380b45e841ec32)
	    {
		$v9a0364b9e99bb480dd25e1f0284c8555 = $ve1671797c52e15f763380b45e841ec32->getMessage();
	    }
	}return array('content' => $v9a0364b9e99bb480dd25e1f0284c8555);
    }

    private function prepareClientSideGlobalVariablesForXSLT()
    {
	$v6d9fecd2868e8a635b6d088c3e8068c2 = array();
	$v41275a535677f79ff347e01bc530c176 = permissionsCollection::getInstance();
	$vb1444fb0c07653567ad325aa25d4e37a = regedit::getInstance();
	$v69ae498121c2d8e63f20c7144a0246d7 = umiObjectsCollection::getInstance();
	$vb81ca7c0ccaa77e7aa91936ab0070695 = umiHierarchy::getInstance();
	$v8e44f0089b076e18a718eb9ca3d94674 = $v41275a535677f79ff347e01bc530c176->getUserId();
	$v7552cd149af7495ee7d8225974e50f80 = $this->getCurrentElementId();
	$v7b975dff6c0134c6f231fd13895c2349 = $this->getCurrentModule();
	$vb6ad8768e9a35023e3d824c5057699d1 = $this->getCurrentMethod();
	$va5f3e7671419d689ba41872016aded04 = true;
	if ($v41275a535677f79ff347e01bc530c176->isAllowedMethod($v8e44f0089b076e18a718eb9ca3d94674, $v7b975dff6c0134c6f231fd13895c2349, $vb6ad8768e9a35023e3d824c5057699d1))
	{
	    $va5f3e7671419d689ba41872016aded04 = false;
	    if ($v7552cd149af7495ee7d8225974e50f80)
	    {
		list($v4b43b0aee35624cd95b910189b3dc231) = $v41275a535677f79ff347e01bc530c176->isAllowedObject($v8e44f0089b076e18a718eb9ca3d94674, $v7552cd149af7495ee7d8225974e50f80);
		if (!$v4b43b0aee35624cd95b910189b3dc231)
		{
		    $va5f3e7671419d689ba41872016aded04 = true;
		    $v6d9fecd2868e8a635b6d088c3e8068c2['attribute:not-permitted'] = 1;
		}
	    }
	}if ($va5f3e7671419d689ba41872016aded04)
	{
	    $v7b975dff6c0134c6f231fd13895c2349 = "users";
	    $vb6ad8768e9a35023e3d824c5057699d1 = "login";
	    $this->setCurrentModule($v7b975dff6c0134c6f231fd13895c2349);
	    $this->setCurrentMethod($vb6ad8768e9a35023e3d824c5057699d1);
	}$this->currentHeader = def_module::parseTPLMacroses(macros_header());
	$v6d9fecd2868e8a635b6d088c3e8068c2 += array('@module' => $v7b975dff6c0134c6f231fd13895c2349, '@method' => $vb6ad8768e9a35023e3d824c5057699d1, '@domain' => $this->getCurrentDomain()->getHost(), '@system-build' => $vb1444fb0c07653567ad325aa25d4e37a->getVal("//modules/autoupdate/system_build"), '@lang' => $this->getCurrentLang()->getPrefix(), '@pre-lang' => $this->pre_lang, '@header' => $this->currentHeader, '@title' => def_module::parseTPLMacroses(macros_title()), '@site-name' => def_module::parseTPLMacroses(macros_sitename()), 'meta' => array('keywords' => macros_keywords(), 'description' => macros_describtion()));
	if (defined('CURRENT_VERSION_LINE') and CURRENT_VERSION_LINE == 'demo')
	{
	    $v6d9fecd2868e8a635b6d088c3e8068c2['@demo'] = 1;
	}if (!is_null(getRequest('p')))
	{
	    $v6d9fecd2868e8a635b6d088c3e8068c2['@paging'] = "yes";
	}$v14e478589cc0c27c6e14f2eca7bc7ccd = cmsController::getInstance()->getModule("social_networks");
	if ($v14e478589cc0c27c6e14f2eca7bc7ccd && ($v32a2f74bd1a12b30d1879b4b0ab59d64 = $v14e478589cc0c27c6e14f2eca7bc7ccd->getCurrentSocial()))
	{
	    $v6d9fecd2868e8a635b6d088c3e8068c2['@socialId'] = $v32a2f74bd1a12b30d1879b4b0ab59d64->getId();
	}if ($vb6ee27ee7fe19b0c0dd907d5f947aa12 = getServer('REQUEST_URI'))
	{
	    $vafbad9dc43d3b9eb8533cd54a4df6a87 = @parse_url($vb6ee27ee7fe19b0c0dd907d5f947aa12);
	    $vb6ee27ee7fe19b0c0dd907d5f947aa12 = getArrayKey($vafbad9dc43d3b9eb8533cd54a4df6a87, 'path');
	    $vf7cc8e4882789cf3335d9ed97f208c6f = getArrayKey($vafbad9dc43d3b9eb8533cd54a4df6a87, 'query');
	    if ($v14e478589cc0c27c6e14f2eca7bc7ccd && ($v32a2f74bd1a12b30d1879b4b0ab59d64 = $v14e478589cc0c27c6e14f2eca7bc7ccd->getCurrentSocial()))
	    {
		$vf7cc8e4882789cf3335d9ed97f208c6f = "";
	    }if ($vf7cc8e4882789cf3335d9ed97f208c6f)
	    {
		parse_str($vf7cc8e4882789cf3335d9ed97f208c6f, $v5ebb3c9d5620968cde8459888eff1702);
		if (isset($v5ebb3c9d5620968cde8459888eff1702['p'])) unset($v5ebb3c9d5620968cde8459888eff1702['p']);if (isset($v5ebb3c9d5620968cde8459888eff1702['xmlMode'])) unset($v5ebb3c9d5620968cde8459888eff1702['xmlMode']);$vf7cc8e4882789cf3335d9ed97f208c6f = http_build_query($v5ebb3c9d5620968cde8459888eff1702, '', '&');
		if ($vf7cc8e4882789cf3335d9ed97f208c6f) $vb6ee27ee7fe19b0c0dd907d5f947aa12 .= '?' . $vf7cc8e4882789cf3335d9ed97f208c6f;
	    }$v6d9fecd2868e8a635b6d088c3e8068c2['@request-uri'] = $vb6ee27ee7fe19b0c0dd907d5f947aa12;
	}$v49f290d6e8459c53f31f97de37921086 = array();
	$v8e44f0089b076e18a718eb9ca3d94674 = $this->getModule('users')->user_id;
	$v49f290d6e8459c53f31f97de37921086['@id'] = $v8e44f0089b076e18a718eb9ca3d94674;
	$v3d88fcbaa3581c4957147ef9ad47ec5e = 'guest';
	if ($v41275a535677f79ff347e01bc530c176->isAuth() && ($vee11cbb19052e40b07aac0ca060c23ee = $v69ae498121c2d8e63f20c7144a0246d7->getObject($v8e44f0089b076e18a718eb9ca3d94674)))
	{
	    $v3d88fcbaa3581c4957147ef9ad47ec5e = 'user';
	    $v49f290d6e8459c53f31f97de37921086['@status'] = 'auth';
	    $v49f290d6e8459c53f31f97de37921086['@login'] = $vee11cbb19052e40b07aac0ca060c23ee->login;
	    $v49f290d6e8459c53f31f97de37921086['xlink:href'] = $vee11cbb19052e40b07aac0ca060c23ee->xlink;
	    if ($v41275a535677f79ff347e01bc530c176->isAdmin())
	    {
		$v3d88fcbaa3581c4957147ef9ad47ec5e = 'admin';
		if ($v41275a535677f79ff347e01bc530c176->isSv()) $v3d88fcbaa3581c4957147ef9ad47ec5e = 'sv';
	    }
	}$v49f290d6e8459c53f31f97de37921086['@type'] = $v3d88fcbaa3581c4957147ef9ad47ec5e;
	if ($vabb341de59578cc2eefc8b95d451142b = $this->getModule("geoip"))
	{
	    $vdfc4832c05a0296e4f53eff66626baec = $vabb341de59578cc2eefc8b95d451142b->lookupIp();
	    if (!isset($vdfc4832c05a0296e4f53eff66626baec['special']))
	    {
		$v49f290d6e8459c53f31f97de37921086['geo'] = array('country' => $vdfc4832c05a0296e4f53eff66626baec['country'], 'region' => $vdfc4832c05a0296e4f53eff66626baec['region'], 'city' => $vdfc4832c05a0296e4f53eff66626baec['city'], 'latitude' => $vdfc4832c05a0296e4f53eff66626baec['lat'], 'longitude' => $vdfc4832c05a0296e4f53eff66626baec['lon']);
	    } else
	    {
		$v49f290d6e8459c53f31f97de37921086['geo'] = array('special' => $vdfc4832c05a0296e4f53eff66626baec['special']);
	    }
	}$v6d9fecd2868e8a635b6d088c3e8068c2['user'] = $v49f290d6e8459c53f31f97de37921086;
	if ($v7552cd149af7495ee7d8225974e50f80 && ($v8e2dcfd7e7e24b1ca76c1193f645902b = $vb81ca7c0ccaa77e7aa91936ab0070695->getElement($v7552cd149af7495ee7d8225974e50f80)))
	{
	    $v587a02d1eb09e2b2fd6514d36a7c3438 = $vb81ca7c0ccaa77e7aa91936ab0070695->getAllParents($v7552cd149af7495ee7d8225974e50f80);
	    $v8e13d18cd44dd15da3533bd4db912ab8 = array();
	    foreach ($v587a02d1eb09e2b2fd6514d36a7c3438 as $v72352a4d26581ef082a6d2243c5a6b88)
	    {
		if ($v72352a4d26581ef082a6d2243c5a6b88 == 0)
		{
		    continue;
		}if ($va4f09cfeea7392a1f6df6a3de5c3bc9e = $vb81ca7c0ccaa77e7aa91936ab0070695->getElement($v72352a4d26581ef082a6d2243c5a6b88))
		{
		    $v8e13d18cd44dd15da3533bd4db912ab8[] = $va4f09cfeea7392a1f6df6a3de5c3bc9e;
		}
	    }$v6d9fecd2868e8a635b6d088c3e8068c2 += array('@pageId' => $v7552cd149af7495ee7d8225974e50f80, 'parents' => array('+page' => $v8e13d18cd44dd15da3533bd4db912ab8), 'full:page' => $v8e2dcfd7e7e24b1ca76c1193f645902b);
	    def_module::pushEditable($v7b975dff6c0134c6f231fd13895c2349, $vb6ad8768e9a35023e3d824c5057699d1, $v7552cd149af7495ee7d8225974e50f80);
	} elseif ($v7b975dff6c0134c6f231fd13895c2349 == 'content' && $vb6ad8768e9a35023e3d824c5057699d1 == 'content')
	{
	    $v7f2db423a49b305459147332fb01cf87 = outputBuffer::current();
	    $v7f2db423a49b305459147332fb01cf87->status("404 Not Found");
	    $v6d9fecd2868e8a635b6d088c3e8068c2['@method'] = "notfound";
	} elseif (!$va5f3e7671419d689ba41872016aded04 && $this->isAllowedExecuteMethod($v7b975dff6c0134c6f231fd13895c2349, $vb6ad8768e9a35023e3d824c5057699d1))
	{
	    try
	    {
		$vd6fe1d0be6347b8ef2427fa629c04485 = getRequest('path');
		$v1bbcb648e0b1869444f3a2d344a5b3ac = explode("/", $vd6fe1d0be6347b8ef2427fa629c04485);
		if (count($v1bbcb648e0b1869444f3a2d344a5b3ac) < 2)
		{
		    throw new coreException("Invalid udata path");
		}$v1bbcb648e0b1869444f3a2d344a5b3ac[0] = $v7b975dff6c0134c6f231fd13895c2349;
		$v1bbcb648e0b1869444f3a2d344a5b3ac[1] = $vb6ad8768e9a35023e3d824c5057699d1;
		$vd6fe1d0be6347b8ef2427fa629c04485 = 'udata://' . implode("/", $v1bbcb648e0b1869444f3a2d344a5b3ac);
		$v6d9fecd2868e8a635b6d088c3e8068c2['xml:data'] = $this->executeStream($vd6fe1d0be6347b8ef2427fa629c04485);
	    } catch (publicException $ve1671797c52e15f763380b45e841ec32)
	    {
		$v6d9fecd2868e8a635b6d088c3e8068c2['data'] = $ve1671797c52e15f763380b45e841ec32;
	    }
	}return $v6d9fecd2868e8a635b6d088c3e8068c2;
    }

    public function executeStream($v9305b73d359bd06734fee0b3638079e1)
    {
	if (($v8d777f385d3dfec8815d20f7496026dc = @file_get_contents($v9305b73d359bd06734fee0b3638079e1)) === false)
	{
	    $v9305b73d359bd06734fee0b3638079e1 .= (strpos($v9305b73d359bd06734fee0b3638079e1, "?") === false) ? '?r=' : '&r=';
	    $v9305b73d359bd06734fee0b3638079e1 .= uniqid('');
	    if (($v8d777f385d3dfec8815d20f7496026dc = @file_get_contents($v9305b73d359bd06734fee0b3638079e1)) === false)
	    {
		throw new coreException("Failed to open udata:// stream");
	    }
	}return $v8d777f385d3dfec8815d20f7496026dc;
    }

    private $skipExecuteMethods = array('eshop/compare', 'faq/question', 'faq/project', 'faq/category', 'blogs20/blog', 'blogs20/post', 'blogs20/postEdit', 'catalog/category', 'catalog/getObjectsList', 'catalog/object', 'catalog/viewObject', 'catalog/search', 'content/content', 'content/sitemap', 'dispatches/unsubscribe', 'dispatches/subscribe', 'dispatches/subscribe_do', 'emarket/compare', 'emarket/order', 'emarket/purchase', 'filemanager/shared_file', 'forum/confs_list', 'forum/conf', 'forum/topic', 'forum/topic_last_message', 'forum/conf_last_message', 'news/lastlist', 'news/rubric', 'news/view', 'news/related_links', 'news/item', 'news/listlents', 'news/lastlents', 'photoalbum/album', 'photoalbum/photo', 'search/search_do', 'search/suggestions', 'users/settings', 'users/registrate', 'users/registrate_done', 'users/activate', 'users/auth', 'vote/poll', 'vote/insertvote', 'vote/results', 'webforms/page', 'webforms/posted');

    public function isAllowedExecuteMethod($v22884db148f0ffb0d830ba431102b0b5, $vea9f6aca279138c58f705c8d4cb4b8ce)
    {
	return !in_array($v22884db148f0ffb0d830ba431102b0b5 . '/' . $vea9f6aca279138c58f705c8d4cb4b8ce, $this->skipExecuteMethods);
    }

    private function init()
    {
	$this->detectMode();
	showWorkTime("cmscontroller detect mode");
	$this->detectDomain();
	showWorkTime("cmscontroller detect domain");
	$this->detectLang();
	showWorkTime("cmscontroller detect lang");
	$this->loadLangs();
	showWorkTime("cmscontroller load lang");
	cacheFrontend::$currentlangId = $this->getCurrentLang()->getId();
	cacheFrontend::$currentDomainId = $this->getCurrentDomain()->getId();
	$LANG_EXPORT = array();
	$v2a41f6d927793b754d2d6dcd7485d96f = CURRENT_WORKING_DIR . "/classes/modules/lang.php";
	if (file_exists($v2a41f6d927793b754d2d6dcd7485d96f))
	{
	    require $v2a41f6d927793b754d2d6dcd7485d96f;
	}$this->langs = array_merge($this->langs, $LANG_EXPORT);
	$v1b2c38000ce4861a9ba046bf4dc483a4 = CURRENT_WORKING_DIR . "/classes/modules/lang." . $this->getCurrentLang()->getPrefix() . ".php";
	if (file_exists($v1b2c38000ce4861a9ba046bf4dc483a4))
	{
	    require $v1b2c38000ce4861a9ba046bf4dc483a4;
	    $this->langs = array_merge($this->langs, $LANG_EXPORT);
	}$this->errorUrl = getServer('HTTP_REFERER');
	$this->doSomething();
	$this->calculateRefererUri();
    }

    private function detectDomain()
    {
	$ve4e46deb7f9cc58c7abfb32e5570b6f3 = domainsCollection::getInstance();
	$v67b3dba8bc6778101892eb77249db32e = getServer('HTTP_HOST');
	$vfbe322a89bc0ba531c3f0050e3935f28 = false;
	if ($v662cbf1253ac7d8750ed9190c52163e5 = $ve4e46deb7f9cc58c7abfb32e5570b6f3->getDomainId($v67b3dba8bc6778101892eb77249db32e))
	{
	    $vad5f82e879a9c5d6b5b442eb37e50551 = $ve4e46deb7f9cc58c7abfb32e5570b6f3->getDomain($v662cbf1253ac7d8750ed9190c52163e5);
	    $vfbe322a89bc0ba531c3f0050e3935f28 = true;
	} else
	{
	    $vad5f82e879a9c5d6b5b442eb37e50551 = $ve4e46deb7f9cc58c7abfb32e5570b6f3->getDefaultDomain();
	    if (!$vad5f82e879a9c5d6b5b442eb37e50551 instanceof domain) throw new coreException("Default domain could not be found");
	}if ($v67b3dba8bc6778101892eb77249db32e != $vad5f82e879a9c5d6b5b442eb37e50551->getHost())
	{
	    $v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();
	    $vcd189c6b00df4debfabc5a0d23f7d8e4 = $v2245023265ae4cf87d02c8b6ba991139->get('seo', 'primary-domain-redirect');
	    if ($vcd189c6b00df4debfabc5a0d23f7d8e4 == 1)
	    {
		$v9305b73d359bd06734fee0b3638079e1 = 'http://' . $vad5f82e879a9c5d6b5b442eb37e50551->getHost() . getServer('REQUEST_URI');
		$v7f2db423a49b305459147332fb01cf87 = outputBuffer::current();
		$v7f2db423a49b305459147332fb01cf87->header('Location', $v9305b73d359bd06734fee0b3638079e1);
		$v7f2db423a49b305459147332fb01cf87->clear();
		$v7f2db423a49b305459147332fb01cf87->end();
	    } elseif ($vcd189c6b00df4debfabc5a0d23f7d8e4 == 2 && !$vfbe322a89bc0ba531c3f0050e3935f28)
	    {
		$v7f2db423a49b305459147332fb01cf87 = outputBuffer::current();
		$v7f2db423a49b305459147332fb01cf87->status('404 Not Found');
		$v7f2db423a49b305459147332fb01cf87->option('generation-time', false);
		ob_start();
		require CURRENT_WORKING_DIR . "/errors/invalid_domain.html";
		$v9a0364b9e99bb480dd25e1f0284c8555 = ob_get_clean();
		$v7f2db423a49b305459147332fb01cf87->push($v9a0364b9e99bb480dd25e1f0284c8555);
		$v7f2db423a49b305459147332fb01cf87->end();
	    }
	}if (is_object($vad5f82e879a9c5d6b5b442eb37e50551))
	{
	    $this->current_domain = $vad5f82e879a9c5d6b5b442eb37e50551;
	    return true;
	} else
	{
	    $vad5f82e879a9c5d6b5b442eb37e50551 = $ve4e46deb7f9cc58c7abfb32e5570b6f3->getDefaultDomain();
	    if ($vad5f82e879a9c5d6b5b442eb37e50551 instanceof domain)
	    {
		$this->current_domain = $vad5f82e879a9c5d6b5b442eb37e50551;
		$vad5f82e879a9c5d6b5b442eb37e50551->addMirrow($v67b3dba8bc6778101892eb77249db32e);
		return false;
	    } else
	    {
		throw new coreException("Current domain could not be found");
	    }
	}
    }

    private function detectLang()
    {
	$vb24bcd6b7d395b852353e079beaec4f9 = getRequest('lang_id');
	$v78e6dd7a49f5b0cb2106a3a434dd5c86 = false;
	if ($vb24bcd6b7d395b852353e079beaec4f9 != null)
	{
	    if (is_array($vb24bcd6b7d395b852353e079beaec4f9))
	    {
		list($vb24bcd6b7d395b852353e079beaec4f9) = $vb24bcd6b7d395b852353e079beaec4f9;
	    }$v78e6dd7a49f5b0cb2106a3a434dd5c86 = intval($vb24bcd6b7d395b852353e079beaec4f9);
	} else if (!is_null(getRequest('links')) && is_array($v7ffc4d510260a8544e5550e62ec56bc1 = getRequest('rel')))
	{
	    if (sizeof($v7ffc4d510260a8544e5550e62ec56bc1) && ($v7552cd149af7495ee7d8225974e50f80 = array_pop($v7ffc4d510260a8544e5550e62ec56bc1)))
	    {
		$v8e2dcfd7e7e24b1ca76c1193f645902b = umiHierarchy::getInstance()->getElement($v7552cd149af7495ee7d8225974e50f80, true);
		if ($v8e2dcfd7e7e24b1ca76c1193f645902b instanceof umiHierarchyElement)
		{
		    $v78e6dd7a49f5b0cb2106a3a434dd5c86 = $v8e2dcfd7e7e24b1ca76c1193f645902b->getLangId();
		}
	    }
	} else
	{
	    list($vb31590b98760b74e7c4e1a809e43152d) = $this->getPathArray();
	    $v78e6dd7a49f5b0cb2106a3a434dd5c86 = langsCollection::getInstance()->getLangId($vb31590b98760b74e7c4e1a809e43152d);
	}if (!langsCollection::getInstance()->getDefaultLang())
	{
	    throw new coreException('Cannot find default language');
	}if (($this->current_lang = langsCollection::getInstance()->getLang($v78e6dd7a49f5b0cb2106a3a434dd5c86)) === false)
	{
	    if ($this->current_domain)
	    {
		if ($v78e6dd7a49f5b0cb2106a3a434dd5c86 = $this->current_domain->getDefaultLangId())
		{
		    $this->current_lang = langsCollection::getInstance()->getLang($v78e6dd7a49f5b0cb2106a3a434dd5c86);
		} else
		{
		    $this->current_lang = langsCollection::getInstance()->getDefaultLang();
		}
	    } else
	    {
		$this->current_lang = langsCollection::getInstance()->getDefaultLang();
	    }
	}if ($this->current_lang->getId() != $this->current_domain->getDefaultLangId())
	{
	    $this->pre_lang = "/" . $this->current_lang->getPrefix();
	    $_REQUEST['pre_lang'] = $this->pre_lang;
	}
    }

    public function detectCurrentDesignTemplate()
    {
	static $vb048e7dfca99df0ea367940c9e517f95 = null;
	if ($vb048e7dfca99df0ea367940c9e517f95 instanceof template)
	{
	    return $vb048e7dfca99df0ea367940c9e517f95;
	}$vfed36e93a0509e20f2dc96cbbd85b678 = templatesCollection::getInstance();
	$v66f6181bcb4cff4cd38fbc804a036db6 = null;
	if ($v3200a31fc05da4e9d5a0465c36822e2f = getRequest('template_id'))
	{
	    $v66f6181bcb4cff4cd38fbc804a036db6 = $vfed36e93a0509e20f2dc96cbbd85b678->getTemplate((int) $v3200a31fc05da4e9d5a0465c36822e2f);
	}if (!$v66f6181bcb4cff4cd38fbc804a036db6 instanceof template)
	{
	    $v66f6181bcb4cff4cd38fbc804a036db6 = $vfed36e93a0509e20f2dc96cbbd85b678->getCurrentTemplate();
	}return $v66f6181bcb4cff4cd38fbc804a036db6;
    }

    private function detectCurrentTemplater()
    {
	if (defined('VIA_HTTP_SCHEME') && VIA_HTTP_SCHEME)
	{
	    return $this->current_templater = $this->initHTTPSchemeModeTemplater();
	} elseif ($this->current_mode == 'admin')
	{
	    return $this->current_templater = $this->initAdminModeTemplater();
	} else
	{
	    return $this->current_templater = $this->initSiteModeTemplater();
	}
    }

    private function initHTTPSchemeModeTemplater()
    {
	outputBuffer::contentGenerator('XSLT, HTTP SCHEME MODE');
	return umiTemplater::create('XSLT');
    }

    private function initSiteModeTemplater()
    {
	$v66f6181bcb4cff4cd38fbc804a036db6 = $this->detectCurrentDesignTemplate();
	if (!$v66f6181bcb4cff4cd38fbc804a036db6 instanceof template)
	{
	    $v7f2db423a49b305459147332fb01cf87 = outputBuffer::current();
	    $v7f2db423a49b305459147332fb01cf87->clear();
	    $v7f2db423a49b305459147332fb01cf87->push(file_get_contents(SYS_ERRORS_PATH . 'no_design_template.html'));
	    $v7f2db423a49b305459147332fb01cf87->end();
	}$va488c14d97fc1b1a156f093b14cbc607 = $v66f6181bcb4cff4cd38fbc804a036db6->getType();
	if ($va488c14d97fc1b1a156f093b14cbc607 == 'xsl') $va488c14d97fc1b1a156f093b14cbc607 = 'XSLT';if ($va488c14d97fc1b1a156f093b14cbc607 == 'tpls') $va488c14d97fc1b1a156f093b14cbc607 = 'TPL';$va488c14d97fc1b1a156f093b14cbc607 = strtoupper($va488c14d97fc1b1a156f093b14cbc607);
	outputBuffer::contentGenerator($va488c14d97fc1b1a156f093b14cbc607 . ', SITE MODE');
	return umiTemplater::create($va488c14d97fc1b1a156f093b14cbc607, $v66f6181bcb4cff4cd38fbc804a036db6->getFilePath());
    }

    private function initAdminModeTemplater()
    {
	$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();
	$vd0445781d0ea0874702f04eb72c588d5 = $v2245023265ae4cf87d02c8b6ba991139->includeParam('templates.skins', array('skin' => system_get_skinName()));
	$v41275a535677f79ff347e01bc530c176 = permissionsCollection::getInstance();
	$v8e44f0089b076e18a718eb9ca3d94674 = $v41275a535677f79ff347e01bc530c176->getUserId();
	$vca02d1555c813b1b1ad637654c0fe111 = $v41275a535677f79ff347e01bc530c176->isAllowedMethod($v8e44f0089b076e18a718eb9ca3d94674, $this->current_module, $this->current_method);
	$v5b063e275d506f65ebf1b02d926f19a4 = 'main.xsl';
	if (!$v41275a535677f79ff347e01bc530c176->isAdmin(false, true) || !$vca02d1555c813b1b1ad637654c0fe111)
	{
	    if ($v41275a535677f79ff347e01bc530c176->isAuth())
	    {
		$v90f805bfcba6ab75df4ad6da8e6afd9b = "owner_id = {$v8e44f0089b076e18a718eb9ca3d94674}";
		$v8e59688c095c0b0bad04d8476df25db3 = umiObjectsCollection::getInstance()->getObject($v8e44f0089b076e18a718eb9ca3d94674)->getValue('groups');
		foreach ($v8e59688c095c0b0bad04d8476df25db3 as $vf2f5fbe4a9d4cc9a39e7a62a513580e9)
		{
		    $v90f805bfcba6ab75df4ad6da8e6afd9b .= " or owner_id = {$vf2f5fbe4a9d4cc9a39e7a62a513580e9}";
		}$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT `module` FROM cms_permissions WHERE (" . $v90f805bfcba6ab75df4ad6da8e6afd9b . ") and (method = '' or method is null)";
		$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);
		if (mysql_num_rows($result) !== 0)
		{
		    $vb1444fb0c07653567ad325aa25d4e37a = regedit::getInstance();
		    while ($vf1965a857bc285d26fe22023aa5ab50d = mysql_fetch_array($result))
		    {
			$v22884db148f0ffb0d830ba431102b0b5 = $vf1965a857bc285d26fe22023aa5ab50d[0];
			$vea9f6aca279138c58f705c8d4cb4b8ce = $vb1444fb0c07653567ad325aa25d4e37a->getVal("//modules/{$v22884db148f0ffb0d830ba431102b0b5}/default_method_admin");
			if ($v41275a535677f79ff347e01bc530c176->isAllowedMethod($v8e44f0089b076e18a718eb9ca3d94674, $v22884db148f0ffb0d830ba431102b0b5, $vea9f6aca279138c58f705c8d4cb4b8ce))
			{
			    def_module::redirect('http://' . $this->getCurrentDomain()->getHost() . '/admin/' . $v22884db148f0ffb0d830ba431102b0b5 . '/' . $vea9f6aca279138c58f705c8d4cb4b8ce . "/");
			    break;
			}
		    }
		}
	    }$v5b063e275d506f65ebf1b02d926f19a4 = 'main_login.xsl';
	}$vfbf236c2ed0d94c877048bc5bb1db3d9 = $vd0445781d0ea0874702f04eb72c588d5 . $v5b063e275d506f65ebf1b02d926f19a4;
	if (!is_file($vfbf236c2ed0d94c877048bc5bb1db3d9))
	{
	    throw new coreException('Template "' . $vfbf236c2ed0d94c877048bc5bb1db3d9 . '" not found.');
	}outputBuffer::contentGenerator('XSLT, ADMIN MODE');
	return umiTemplater::create('XSLT', $vfbf236c2ed0d94c877048bc5bb1db3d9);
    }

    private function getPathArray()
    {
	$vd6fe1d0be6347b8ef2427fa629c04485 = getRequest('path');
	$vd6fe1d0be6347b8ef2427fa629c04485 = trim($vd6fe1d0be6347b8ef2427fa629c04485, "/");
	$v5f44c555cfb3ecb28f624fa95617f277 = mainConfiguration::getInstance()->get('seo', 'url-suffix');
	$v5e0bdcbddccca4d66d74ba8c1cee1a68 = strrpos($vd6fe1d0be6347b8ef2427fa629c04485, $v5f44c555cfb3ecb28f624fa95617f277);
	if ($v5e0bdcbddccca4d66d74ba8c1cee1a68 && ($v5e0bdcbddccca4d66d74ba8c1cee1a68 + strlen($v5f44c555cfb3ecb28f624fa95617f277) == strlen($vd6fe1d0be6347b8ef2427fa629c04485)))
	{
	    $vd6fe1d0be6347b8ef2427fa629c04485 = substr($vd6fe1d0be6347b8ef2427fa629c04485, 0, $v5e0bdcbddccca4d66d74ba8c1cee1a68);
	}return explode("/", $vd6fe1d0be6347b8ef2427fa629c04485);
    }

    private function detectMode()
    {
	if (isset($_SERVER['argv']) && 1 <= count($_SERVER['argv']) && !(isset($_SERVER['QUERY_STRING']) && $_SERVER['argv'][0] == $_SERVER['QUERY_STRING']))
	{
	    $this->current_mode = "cli";
	    cacheFrontend::$cacheMode = true;
	    return;
	}$v32660e7b27600e0fde6ff1333c6c0568 = $this->getPathArray();
	if (sizeof($v32660e7b27600e0fde6ff1333c6c0568) < 2)
	{
	    $v32660e7b27600e0fde6ff1333c6c0568[1] = NULL;
	}list($v9ea3ab74bc8133d47b81a107f1a1c585, $v394072637b008e3829968bb5109f17ac) = $v32660e7b27600e0fde6ff1333c6c0568;
	if ($v9ea3ab74bc8133d47b81a107f1a1c585 == "admin" || $v394072637b008e3829968bb5109f17ac == "admin")
	{
	    $this->current_mode = "admin";
	    cacheFrontend::$adminMode = true;
	} else
	{
	    $this->current_mode = "";
	    cacheFrontend::$cacheMode = true;
	    cacheFrontend::$adminMode = false;
	}
    }

    private function getSubPathType($vb31590b98760b74e7c4e1a809e43152d)
    {
	$vb1444fb0c07653567ad325aa25d4e37a = regedit::getInstance();
	if (!$this->current_module)
	{
	    if ($vb31590b98760b74e7c4e1a809e43152d == "trash")
	    {
		def_module::redirect($this->pre_lang . "/admin/data/trash/");
	    }if ($vb1444fb0c07653567ad325aa25d4e37a->getVal("//modules/" . $vb31590b98760b74e7c4e1a809e43152d))
	    {
		$this->setCurrentModule($vb31590b98760b74e7c4e1a809e43152d);
		return "MODULE";
	    }
	}if ($this->current_module && !$this->current_method)
	{
	    $this->setCurrentMethod($vb31590b98760b74e7c4e1a809e43152d);
	    return "METHOD";
	}if ($this->current_module && $this->current_method)
	{
	    return "PARAM";
	}return "UNKNOWN";
    }

    private function reset()
    {
	$this->current_module = $this->current_method = '';
	for ($v865c0c0b4ab0e063e5caa3387c1a8741 = 0; $v865c0c0b4ab0e063e5caa3387c1a8741 < 10; $v865c0c0b4ab0e063e5caa3387c1a8741++)
	{
	    if (isset($_REQUEST['param' . $v865c0c0b4ab0e063e5caa3387c1a8741]))
	    {
		unset($_REQUEST['param' . $v865c0c0b4ab0e063e5caa3387c1a8741]);
	    }else break;
	}
    }

    public function analyzePath($v86266ee937d97f812a8e57d22b62ee29 = false)
    {
	showWorkTime("analyzePath started");
	$vd6fe1d0be6347b8ef2427fa629c04485 = getRequest('path');
	$vd6fe1d0be6347b8ef2427fa629c04485 = trim($vd6fe1d0be6347b8ef2427fa629c04485, "/");
	if (!is_null(getRequest('scheme')))
	{
	    if (preg_replace("/[^\w]/im", "", getRequest('scheme')) == 'upage')
	    {
		preg_match_all("/[\d]+/", $vd6fe1d0be6347b8ef2427fa629c04485, $v7057e8409c7c531a1a6e9ac3df4ed549);
		$this->current_element_id = $v7057e8409c7c531a1a6e9ac3df4ed549[0][0];
	    }return;
	}showWorkTime("analyzePath something");
	$vb1444fb0c07653567ad325aa25d4e37a = regedit::getInstance();
	showWorkTime("analyzePath regedit init");
	$vb81ca7c0ccaa77e7aa91936ab0070695 = umiHierarchy::getInstance();
	showWorkTime("analyzePath umiHierarchy init");
	$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();
	showWorkTime("analyzePath mainConfiguration init");
	$v7f2db423a49b305459147332fb01cf87 = outputBuffer::current();
	showWorkTime("analyzePath outputBuffer init");
	if ($v86266ee937d97f812a8e57d22b62ee29 === true)
	{
	    $this->reset();
	}$v5f44c555cfb3ecb28f624fa95617f277 = $v2245023265ae4cf87d02c8b6ba991139->get('seo', 'url-suffix');
	$v5e0bdcbddccca4d66d74ba8c1cee1a68 = strrpos($vd6fe1d0be6347b8ef2427fa629c04485, $v5f44c555cfb3ecb28f624fa95617f277);
	if ($v5e0bdcbddccca4d66d74ba8c1cee1a68 && ($v5e0bdcbddccca4d66d74ba8c1cee1a68 + strlen($v5f44c555cfb3ecb28f624fa95617f277) == strlen($vd6fe1d0be6347b8ef2427fa629c04485)))
	{
	    $vd6fe1d0be6347b8ef2427fa629c04485 = substr($vd6fe1d0be6347b8ef2427fa629c04485, 0, $v5e0bdcbddccca4d66d74ba8c1cee1a68);
	}if ($v2245023265ae4cf87d02c8b6ba991139->get('seo', 'url-suffix.add'))
	{
	    def_module::requireSlashEnding();
	}if ($v2245023265ae4cf87d02c8b6ba991139->get('seo', 'watch-redirects-history'))
	{
	    redirects::getInstance()->init();
	}$v32660e7b27600e0fde6ff1333c6c0568 = $this->getPathArray();
	$v7dabf5c198b0bab2eaa42bb03a113e55 = sizeof($v32660e7b27600e0fde6ff1333c6c0568);
	$vaddb1838ab68ee501d3a0e2868a127c9 = Array();
	$v83878c91171338902e0fe0fb97a8c47a = 0;
	for ($v865c0c0b4ab0e063e5caa3387c1a8741 = 0; $v865c0c0b4ab0e063e5caa3387c1a8741 < $v7dabf5c198b0bab2eaa42bb03a113e55; $v865c0c0b4ab0e063e5caa3387c1a8741++)
	{
	    $vb31590b98760b74e7c4e1a809e43152d = $v32660e7b27600e0fde6ff1333c6c0568[$v865c0c0b4ab0e063e5caa3387c1a8741];
	    if ($v865c0c0b4ab0e063e5caa3387c1a8741 <= 1)
	    {
		if (($vb31590b98760b74e7c4e1a809e43152d == $this->current_mode) || ($vb31590b98760b74e7c4e1a809e43152d == $this->current_lang->getPrefix()))
		{
		    continue;
		}
	    }$vaddb1838ab68ee501d3a0e2868a127c9[] = $vb31590b98760b74e7c4e1a809e43152d;
	    $vbdcb4bec1c234b49e0a70911cf33ff6f = $this->getSubPathType($vb31590b98760b74e7c4e1a809e43152d);
	    if ($vbdcb4bec1c234b49e0a70911cf33ff6f == "PARAM")
	    {
		$_REQUEST['param' . $v83878c91171338902e0fe0fb97a8c47a++] = $vb31590b98760b74e7c4e1a809e43152d;
	    }
	}if (!$this->current_module)
	{
	    if ($this->current_mode == "admin")
	    {
		if ($v854203cccade0bbe21be239a208aea49 = $vb1444fb0c07653567ad325aa25d4e37a->getVal("//modules/events"))
		{
		    
		} else
		{
		    $v854203cccade0bbe21be239a208aea49 = $vb1444fb0c07653567ad325aa25d4e37a->getVal("//settings/default_module_admin");
		}$this->autoRedirectToMethod($v854203cccade0bbe21be239a208aea49);
	    } else
	    {
		$v854203cccade0bbe21be239a208aea49 = $vb1444fb0c07653567ad325aa25d4e37a->getVal("//settings/default_module");
	    }$this->setCurrentModule($v854203cccade0bbe21be239a208aea49);
	}if (!$this->current_method)
	{
	    if ($this->current_mode == "admin")
	    {
		return $this->autoRedirectToMethod($this->current_module);
	    } else
	    {
		$v2fa70149e2a7e75da2b0303d0a36a944 = $vb1444fb0c07653567ad325aa25d4e37a->getVal("//modules/" . $this->current_module . "/default_method");
	    }$this->setCurrentMethod($v2fa70149e2a7e75da2b0303d0a36a944);
	}if ($this->getCurrentMode() == "admin")
	{
	    return;
	}$v7057e8409c7c531a1a6e9ac3df4ed549 = false;
	$v7dabf5c198b0bab2eaa42bb03a113e55 = sizeof($vaddb1838ab68ee501d3a0e2868a127c9);
	$vb31590b98760b74e7c4e1a809e43152d = "";
	for ($v865c0c0b4ab0e063e5caa3387c1a8741 = 0; $v865c0c0b4ab0e063e5caa3387c1a8741 < $v7dabf5c198b0bab2eaa42bb03a113e55; $v865c0c0b4ab0e063e5caa3387c1a8741++)
	{
	    $vb31590b98760b74e7c4e1a809e43152d .= "/" . $vaddb1838ab68ee501d3a0e2868a127c9[$v865c0c0b4ab0e063e5caa3387c1a8741];
	    if (!($vfa816edb83e95bf0c8da580bdfd491ef = $vb81ca7c0ccaa77e7aa91936ab0070695->getIdByPath($vb31590b98760b74e7c4e1a809e43152d, false, $v3dbd53d892aaea70c9f5fefc18fc7e4c)))
	    {
		$v7057e8409c7c531a1a6e9ac3df4ed549 = false;
		break;
	    } else
	    {
		$v7057e8409c7c531a1a6e9ac3df4ed549 = $vfa816edb83e95bf0c8da580bdfd491ef;
	    }
	}if ($v7057e8409c7c531a1a6e9ac3df4ed549)
	{
	    if ($v3dbd53d892aaea70c9f5fefc18fc7e4c > 0 && !defined("DISABLE_AUTOCORRECTION_REDIRECT"))
	    {
		$vd6fe1d0be6347b8ef2427fa629c04485 = $vb81ca7c0ccaa77e7aa91936ab0070695->getPathById($v7057e8409c7c531a1a6e9ac3df4ed549);
		if ($v865c0c0b4ab0e063e5caa3387c1a8741 == 0)
		{
		    if ($this->isModule($vaddb1838ab68ee501d3a0e2868a127c9[0]))
		    {
			$v7057e8409c7c531a1a6e9ac3df4ed549 = false;
			break;
		    }
		}$v7f2db423a49b305459147332fb01cf87->status('301 Moved Permanently');
		$v7f2db423a49b305459147332fb01cf87->redirect($vd6fe1d0be6347b8ef2427fa629c04485);
	    }$v8e2dcfd7e7e24b1ca76c1193f645902b = $vb81ca7c0ccaa77e7aa91936ab0070695->getElement($v7057e8409c7c531a1a6e9ac3df4ed549);
	    if ($v8e2dcfd7e7e24b1ca76c1193f645902b instanceof umiHierarchyElement)
	    {
		if ($v8e2dcfd7e7e24b1ca76c1193f645902b->getIsDefault())
		{
		    $vd6fe1d0be6347b8ef2427fa629c04485 = $vb81ca7c0ccaa77e7aa91936ab0070695->getPathById($v7057e8409c7c531a1a6e9ac3df4ed549);
		    $v7f2db423a49b305459147332fb01cf87->status('301 Moved Permanently');
		    $v7f2db423a49b305459147332fb01cf87->redirect($vd6fe1d0be6347b8ef2427fa629c04485);
		}
	    }
	} elseif (isset($vaddb1838ab68ee501d3a0e2868a127c9[0]))
	{
	    if ($this->isModule($vaddb1838ab68ee501d3a0e2868a127c9[0]))
	    {
		$v22884db148f0ffb0d830ba431102b0b5 = $this->getModule($vaddb1838ab68ee501d3a0e2868a127c9[0]);
		if (isset($vaddb1838ab68ee501d3a0e2868a127c9[1]) && !$v22884db148f0ffb0d830ba431102b0b5->isMethodExists($vaddb1838ab68ee501d3a0e2868a127c9[1]))
		{
		    $this->setCurrentModule('content');
		    $this->setCurrentMethod('content');
		}
	    } else
	    {
		$this->setCurrentModule('content');
		$this->setCurrentMethod('content');
	    }
	}if (($vd6fe1d0be6347b8ef2427fa629c04485 == "" || $vd6fe1d0be6347b8ef2427fa629c04485 == $this->current_lang->getPrefix() ) && $this->current_mode != "admin")
	{
	    if ($v7057e8409c7c531a1a6e9ac3df4ed549 = $vb81ca7c0ccaa77e7aa91936ab0070695->getDefaultElementId($this->getCurrentLang()->getId(), $this->getCurrentDomain()->getId()))
	    {
		$this->current_element_id = $v7057e8409c7c531a1a6e9ac3df4ed549;
	    }
	}if ($v8e2dcfd7e7e24b1ca76c1193f645902b = $vb81ca7c0ccaa77e7aa91936ab0070695->getElement($v7057e8409c7c531a1a6e9ac3df4ed549, true))
	{
	    $v599dcce2998a6b40b1e38e8c6006cb0a = umiHierarchyTypesCollection::getInstance()->getType($v8e2dcfd7e7e24b1ca76c1193f645902b->getTypeId());
	    if (!$v599dcce2998a6b40b1e38e8c6006cb0a)
	    {
		return false;
	    }$this->current_module = $v599dcce2998a6b40b1e38e8c6006cb0a->getName();
	    if ($vabf77184f55403d75b9d51d79162a7ca = $v599dcce2998a6b40b1e38e8c6006cb0a->getExt())
	    {
		$this->setCurrentMethod($vabf77184f55403d75b9d51d79162a7ca);
	    } else
	    {
		$this->setCurrentMethod("content");
	    }$this->current_element_id = $v7057e8409c7c531a1a6e9ac3df4ed549;
	}if ($this->current_module == "content" && $this->current_method == "content" && !$v7057e8409c7c531a1a6e9ac3df4ed549)
	{
	    redirects::getInstance()->redirectIfRequired($vd6fe1d0be6347b8ef2427fa629c04485);
	}
    }

    public function setCurrentModule($v854203cccade0bbe21be239a208aea49)
    {
	$this->current_module = $v854203cccade0bbe21be239a208aea49;
    }

    public function setCurrentMode($v15d61712450a686a7f365adf4fef581f)
    {
	$this->current_mode = $v15d61712450a686a7f365adf4fef581f;
    }

    public function setAdminDataSet($v181746b262df9e42f6016b8637fc8c52)
    {
	$this->adminDataSet = $v181746b262df9e42f6016b8637fc8c52;
    }

    public function setCurrentMethod($v2fa70149e2a7e75da2b0303d0a36a944)
    {
	$v2f3a4fccca6406e35bcf33e92dd93135 = array("__construct", "__destruct", "__call", "__callStatic", "__get", "__set", "__isset", "__unset", "__sleep", "__wakeup", "__toString", "__invoke", "__set_state", "__clone");
	if (in_array($v2fa70149e2a7e75da2b0303d0a36a944, $v2f3a4fccca6406e35bcf33e92dd93135))
	{
	    $this->current_module = "content";
	    $this->current_method = "notfound";
	    return false;
	}$this->current_method = $v2fa70149e2a7e75da2b0303d0a36a944;
    }

    public function loadLangs()
    {
	showWorkTime("loadLangs started");
	$v0eb9b3af2e4a00837a1b1a854c9ea18c = regedit::getInstance()->getList("//modules");
	showWorkTime("loadLangs getList");
	foreach ($v0eb9b3af2e4a00837a1b1a854c9ea18c as $v22884db148f0ffb0d830ba431102b0b5)
	{
	    $v854203cccade0bbe21be239a208aea49 = $v22884db148f0ffb0d830ba431102b0b5[0];
	    $v9a4a6f6ee974a928a90c9152a674b141 = CURRENT_WORKING_DIR . '/classes/modules/' . $v854203cccade0bbe21be239a208aea49 . '/';
	    $v9a4a6f6ee974a928a90c9152a674b141 .= "lang.php";
	    if (file_exists($v9a4a6f6ee974a928a90c9152a674b141))
	    {
		require $v9a4a6f6ee974a928a90c9152a674b141;
	    }if (isset($C_LANG))
	    {
		if (is_array($C_LANG))
		{
		    $this->langs[$v854203cccade0bbe21be239a208aea49] = $C_LANG;
		    unset($C_LANG);
		}
	    }if (isset($LANG_EXPORT))
	    {
		if (is_array($LANG_EXPORT))
		{
		    $this->langs = array_merge($this->langs, $LANG_EXPORT);
		    unset($LANG_EXPORT);
		}
	    }$v9a4a6f6ee974a928a90c9152a674b141 = CURRENT_WORKING_DIR . '/classes/modules/' . $v854203cccade0bbe21be239a208aea49 . '/';
	    $v9a4a6f6ee974a928a90c9152a674b141 .= "lang." . $this->getCurrentLang()->getPrefix() . ".php";
	    if (file_exists($v9a4a6f6ee974a928a90c9152a674b141))
	    {
		require $v9a4a6f6ee974a928a90c9152a674b141;
		if (isset($C_LANG) && is_array($C_LANG))
		{
		    $this->langs[$v854203cccade0bbe21be239a208aea49] = $C_LANG;
		    unset($C_LANG);
		}if (isset($LANG_EXPORT) && is_array($LANG_EXPORT))
		{
		    $this->langs = array_merge($this->langs, $LANG_EXPORT);
		    unset($LANG_EXPORT);
		}
	    }showWorkTime("loadLangs " . $v854203cccade0bbe21be239a208aea49 . " loaded", 1);
	}$vdcb02837c3430cb5b0b73a05d1d40c8e = CURRENT_WORKING_DIR . "/classes/modules/lang." . $this->getLang()->getPrefix() . ".php";
	if (!file_exists($vdcb02837c3430cb5b0b73a05d1d40c8e))
	{
	    $vdcb02837c3430cb5b0b73a05d1d40c8e = CURRENT_WORKING_DIR . "/classes/modules/lang.php";
	}include_once $vdcb02837c3430cb5b0b73a05d1d40c8e;
	if (isset($LANG_EXPORT))
	{
	    $this->langs = array_merge($this->langs, $LANG_EXPORT);
	    unset($LANG_EXPORT);
	}
    }

    public function getModulesList()
    {
	$vb1444fb0c07653567ad325aa25d4e37a = regedit::getInstance();
	$v10ae9fc7d453b0dd525d0edf2ede7961 = $vb1444fb0c07653567ad325aa25d4e37a->getList('//modules');
	$result = array();
	foreach ($v10ae9fc7d453b0dd525d0edf2ede7961 as $v47c80780ab608cc046f2a6e6f071feb6)
	{
	    $result[] = getArrayKey($v47c80780ab608cc046f2a6e6f071feb6, 0);
	}return $result;
    }

    final private function doSomething()
    {
	if (defined("CRON") && (constant('CRON') == 'CLI'))
	{
	    return true;
	}if (defined("CURRENT_VERSION_LINE") && CURRENT_VERSION_LINE != "demo")
	{
	    return true;
	    require CURRENT_WORKING_DIR . "/errors/invalid_license.html";
	    exit();
	}if (!is_writable(SYS_CACHE_RUNTIME) || (file_exists(SYS_CACHE_RUNTIME . 'registry') && !is_writable(SYS_CACHE_RUNTIME . 'registry')))
	{
	    return true;
	    require CURRENT_WORKING_DIR . "/errors/invalid_permissions.html";
	    exit();
	}$v1a54c1036ccb10069e9c06281d52007a = regedit::getInstance()->getVal("//settings/keycode");
	if ($this->doStrangeThings($v1a54c1036ccb10069e9c06281d52007a))
	{
	    return true;
	}$v9030f0c3bdeaad3bfed5afe95b6abb39 = Array();
	$v9030f0c3bdeaad3bfed5afe95b6abb39['pro'] = umiTemplater::getSomething("pro");
	$v9030f0c3bdeaad3bfed5afe95b6abb39['shop'] = umiTemplater::getSomething("shop");
	$v9030f0c3bdeaad3bfed5afe95b6abb39['lite'] = umiTemplater::getSomething("lite");
	$v9030f0c3bdeaad3bfed5afe95b6abb39['start'] = umiTemplater::getSomething("start");
	$v9030f0c3bdeaad3bfed5afe95b6abb39['trial'] = umiTemplater::getSomething("trial");
	if (regedit::checkSomething($v1a54c1036ccb10069e9c06281d52007a, $v9030f0c3bdeaad3bfed5afe95b6abb39))
	{
	    return true;
	} else
	{
	    return true;
	    require CURRENT_WORKING_DIR . "/errors/invalid_license.html";
	    exit();
	}
    }

    final private function doStrangeThings($v1a54c1036ccb10069e9c06281d52007a)
    {
	$v02af0c970ae1d359ec007b3e1d3c064d = SYS_CACHE_RUNTIME . 'trash';
	$v5321626b774a579656cf063f8d8ac056 = false;
	$vcd91e7679d575a2c548bd2c889c23b9e = 604800;
	if (file_exists($v02af0c970ae1d359ec007b3e1d3c064d))
	{
	    if ((time() - filemtime($v02af0c970ae1d359ec007b3e1d3c064d)) > $vcd91e7679d575a2c548bd2c889c23b9e)
	    {
		$v5321626b774a579656cf063f8d8ac056 = base64_decode(file_get_contents($v02af0c970ae1d359ec007b3e1d3c064d));
	    }
	} else
	{
	    file_put_contents($v02af0c970ae1d359ec007b3e1d3c064d, base64_encode($v1a54c1036ccb10069e9c06281d52007a));
	}if ($v5321626b774a579656cf063f8d8ac056 !== false && $v1a54c1036ccb10069e9c06281d52007a)
	{
	    if ($v1a54c1036ccb10069e9c06281d52007a === $v5321626b774a579656cf063f8d8ac056)
	    {
		return true;
	    }
	}return false;
    }

    public function getRequestId()
    {
	static $v510ff634fce407eea1763854519fd3ce = false;
	if ($v510ff634fce407eea1763854519fd3ce === false)
	{
	    $v510ff634fce407eea1763854519fd3ce = time();
	}return $v510ff634fce407eea1763854519fd3ce;
    }

    public function getPreLang()
    {
	return $this->pre_lang;
    }

    protected function autoRedirectToMethod($v22884db148f0ffb0d830ba431102b0b5)
    {
	$v25173eac47bcd1aa0bb3a146f0595bb7 = $this->pre_lang;
	$vea9f6aca279138c58f705c8d4cb4b8ce = regedit::getInstance()->getVal("//modules/" . $v22884db148f0ffb0d830ba431102b0b5 . "/default_method_admin");
	$v572d4e421e5e6b9bc11d815e8a027112 = $v25173eac47bcd1aa0bb3a146f0595bb7 . "/admin/" . $v22884db148f0ffb0d830ba431102b0b5 . "/" . $vea9f6aca279138c58f705c8d4cb4b8ce . "/";
	outputBuffer::current()->redirect($v572d4e421e5e6b9bc11d815e8a027112);
    }

    public function calculateRefererUri()
    {
	if ($vc66c00ae9f18fc0c67d8973bd07dc4cd = getRequest('referer'))
	{
	    $_SESSION['referer'] = $vc66c00ae9f18fc0c67d8973bd07dc4cd;
	} else
	{
	    if ($vc66c00ae9f18fc0c67d8973bd07dc4cd = getSession('referer'))
	    {
		unset($_SESSION['referer']);
	    } else
	    {
		$vc66c00ae9f18fc0c67d8973bd07dc4cd = getServer('HTTP_REFERER');
	    }
	}$this->calculated_referer_uri = $vc66c00ae9f18fc0c67d8973bd07dc4cd;
    }

    public function getCalculatedRefererUri()
    {
	if ($this->calculated_referer_uri === false)
	{
	    $this->calculateRefererUri();
	}return $this->calculated_referer_uri;
    }

    public function isModule($v854203cccade0bbe21be239a208aea49)
    {
	$vb1444fb0c07653567ad325aa25d4e37a = regedit::getInstance();
	if ($vb1444fb0c07653567ad325aa25d4e37a->getVal('//modules/' . $v854203cccade0bbe21be239a208aea49))
	{
	    return true;
	} else
	{
	    return false;
	}
    }

    public function setUrlPrefix($v851f5ac9941d720844d143ed9cfcf60a = '')
    {
	$this->url_prefix = $v851f5ac9941d720844d143ed9cfcf60a;
    }

    public function getUrlPrefix()
    {
	return $this->url_prefix ? $this->url_prefix : '';
    }

}

; ?>
