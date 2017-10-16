<?php
class Memobird {
	private $api_router = 'http://w.memobird.cn/cn/ashx/DBInterface.ashx';
	private $phone = '';
	public function __construct($phone = '') {
		if (!$phone) {
			return false;
		}
		$this->phone = $phone;
	}
	public function searchUser($phone = '') {
		$data = [
			'DataType' => 'SearchUserList',
			'UserId' => $this->getSelfUserID(),
			'searchCode' => $phone,
		];
		return self::_cURL(null, $this->api_router . "?" . http_build_query($data), 'get');
	}
	public function getUserInfo($phone = '') {
		$UserId = json_decode($this->searchUser($this->phone), true)['users'][0]['userId'];
		$data = [
			'DataType' => 'SearchUserList',
			'UserId' => $UserId,
			'searchCode' => $phone,
		];
		return json_encode(json_decode(self::_cURL(null, $this->api_router . "?" . http_build_query($data), 'get'), true)['users'][0]);
	}
	public function getSelfUserID() {
		$data = [
			'DataType' => 'SearchUserList',
			'UserId' => 'eyJwYXJhbWV0ZXIiOiJIUTFhVTc3Y1NaY3RJMm1scVpseXN0ekVrVXF4c0pRMyIsInN5c0RhdGUiOiIyMDE3LzEwLzE2IDExOjAwOjMxIn0%3d',
			'searchCode' => $this->phone,
		];
		return json_decode(self::_cURL(null, $this->api_router . "?" . http_build_query($data), 'get'), true)['users'][0]['userId'];
	}
	public function getUserDeviceList($uid = '') {
		$data = [
			'DataType' => 'GetSmartCoreByUserID',
			'UserId' => $uid,
		];
		return self::_cURL(null, $this->api_router . "?" . http_build_query($data), 'get');
	}
	public function getDeviceInfo($gugu_id = '') {
		$data = [
			'DataType' => 'GetSmartCoreInfo',
			'strGuid' => $gugu_id,
		];
		return self::_cURL(null, $this->api_router . "?" . http_build_query($data), 'get');
	}
	public function printPaper($fromUserName = '', $toUserId = '', $toUserName = '', $gugu_id_list = '', $content = '') {
		$fromUserId = json_decode($this->searchUser($this->phone), true)['users'][0]['userId'];
		$data = [
			'DataType' => 'PrintPaper',
			'fromUserId' => $fromUserId,
			'fromUserName' => $fromUserName,
			'toUserId' => $toUserId,
			'toUserName' => $toUserName,
			'guidList' => $gugu_id_list,
			'printContent' => urlencode($content),
		];
		return self::_cURL($data, $this->api_router);
	}
	private static function _cURL($data = null, $url = null, $type = 'post') {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		if ($type == 'post') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($ch, CURLOPT_COOKIE, 'logininfo=');
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}