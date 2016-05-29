<div class="groups form">
<?php echo $this->Form->create('Group'); ?>
	<fieldset>
		<legend><?php echo __('Add Group'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('code');
		echo $this->Form->input('description');
		echo $this->Form->input('weight');
		echo $this->Form->input('fb_user_id');
		echo $this->Form->input('fb_user_token');
		echo $this->Form->input('last_time_sync_pages');
		echo $this->Form->input('sync_page_transid');
		echo $this->Form->input('sync_page_expire');
		echo $this->Form->input('status');
		echo $this->Form->input('user_created');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Billing Prints'), array('controller' => 'billing_prints', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Billing Print'), array('controller' => 'billing_prints', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bundles'), array('controller' => 'bundles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bundle'), array('controller' => 'bundles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fb Conversation Messages'), array('controller' => 'fb_conversation_messages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fb Conversation Message'), array('controller' => 'fb_conversation_messages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fb Cron Configs'), array('controller' => 'fb_cron_configs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fb Cron Config'), array('controller' => 'fb_cron_configs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fb Customers'), array('controller' => 'fb_customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fb Customer'), array('controller' => 'fb_customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fb Pages'), array('controller' => 'fb_pages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fb Page'), array('controller' => 'fb_pages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fb Post Comments'), array('controller' => 'fb_post_comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fb Post Comment'), array('controller' => 'fb_post_comments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fb Posts'), array('controller' => 'fb_posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fb Post'), array('controller' => 'fb_posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shipping Services'), array('controller' => 'shipping_services', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shipping Service'), array('controller' => 'shipping_services', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Statuses'), array('controller' => 'statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Status'), array('controller' => 'statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stock Books'), array('controller' => 'stock_books', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stock Book'), array('controller' => 'stock_books', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stock Deliverings'), array('controller' => 'stock_deliverings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stock Delivering'), array('controller' => 'stock_deliverings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stock Receivings'), array('controller' => 'stock_receivings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stock Receiving'), array('controller' => 'stock_receivings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stocks'), array('controller' => 'stocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stock'), array('controller' => 'stocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Suppliers'), array('controller' => 'suppliers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplier'), array('controller' => 'suppliers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Units'), array('controller' => 'units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Unit'), array('controller' => 'units', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
