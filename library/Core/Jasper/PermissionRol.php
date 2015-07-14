<?php
class Core_Jasper_PermissionRole extends Role {

	public static function createFromRole(Core_Jasper_Role $role) {
		$result = new self($role->name, $role->tenantId, $role->externallyDefined);
		return $result;
	}

	public function __construct($name, $tenantId = null, $externallyDefined = 'false') {
		parent::__construct($name, $tenantId, $externallyDefined);
		$this->_attributes = array('xsi:type' => 'roleImpl');
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
} // PermissionRole -- END
