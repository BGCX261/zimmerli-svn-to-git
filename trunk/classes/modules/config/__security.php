<?php
	abstract class __security_config extends baseModuleAdmin {

		public function security() {
			$regedit = regedit::getInstance();

			$params = array(
				'test' => array(),
			);

			$this->setDataType("settings");
			$this->setActionType("modify");

			$data = $this->prepareData($params, "settings");

			$this->setData($data);
			return $this->doData();
		}

		/**
		 * Запускает тестирование указанного параметра безопасности.
		 *
		 * @param String $test - Код теста который необходимо запустить
		 */
		public function securityRunTest() {
			$allowedTests = array(
				'UFS',
				'UObject',
				'DBLogin',
				'DBPassword'
			);

			$testIndex = intval(getRequest('param0'));
			if (!isset($allowedTests[$testIndex])) {
				return false; //TODO Throw correct error
			}
			$next = isset($allowedTests[$testIndex + 1]) ? ($testIndex + 1) : false;
			$testName = 'test' . $allowedTests[$testIndex];
			$result = $this->$testName();
			$response = json_encode(array(
				'test' => strtolower($allowedTests[$testIndex]),
				'result' => $result,
				'next' => $next,
			));

			$buffer = outputBuffer::current();
			$buffer-> option('generation-time', false);
			$buffer-> clear();
			$buffer-> push($response);
			$buffer-> end();
		}

		/**
		 * Тестирует возможность доступа к стриму ufs по http
		 *
		 * @return boolean
		 */
		public function testUFS() {
			$config = mainConfiguration::getInstance();
			$enabledStreams = $config->get("streams", "enable");
			$ufsEnabled = in_array('ufs', $enabledStreams);
			$ufsHttpStatus = (bool) $config->get("streams", "ufs.http.allow");
			if (!($ufsEnabled && $ufsHttpStatus)) {
				return true;
			}

			return false;
		}

		/**
		 * Тестирует возможность доступа к стриму uobject по http
		 *
		 * @return boolean
		 */
		public function testUObject(){
			$config = mainConfiguration::getInstance();
			$enabledStreams = $config->get("streams", "enable");
			$uobjectEnabled = in_array('uobject', $enabledStreams);
			$uobjectHttpStatus = $config->get("streams", "uobject.http.allow");
			if (!($uobjectEnabled && $uobjectHttpStatus)) {
				return true;
			}
			return false;
		}

		/**
		 * Проверяет что доступ к БД осуществляется не из под рута
		 *
		 * @return boolean
		 */
		public function testDBLogin(){
			$config = mainConfiguration::getInstance();
			$dbLogin = $config->get("connections", "core.login");
			if (strtolower($dbLogin) != 'root') {
				return true;
			}
			return false;
		}

		/**
		 * Проверяет что доступ к БД осуществляется с непустым паролем
		 *
		 * @return boolean
		 */
		public function testDBPassword(){
			$config = mainConfiguration::getInstance();
			$dbPassword = $config->get("connections", "core.password");
			if (!empty($dbPassword)) {
				return true;
			}
			return false;
		}
	};
?>