<?php
	include_once("config.php");

	class VirtualTime {
		
		public static function update_offset() {
			$url = "http://arka.foi.hr/PzaWeb/PzaWeb2004/config/pomak.xml";
			$xml = simplexml_load_file($url);

			$config = R::load('config', 1);

			if (!$config->id)
				$config = R::dispense('config');

			$config->time_offset = intval($xml->vrijeme->pomak['brojSati']);
			$config->use_arka = false;

			$config_id = R::store($config);

			return $config->time_offset;
		}

		
		public static function get_offset() {
			// uvijek dohvaca sa zadane adrese
			return VirtualTime::update_offset();
		}

		
		public static function get_time() {
			return (string)(time() + (VirtualTime::get_offset() * 60 * 60));
		}

		public static function get_date($format = "Y-m-d H:i:s") {
			return date($format, VirtualTime::get_time());
		}

		public static function date_to_str($str_time) {
			return strtotime($str_time);
		}
	}

?>
