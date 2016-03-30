<div class="orders view">
<h2><?php echo __('Order'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['group_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fb Customer Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['fb_customer_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fb Page Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['fb_page_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fb Post Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['fb_post_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fb Comment Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['fb_comment_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Total Qty'); ?></dt>
		<dd>
			<?php echo h($order['Order']['total_qty']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($order['Order']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($order['Order']['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer Name'); ?></dt>
		<dd>
			<?php echo h($order['Order']['customer_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mobile'); ?></dt>
		<dd>
			<?php echo h($order['Order']['mobile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telco Code'); ?></dt>
		<dd>
			<?php echo h($order['Order']['telco_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($order['Order']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($order['Order']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note1'); ?></dt>
		<dd>
			<?php echo h($order['Order']['note1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note2'); ?></dt>
		<dd>
			<?php echo h($order['Order']['note2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cancel Note'); ?></dt>
		<dd>
			<?php echo h($order['Order']['cancel_note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping Note'); ?></dt>
		<dd>
			<?php echo h($order['Order']['shipping_note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Top Priority'); ?></dt>
		<dd>
			<?php echo h($order['Order']['is_top_priority']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Send Sms'); ?></dt>
		<dd>
			<?php echo h($order['Order']['is_send_sms']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Inner City'); ?></dt>
		<dd>
			<?php echo h($order['Order']['is_inner_city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping Service Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['shipping_service_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bundle Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['bundle_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['status_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($order['Order']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Price'); ?></dt>
		<dd>
			<?php echo h($order['Order']['discount_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping Price'); ?></dt>
		<dd>
			<?php echo h($order['Order']['shipping_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Other Price'); ?></dt>
		<dd>
			<?php echo h($order['Order']['other_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Total Price'); ?></dt>
		<dd>
			<?php echo h($order['Order']['total_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Weight'); ?></dt>
		<dd>
			<?php echo h($order['Order']['weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Duplicate Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['duplicate_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Duplicate Note'); ?></dt>
		<dd>
			<?php echo h($order['Order']['duplicate_note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Confirmed'); ?></dt>
		<dd>
			<?php echo h($order['Order']['user_confirmed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Assigned'); ?></dt>
		<dd>
			<?php echo h($order['Order']['user_assigned']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Created'); ?></dt>
		<dd>
			<?php echo h($order['Order']['user_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Modified'); ?></dt>
		<dd>
			<?php echo h($order['Order']['user_modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Confirmed'); ?></dt>
		<dd>
			<?php echo h($order['Order']['confirmed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delivered'); ?></dt>
		<dd>
			<?php echo h($order['Order']['delivered']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($order['Order']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($order['Order']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order'), array('action' => 'edit', $order['Order']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order'), array('action' => 'delete', $order['Order']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $order['Order']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('action' => 'add')); ?> </li>
	</ul>
</div>
