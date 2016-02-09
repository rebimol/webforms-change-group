<?php
class VladimirPopov_WebFormsCG_Model_Observer
{
	public function changeCustomerGroup($observer)
	{
		if(Mage::registry('webformscg_after_save')) return;
		
		Mage::register('webformscg_after_save',true);
		
		$group_id = Mage::getModel('webforms/webforms')->load($observer->getResult()->getWebformId())->getGroupId();
		$customer_id = $observer->getResult()->getCustomerId();

		if ($customer_id && $group_id > -1) {
			
			// assign customer to new group
			$customer = Mage::getModel('customer/customer')->load($customer_id)->setGroupId($group_id)->save();
		}
	}

	public function addSettings($observer)
	{

		$form = $observer->getForm();

		$fieldset = $form->addFieldset('webformscg_setting', array ('legend' => Mage::helper('core')->__('Customers')));

		$fieldset->addField('group_id', 'select', array
		(
			'label' => Mage::helper('core')->__('Assign to group'),
			'title' => Mage::helper('core')->__('Assign to group'),
			'name' => 'group_id',
			'required' => false,
			'note' => Mage::helper('core')->__('Assign customer to new group after form submission'),
			'values' => $this->getGroupOptions(),
		));
	}

	public function getGroupOptions()
	{
		$options = array ();
		$collection = Mage::getModel('customer/group')->getCollection();
		
		foreach($collection as $group){
			$options[] = array('value'=>$group->getCustomerGroupId(), 'label' => $group->getCustomerGroupCode());
		}
		
		$options = array_merge(array (array
		(
			'value' => '-1',
			'label' => Mage::helper('core')->__('-- Don\'t change group --')
		),), $options);

		return $options;
	}
}
?>