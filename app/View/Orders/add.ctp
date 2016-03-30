<div class="orders form">
<?php echo $this->Form->create('Order'); ?>
	<fieldset>
		<legend><?php echo __('Add Order'); ?></legend>
	<?php
		echo $this->Form->input('group_id');
		echo $this->Form->input('fb_customer_id');
		echo $this->Form->input('fb_page_id');
		echo $this->Form->input('fb_post_id');
		echo $this->Form->input('fb_comment_id');
		echo $this->Form->input('total_qty');
		echo $this->Form->input('code');
		echo $this->Form->input('postal_code');
		echo $this->Form->input('customer_name');
		echo $this->Form->input('mobile');
		echo $this->Form->input('telco_code');
		echo $this->Form->input('city');
		echo $this->Form->input('address');
		echo $this->Form->input('note1');
		echo $this->Form->input('note2');
		echo $this->Form->input('cancel_note');
		echo $this->Form->input('shipping_note');
		echo $this->Form->input('is_top_priority');
		echo $this->Form->input('is_send_sms');
		echo $this->Form->input('is_inner_city');
		echo $this->Form->input('shipping_service_id');
		echo $this->Form->input('bundle_id');
		echo $this->Form->input('status_id');
		echo $this->Form->input('price');
		echo $this->Form->input('discount_price');
		echo $this->Form->input('shipping_price');
		echo $this->Form->input('other_price');
		echo $this->Form->input('total_price');
		echo $this->Form->input('weight');
		echo $this->Form->input('duplicate_id');
		echo $this->Form->input('duplicate_note');
		echo $this->Form->input('user_confirmed');
		echo $this->Form->input('user_assigned');
		echo $this->Form->input('user_created');
		echo $this->Form->input('user_modified');
		echo $this->Form->input('confirmed');
		echo $this->Form->input('delivered');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
	</ul>
</div>
