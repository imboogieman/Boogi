<?php

	/**
	 * Class Callingcode helper to get celling code from outer api
	 */
	class Callingcodes {

		static public function getCode() {
			// Check cache
			$callingCode = Cache::get($_SERVER['REMOTE_ADDR']);
			if ($callingCode) return $callingCode;

			try {
				$data         = file_get_contents( 'http://ipinfo.io/'.$_SERVER['REMOTE_ADDR'] );
				$detailsId    = json_decode( str_replace( "\n", "", $data ) );
				$counryInfo   = json_decode( file_get_contents( 'https://restcountries.eu/rest/v1/alpha/' . $detailsId->country ) );
				$callingCode = $counryInfo->callingCodes[0];

				Cache::set($_SERVER['REMOTE_ADDR'], $callingCode);
				return $callingCode;
			} catch (Exception $e) {
				Command::error($e->getMessage());
				return false;
			}
		}
	}