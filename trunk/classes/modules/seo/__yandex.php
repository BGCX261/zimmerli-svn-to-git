<?php
	abstract class __yandex_webmaster extends baseModuleAdmin {

		public function webmaster() {
			$this->setDataType("settings");
			$this->setActionType("view");

			$preParams = array();
			$hostsData = $this->getList();

			$data = $this->prepareData($preParams, 'settings');
			$data['hosts']['nodes:host'] = $hostsData;

			$this->setData($data);
			return $this->doData();
		}

		public function getList() {
			$url = '/api/me';
			$serviceDocUrl = $this->getYandexData($url, false, array(), array(), '302 Found');
			$serviceDoc = simplexml_load_string($this->getYandexData($serviceDocUrl));
			$hostsList = (string) $serviceDoc->workspace->collection->attributes()->href;
			$hostsData = simplexml_load_string($this->getYandexData($hostsList));
			$result = array();

			$domainsCollection = domainsCollection::getInstance();

			foreach ($hostsData->host as $host) {
				if ($currentHost = $this->getHostData($host->attributes()->href)) {
					$result[$currentHost['@id']] = $currentHost;
				}
			}

			foreach ($domainsCollection->getList() as $id=>$host) {
				if(array_key_exists($id, $result)) {
					continue;
				}
				$currentHost = array(
					'@id' => $id,
					'name' => $host->getHost(),
					'addLink' => $hostsList
				);
				$result[] = $currentHost;
			}

			return $result;
		}

		public function add_site() {
			$this->setDataType("settings");
			$this->setActionType("view");

			$preParams = array();
			$data = $this->prepareData($preParams, 'settings');

			$addLink = getRequest('addLink');
			$hostName = getRequest('hostName');
			$params = "<host><name>$hostName</name></host>";
			$hostLink = $this->getYandexData($addLink, "POST", array(), $params, '201 Created');
			$hostLinks = simplexml_load_string($this->getYandexData($hostLink));
			foreach ($hostLinks->link as $link) {
				$link = (string) $link->attributes()->href;
				if (array_pop(explode('/', $link)) == 'verify') {
					$verification = simplexml_load_string($this->getYandexData($link));
					$uin = (string) $verification->verification->uin;
					$verificationFile = fopen($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'yandex_' . $uin . '.txt', 'w+');
					fclose($verificationFile);
					$params = '<host><type>TXT_FILE</type></host>';
					$this->getYandexData($link, "PUT", array(), $params, '204 No Content');
				}
			}

			$data['hosts']['host'] = $this->getHostData($hostLink);

			$this->setData($data);
			return $this->doData();
		}

		public function verify_site() {
			$this->setDataType("settings");
			$this->setActionType("view");

			$preParams = array();
			$data = $this->prepareData($preParams, 'settings');

			$verifyLink = getRequest('verifyLink');
			$hostLink = getRequest('hostLink');
			$verification = simplexml_load_string($this->getYandexData($verifyLink));
			$uin = (string) $verification->verification->uin;
			$verificationFile = fopen($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'yandex_' . $uin . '.txt', 'w+');
			fclose($verificationFile);
			$params = '<host><type>TXT_FILE</type></host>';
			$this->getYandexData($verifyLink, "PUT", array(), $params, '204 No Content');

			$data['hosts']['host'] = $this->getHostData($hostLink);

			$this->setData($data);
			return $this->doData();
		}

		public function refresh_site() {
			$this->setDataType("settings");
			$this->setActionType("view");

			$preParams = array();
			$data = $this->prepareData($preParams, 'settings');

			$hostLink = getRequest('hostLink');
			$data['hosts']['host'] = $this->getHostData($hostLink);

			$this->setData($data);
			return $this->doData();
		}

		public function handle_url($url=false) {
			if (!$url) {
				$url = getRequest('url');
			}

			$preParams = array();
			$hostsData = $this->getYandexData($url);
			$this->setDataType("settings");
			$this->setActionType("view");
			$data = $this->prepareData($preParams, 'settings');
			$data['xml:yandex'] = $hostsData;

			$this->setData($data);
			return $this->doData();
		}

		public function getYandexData($url, $method="GET", $headers = array(), $params = array(), $responseCode = '200 OK'){
			$regedit = regedit::getInstance();
			$token = (string) trim($regedit->getVal("//modules/seo/yandex-token"));

			if (!$token) throw new publicAdminException(getLabel('label-error-no-token'));

			$headers["Authorization"] = "OAuth " . $token;

			$apiUrl = 'https://webmaster.yandex.ru';
			if (strpos($url, '/') === 0) {
				$url = $apiUrl . $url;
			}

			$response = umiRemoteFileGetter::get($url, false, $headers, $params, true, $method);

			$result = preg_split("|(\r\n\r\n)|", $response);
			$headerLines = $result[0];
			$xml = $result[1];

			$headerLines = preg_split("|(\r\n)|", $headerLines);
			$responseHeaders = array();
			foreach ($headerLines as $headerLine) {
				if (strpos($headerLine, ':')) {
					list($key, $value) = explode(": ", $headerLine);
					$responseHeaders[strtolower(trim($key))] = trim($value);
				} else {
					$responseHeaders['code'] = trim(preg_replace("#HTTP([^\s]*)\s#", '', trim($headerLine)));
				}
			}

			if ($responseHeaders['code'] != $responseCode) {
				if ($responseHeaders['code'] == '401 Unauthorized') {
					throw new publicAdminException(getLabel('label-error-no-token'));
				} else {
					throw new publicAdminException(getLabel('label-error-service-down'));
				}
			}

			switch ($responseCode) {
				case "302 Found":
				case "201 Created":
					return $responseHeaders['location'];
					break;
			}

			return $xml;
		}

		public function getHostData($hostUrl) {
			$domainsCollection = domainsCollection::getInstance();
			$hostLinks = simplexml_load_string($this->getYandexData($hostUrl));
			if(!$hostId = $domainsCollection->getDomainId($hostLinks->name)) {
				return false;
			}
			$currentHost['@id'] = $hostId;
			$currentHost['@link'] = (string) $hostUrl;
			$links = array();
			foreach ($hostLinks->link as $link) {
				$link = (string) $link->attributes()->href;
				$links[array_pop(explode('/', $link))] = $link;
			}
			if (isset($links['stats'])) {
				$hostStats = simplexml_load_string($this->getYandexData($links['stats']));
				unset($links['stats']);
			}
			foreach ($hostStats as $key=>$value) {
				switch ($key) {
					case 'verification':
						$currentHost[$key] = array(
							'state' => (string) $value->attributes()->state,
						);
						if (trim((string) $value->attributes()->state) != 'VERIFIED' && isset($links['verify'])) {
							$currentHost[$key]['link'] = $links['verify'];
						}
						unset($links['verify']);
						break;
					case 'crawling':
						$currentHost[$key] = array(
							'state' => getLabel('js-webmaster-crawling-state-' . (string) $value->attributes()->state),
						);
						break;
					case 'last-access':
						$currentHost[$key] = date('d.m.Y H:i:s', strtotime((string) $value));
						break;
					case 'virused':
						$currentHost[$key] = ((string) $value == 'true') ? 'Да' : 'Нет';
						break;
					default :
						$currentHost[$key] = (string) $value;
				}
			}
			$currentHost['links'] = $links;
			return $currentHost;
		}
	}
?>