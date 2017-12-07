<?php

namespace Api;

Class Tools{
	public static function isAjax(){
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
				strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
	}
}