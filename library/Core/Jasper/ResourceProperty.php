<?php
/* ==========================================================================

 Copyright (C) 2005 - 2012 Jaspersoft Corporation. All rights reserved.
 http://www.jaspersoft.com.

 Unless you have purchased a commercial license agreement from Jaspersoft,
 the following license terms apply:

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU Affero General Public License as
 published by the Free Software Foundation, either version 3 of the
 License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU Affero  General Public License for more details.

 You should have received a copy of the GNU Affero General Public  License
 along with this program. If not, see <http://www.gnu.org/licenses/>.

=========================================================================== */
//namespace Jasper;

class Core_Jasper_ResourceProperty {
	public $name;
	public $value;
	public $children = array();

	public function __construct($name, $value = null) {
		$n = (!empty($name)) ? $name : null;
		$v = (isset($value)) ? $value : null;
		$this->name = $n;
		$this->value = $v;
	}

	public static function createFromXML($xml) {
		$sxi = new \SimpleXMLIterator($xml);

		$temp = new self(strval($sxi->attributes()->name), strval($sxi->value));
		foreach($sxi->resourceProperty as $nestedProp) {
			$temp->children[] = Core_Jasper_ResourceProperty::createFromXML($nestedProp->asXML());
		}
		return $temp;
	}

	public function newXML() {
		$result = new \SimpleXMLElement('<resourceProperty></resourceProperty>');

		if(!empty($this->name)) { $result->addAttribute('name', $this->name); }
		if(isset($this->value) && $this->value !== "") { $result->addChild('value', $this->value); }

		foreach($this->children as $child) {
			Core_Jasper_ResourceDescriptor::sxml_append($result, $child->newXML());
		}
		return $result;
	}

	public function getName() { return $this->name; }
	public function getValue() { return $this->value; }
	public function getChildren() { return $this->children; }

	public function setName($name) { $this->name = strval($name); }
	public function setValue($value) { $this->value = strval($value); }
	public function addChild($child) { $this->children[] = $child; }
}

