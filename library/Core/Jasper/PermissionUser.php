<?php
class Core_Jasper_PermissionUser extends User {

	public static function createFromUser(Core_Jasper_User $user) {
		$result = new self($user->username, $user->fullName, $user->externallyDefined, $user->tenantId);
		return $result;
	}

	public function __construct($username, $fullName, $externallyDefined, $tenantId = null) {
		$this->username = $username;
		$this->fullName = $fullName;
		$this->externallyDefined = $externallyDefined;
		$this->tenantId = (!empty($tenantId)) ? strval($tenantId) : null;
		$this->_attributes = array('xsi:type' => 'userImpl');
	}

	public function asXML() {
		$seri_opt = array(
				'indent' => '     ',
				'rootName' => 'permissionRecipient',
				'ignoreNull' => true,
				'attributesArray' => '_attributes'	// see Serializer docs
		);
		$seri = new \XML_Serializer($seri_opt);
		$res = $seri->serialize($this);
		if ($res === true) {
			return $seri->getSerializedData();
		} else {
			return false;
		}
	}
} 