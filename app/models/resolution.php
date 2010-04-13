<?php
class Resolution extends AppModel {
	var $name = 'Resolution';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'resolution_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	function is_fixed($id)
	{
		$record = $this->findById($id);
		if($record)
		{
			return ($record["Resolution"]["is_fixed"] == 1);
		}
		else
		{
			return false;
		}
	}

	/**
	 * 現在有効な解決状況
	 */
	function getActiveResolutionList()
	{
		$conditions = array();
		return $this->find('list', $conditions);
	}

	/**
	 * 解決状況一覧から名前に合致する解決状況のIDを探す
	 */
	function getResolutionId($resolutions, $name)
	{
		foreach($resolutions as $key => $value)
		{
			if($value === $name)
			{
				return $key;
			}
		}
		return null;
	}

	/**
	 * 初期データ
	 */
	function makeInitialRecord()
	{
		$rec = $this->find('list');
		if(count($rec) == 0)
		{
			$data["Resolution"]["id"] = RESOLUTION_TODO;
			$data["Resolution"]["name"] = __("TODO", true);
			$data["Resolution"]["is_fixed"] = 0;
			$this->create();
			$this->save($data);
			$data["Resolution"]["id"] = RESOLUTION_DOING;
			$data["Resolution"]["name"] = __("DOING", true);
			$data["Resolution"]["is_fixed"] = 0;
			$this->create();
			$this->save($data);
			$data["Resolution"]["id"] = RESOLUTION_DONE;
			$data["Resolution"]["name"] = __("DONE", true);
			$data["Resolution"]["is_fixed"] = 1;
			$this->create();
			$this->save($data);
		}
		return true;
	}
}
?>