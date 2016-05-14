<div class="groups view">
<h2><?php echo __('Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($group['Group']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($group['Group']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($group['Group']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Weight'); ?></dt>
		<dd>
			<?php echo h($group['Group']['weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fb User Id'); ?></dt>
		<dd>
			<?php echo h($group['Group']['fb_user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fb User Token'); ?></dt>
		<dd>
			<?php echo h($group['Group']['fb_user_token']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Time Sync Pages'); ?></dt>
		<dd>
			<?php echo h($group['Group']['last_time_sync_pages']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sync Page Transid'); ?></dt>
		<dd>
			<?php echo h($group['Group']['sync_page_transid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sync Page Expire'); ?></dt>
		<dd>
			<?php echo h($group['Group']['sync_page_expire']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($group['Group']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Created'); ?></dt>
		<dd>
			<?php echo h($group['Group']['user_created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($group['Group']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($group['Group']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Group'), array('action' => 'edit', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Group'), array('action' => 'delete', $group['Group']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $group['Group']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Billing Prints'); ?></h3>
	<?php if (!empty($group['BillingPrint'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Fb User Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Template Uri'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['BillingPrint'] as $billingPrint): ?>
		<tr>
			<td><?php echo $billingPrint['id']; ?></td>
			<td><?php echo $billingPrint['group_id']; ?></td>
			<td><?php echo $billingPrint['fb_user_id']; ?></td>
			<td><?php echo $billingPrint['name']; ?></td>
			<td><?php echo $billingPrint['template_uri']; ?></td>
			<td><?php echo $billingPrint['data']; ?></td>
			<td><?php echo $billingPrint['user_created']; ?></td>
			<td><?php echo $billingPrint['created']; ?></td>
			<td><?php echo $billingPrint['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'billing_prints', 'action' => 'view', $billingPrint['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'billing_prints', 'action' => 'edit', $billingPrint['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'billing_prints', 'action' => 'delete', $billingPrint['id']), array('confirm' => __('Are you sure you want to delete # %s?', $billingPrint['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Billing Print'), array('controller' => 'billing_prints', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Bundles'); ?></h3>
	<?php if (!empty($group['Bundle'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['Bundle'] as $bundle): ?>
		<tr>
			<td><?php echo $bundle['id']; ?></td>
			<td><?php echo $bundle['name']; ?></td>
			<td><?php echo $bundle['group_id']; ?></td>
			<td><?php echo $bundle['weight']; ?></td>
			<td><?php echo $bundle['created']; ?></td>
			<td><?php echo $bundle['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'bundles', 'action' => 'view', $bundle['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'bundles', 'action' => 'edit', $bundle['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'bundles', 'action' => 'delete', $bundle['id']), array('confirm' => __('Are you sure you want to delete # %s?', $bundle['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Bundle'), array('controller' => 'bundles', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Fb Conversation Messages'); ?></h3>
	<?php if (!empty($group['FbConversationMessage'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Fb Conversation Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Fb Customer Id'); ?></th>
		<th><?php echo __('Fb User Id'); ?></th>
		<th><?php echo __('Fb Page Id'); ?></th>
		<th><?php echo __('Message Id'); ?></th>
		<th><?php echo __('Content'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['FbConversationMessage'] as $fbConversationMessage): ?>
		<tr>
			<td><?php echo $fbConversationMessage['id']; ?></td>
			<td><?php echo $fbConversationMessage['fb_conversation_id']; ?></td>
			<td><?php echo $fbConversationMessage['group_id']; ?></td>
			<td><?php echo $fbConversationMessage['fb_customer_id']; ?></td>
			<td><?php echo $fbConversationMessage['fb_user_id']; ?></td>
			<td><?php echo $fbConversationMessage['fb_page_id']; ?></td>
			<td><?php echo $fbConversationMessage['message_id']; ?></td>
			<td><?php echo $fbConversationMessage['content']; ?></td>
			<td><?php echo $fbConversationMessage['status']; ?></td>
			<td><?php echo $fbConversationMessage['user_created']; ?></td>
			<td><?php echo $fbConversationMessage['created']; ?></td>
			<td><?php echo $fbConversationMessage['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fb_conversation_messages', 'action' => 'view', $fbConversationMessage['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fb_conversation_messages', 'action' => 'edit', $fbConversationMessage['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fb_conversation_messages', 'action' => 'delete', $fbConversationMessage['id']), array('confirm' => __('Are you sure you want to delete # %s?', $fbConversationMessage['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fb Conversation Message'), array('controller' => 'fb_conversation_messages', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Fb Cron Configs'); ?></h3>
	<?php if (!empty($group['FbCronConfig'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __(' Key'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('Level'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['FbCronConfig'] as $fbCronConfig): ?>
		<tr>
			<td><?php echo $fbCronConfig['group_id']; ?></td>
			<td><?php echo $fbCronConfig['_key']; ?></td>
			<td><?php echo $fbCronConfig['type']; ?></td>
			<td><?php echo $fbCronConfig['description']; ?></td>
			<td><?php echo $fbCronConfig['value']; ?></td>
			<td><?php echo $fbCronConfig['level']; ?></td>
			<td><?php echo $fbCronConfig['created']; ?></td>
			<td><?php echo $fbCronConfig['updated']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fb_cron_configs', 'action' => 'view', $fbCronConfig['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fb_cron_configs', 'action' => 'edit', $fbCronConfig['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fb_cron_configs', 'action' => 'delete', $fbCronConfig['id']), array('confirm' => __('Are you sure you want to delete # %s?', $fbCronConfig['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fb Cron Config'), array('controller' => 'fb_cron_configs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Fb Customers'); ?></h3>
	<?php if (!empty($group['FbCustomer'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Fb Id'); ?></th>
		<th><?php echo __('Fb Username'); ?></th>
		<th><?php echo __('Fb Name'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['FbCustomer'] as $fbCustomer): ?>
		<tr>
			<td><?php echo $fbCustomer['id']; ?></td>
			<td><?php echo $fbCustomer['group_id']; ?></td>
			<td><?php echo $fbCustomer['fb_id']; ?></td>
			<td><?php echo $fbCustomer['fb_username']; ?></td>
			<td><?php echo $fbCustomer['fb_name']; ?></td>
			<td><?php echo $fbCustomer['email']; ?></td>
			<td><?php echo $fbCustomer['phone']; ?></td>
			<td><?php echo $fbCustomer['name']; ?></td>
			<td><?php echo $fbCustomer['address']; ?></td>
			<td><?php echo $fbCustomer['created']; ?></td>
			<td><?php echo $fbCustomer['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fb_customers', 'action' => 'view', $fbCustomer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fb_customers', 'action' => 'edit', $fbCustomer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fb_customers', 'action' => 'delete', $fbCustomer['id']), array('confirm' => __('Are you sure you want to delete # %s?', $fbCustomer['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fb Customer'), array('controller' => 'fb_customers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Fb Pages'); ?></h3>
	<?php if (!empty($group['FbPage'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Page Id'); ?></th>
		<th><?php echo __('Page Name'); ?></th>
		<th><?php echo __('Token'); ?></th>
		<th><?php echo __('Last Conversation Time'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['FbPage'] as $fbPage): ?>
		<tr>
			<td><?php echo $fbPage['id']; ?></td>
			<td><?php echo $fbPage['group_id']; ?></td>
			<td><?php echo $fbPage['page_id']; ?></td>
			<td><?php echo $fbPage['page_name']; ?></td>
			<td><?php echo $fbPage['token']; ?></td>
			<td><?php echo $fbPage['last_conversation_time']; ?></td>
			<td><?php echo $fbPage['status']; ?></td>
			<td><?php echo $fbPage['user_created']; ?></td>
			<td><?php echo $fbPage['created']; ?></td>
			<td><?php echo $fbPage['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fb_pages', 'action' => 'view', $fbPage['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fb_pages', 'action' => 'edit', $fbPage['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fb_pages', 'action' => 'delete', $fbPage['id']), array('confirm' => __('Are you sure you want to delete # %s?', $fbPage['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fb Page'), array('controller' => 'fb_pages', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Fb Post Comments'); ?></h3>
	<?php if (!empty($group['FbPostComment'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Fb Customer Id'); ?></th>
		<th><?php echo __('Fb User Id'); ?></th>
		<th><?php echo __('Fb Page Id'); ?></th>
		<th><?php echo __('Page Id'); ?></th>
		<th><?php echo __('Fb Post Id'); ?></th>
		<th><?php echo __('Post Id'); ?></th>
		<th><?php echo __('Comment Id'); ?></th>
		<th><?php echo __('Content'); ?></th>
		<th><?php echo __('Parent Comment Id'); ?></th>
		<th><?php echo __('Fb Conversation Id'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['FbPostComment'] as $fbPostComment): ?>
		<tr>
			<td><?php echo $fbPostComment['id']; ?></td>
			<td><?php echo $fbPostComment['group_id']; ?></td>
			<td><?php echo $fbPostComment['fb_customer_id']; ?></td>
			<td><?php echo $fbPostComment['fb_user_id']; ?></td>
			<td><?php echo $fbPostComment['fb_page_id']; ?></td>
			<td><?php echo $fbPostComment['page_id']; ?></td>
			<td><?php echo $fbPostComment['fb_post_id']; ?></td>
			<td><?php echo $fbPostComment['post_id']; ?></td>
			<td><?php echo $fbPostComment['comment_id']; ?></td>
			<td><?php echo $fbPostComment['content']; ?></td>
			<td><?php echo $fbPostComment['parent_comment_id']; ?></td>
			<td><?php echo $fbPostComment['fb_conversation_id']; ?></td>
			<td><?php echo $fbPostComment['status']; ?></td>
			<td><?php echo $fbPostComment['user_created']; ?></td>
			<td><?php echo $fbPostComment['created']; ?></td>
			<td><?php echo $fbPostComment['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fb_post_comments', 'action' => 'view', $fbPostComment['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fb_post_comments', 'action' => 'edit', $fbPostComment['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fb_post_comments', 'action' => 'delete', $fbPostComment['id']), array('confirm' => __('Are you sure you want to delete # %s?', $fbPostComment['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fb Post Comment'), array('controller' => 'fb_post_comments', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Fb Posts'); ?></h3>
	<?php if (!empty($group['FbPost'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Page Id'); ?></th>
		<th><?php echo __('Post Id'); ?></th>
		<th><?php echo __('Fb Page Id'); ?></th>
		<th><?php echo __('Fb Post Id'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Product Id'); ?></th>
		<th><?php echo __('Bundle Id'); ?></th>
		<th><?php echo __('Answer Phone'); ?></th>
		<th><?php echo __('Answer Nophone'); ?></th>
		<th><?php echo __('Hide Phone Comment'); ?></th>
		<th><?php echo __('Last Time Fetch Comment'); ?></th>
		<th><?php echo __('Next Time Fetch Comment'); ?></th>
		<th><?php echo __('Level Fetch Comment'); ?></th>
		<th><?php echo __('Nodata Number Day'); ?></th>
		<th><?php echo __('Gearman Hostname'); ?></th>
		<th><?php echo __('Gearman Worker'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('User Modified'); ?></th>
		<th><?php echo __('Reply By Scripting'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['FbPost'] as $fbPost): ?>
		<tr>
			<td><?php echo $fbPost['id']; ?></td>
			<td><?php echo $fbPost['group_id']; ?></td>
			<td><?php echo $fbPost['page_id']; ?></td>
			<td><?php echo $fbPost['post_id']; ?></td>
			<td><?php echo $fbPost['fb_page_id']; ?></td>
			<td><?php echo $fbPost['fb_post_id']; ?></td>
			<td><?php echo $fbPost['description']; ?></td>
			<td><?php echo $fbPost['product_id']; ?></td>
			<td><?php echo $fbPost['bundle_id']; ?></td>
			<td><?php echo $fbPost['answer_phone']; ?></td>
			<td><?php echo $fbPost['answer_nophone']; ?></td>
			<td><?php echo $fbPost['hide_phone_comment']; ?></td>
			<td><?php echo $fbPost['last_time_fetch_comment']; ?></td>
			<td><?php echo $fbPost['next_time_fetch_comment']; ?></td>
			<td><?php echo $fbPost['level_fetch_comment']; ?></td>
			<td><?php echo $fbPost['nodata_number_day']; ?></td>
			<td><?php echo $fbPost['gearman_hostname']; ?></td>
			<td><?php echo $fbPost['gearman_worker']; ?></td>
			<td><?php echo $fbPost['status']; ?></td>
			<td><?php echo $fbPost['created']; ?></td>
			<td><?php echo $fbPost['modified']; ?></td>
			<td><?php echo $fbPost['user_created']; ?></td>
			<td><?php echo $fbPost['user_modified']; ?></td>
			<td><?php echo $fbPost['reply_by_scripting']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fb_posts', 'action' => 'view', $fbPost['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fb_posts', 'action' => 'edit', $fbPost['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fb_posts', 'action' => 'delete', $fbPost['id']), array('confirm' => __('Are you sure you want to delete # %s?', $fbPost['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fb Post'), array('controller' => 'fb_posts', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Orders'); ?></h3>
	<?php if (!empty($group['Order'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Fb Customer Id'); ?></th>
		<th><?php echo __('Fb Page Id'); ?></th>
		<th><?php echo __('Fb Post Id'); ?></th>
		<th><?php echo __('Fb Comment Id'); ?></th>
		<th><?php echo __('Total Qty'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Postal Code'); ?></th>
		<th><?php echo __('Customer Name'); ?></th>
		<th><?php echo __('Mobile'); ?></th>
		<th><?php echo __('Telco Code'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Note1'); ?></th>
		<th><?php echo __('Note2'); ?></th>
		<th><?php echo __('Cancel Note'); ?></th>
		<th><?php echo __('Shipping Note'); ?></th>
		<th><?php echo __('Is Top Priority'); ?></th>
		<th><?php echo __('Is Send Sms'); ?></th>
		<th><?php echo __('Is Inner City'); ?></th>
		<th><?php echo __('Shipping Service Id'); ?></th>
		<th><?php echo __('Bundle Id'); ?></th>
		<th><?php echo __('Status Id'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Discount Price'); ?></th>
		<th><?php echo __('Shipping Price'); ?></th>
		<th><?php echo __('Other Price'); ?></th>
		<th><?php echo __('Total Price'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Duplicate Id'); ?></th>
		<th><?php echo __('Duplicate Note'); ?></th>
		<th><?php echo __('User Confirmed'); ?></th>
		<th><?php echo __('User Assigned'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('User Modified'); ?></th>
		<th><?php echo __('Confirmed'); ?></th>
		<th><?php echo __('Delivered'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['Order'] as $order): ?>
		<tr>
			<td><?php echo $order['id']; ?></td>
			<td><?php echo $order['group_id']; ?></td>
			<td><?php echo $order['fb_customer_id']; ?></td>
			<td><?php echo $order['fb_page_id']; ?></td>
			<td><?php echo $order['fb_post_id']; ?></td>
			<td><?php echo $order['fb_comment_id']; ?></td>
			<td><?php echo $order['total_qty']; ?></td>
			<td><?php echo $order['code']; ?></td>
			<td><?php echo $order['postal_code']; ?></td>
			<td><?php echo $order['customer_name']; ?></td>
			<td><?php echo $order['mobile']; ?></td>
			<td><?php echo $order['telco_code']; ?></td>
			<td><?php echo $order['city']; ?></td>
			<td><?php echo $order['address']; ?></td>
			<td><?php echo $order['note1']; ?></td>
			<td><?php echo $order['note2']; ?></td>
			<td><?php echo $order['cancel_note']; ?></td>
			<td><?php echo $order['shipping_note']; ?></td>
			<td><?php echo $order['is_top_priority']; ?></td>
			<td><?php echo $order['is_send_sms']; ?></td>
			<td><?php echo $order['is_inner_city']; ?></td>
			<td><?php echo $order['shipping_service_id']; ?></td>
			<td><?php echo $order['bundle_id']; ?></td>
			<td><?php echo $order['status_id']; ?></td>
			<td><?php echo $order['price']; ?></td>
			<td><?php echo $order['discount_price']; ?></td>
			<td><?php echo $order['shipping_price']; ?></td>
			<td><?php echo $order['other_price']; ?></td>
			<td><?php echo $order['total_price']; ?></td>
			<td><?php echo $order['weight']; ?></td>
			<td><?php echo $order['duplicate_id']; ?></td>
			<td><?php echo $order['duplicate_note']; ?></td>
			<td><?php echo $order['user_confirmed']; ?></td>
			<td><?php echo $order['user_assigned']; ?></td>
			<td><?php echo $order['user_created']; ?></td>
			<td><?php echo $order['user_modified']; ?></td>
			<td><?php echo $order['confirmed']; ?></td>
			<td><?php echo $order['delivered']; ?></td>
			<td><?php echo $order['created']; ?></td>
			<td><?php echo $order['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'orders', 'action' => 'view', $order['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'orders', 'action' => 'edit', $order['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'orders', 'action' => 'delete', $order['id']), array('confirm' => __('Are you sure you want to delete # %s?', $order['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Products'); ?></h3>
	<?php if (!empty($group['Product'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Alias'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Color'); ?></th>
		<th><?php echo __('Size'); ?></th>
		<th><?php echo __('Unit Id'); ?></th>
		<th><?php echo __('Bundle Id'); ?></th>
		<th><?php echo __('Made In'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['Product'] as $product): ?>
		<tr>
			<td><?php echo $product['id']; ?></td>
			<td><?php echo $product['code']; ?></td>
			<td><?php echo $product['alias']; ?></td>
			<td><?php echo $product['name']; ?></td>
			<td><?php echo $product['price']; ?></td>
			<td><?php echo $product['color']; ?></td>
			<td><?php echo $product['size']; ?></td>
			<td><?php echo $product['unit_id']; ?></td>
			<td><?php echo $product['bundle_id']; ?></td>
			<td><?php echo $product['made_in']; ?></td>
			<td><?php echo $product['user_id']; ?></td>
			<td><?php echo $product['group_id']; ?></td>
			<td><?php echo $product['created']; ?></td>
			<td><?php echo $product['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'products', 'action' => 'view', $product['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'products', 'action' => 'edit', $product['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'products', 'action' => 'delete', $product['id']), array('confirm' => __('Are you sure you want to delete # %s?', $product['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Roles'); ?></h3>
	<?php if (!empty($group['Role'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['Role'] as $role): ?>
		<tr>
			<td><?php echo $role['id']; ?></td>
			<td><?php echo $role['group_id']; ?></td>
			<td><?php echo $role['name']; ?></td>
			<td><?php echo $role['description']; ?></td>
			<td><?php echo $role['data']; ?></td>
			<td><?php echo $role['weight']; ?></td>
			<td><?php echo $role['status']; ?></td>
			<td><?php echo $role['user_created']; ?></td>
			<td><?php echo $role['created']; ?></td>
			<td><?php echo $role['modified']; ?></td>
			<td><?php echo $role['code']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'roles', 'action' => 'view', $role['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'roles', 'action' => 'edit', $role['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'roles', 'action' => 'delete', $role['id']), array('confirm' => __('Are you sure you want to delete # %s?', $role['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Shipping Services'); ?></h3>
	<?php if (!empty($group['ShippingService'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Is Default'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Url'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['ShippingService'] as $shippingService): ?>
		<tr>
			<td><?php echo $shippingService['id']; ?></td>
			<td><?php echo $shippingService['name']; ?></td>
			<td><?php echo $shippingService['group_id']; ?></td>
			<td><?php echo $shippingService['is_default']; ?></td>
			<td><?php echo $shippingService['weight']; ?></td>
			<td><?php echo $shippingService['created']; ?></td>
			<td><?php echo $shippingService['modified']; ?></td>
			<td><?php echo $shippingService['url']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shipping_services', 'action' => 'view', $shippingService['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shipping_services', 'action' => 'edit', $shippingService['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'shipping_services', 'action' => 'delete', $shippingService['id']), array('confirm' => __('Are you sure you want to delete # %s?', $shippingService['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Shipping Service'), array('controller' => 'shipping_services', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Statuses'); ?></h3>
	<?php if (!empty($group['Status'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Is Default'); ?></th>
		<th><?php echo __('Is System'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['Status'] as $status): ?>
		<tr>
			<td><?php echo $status['id']; ?></td>
			<td><?php echo $status['name']; ?></td>
			<td><?php echo $status['code']; ?></td>
			<td><?php echo $status['group_id']; ?></td>
			<td><?php echo $status['is_default']; ?></td>
			<td><?php echo $status['is_system']; ?></td>
			<td><?php echo $status['weight']; ?></td>
			<td><?php echo $status['created']; ?></td>
			<td><?php echo $status['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'statuses', 'action' => 'view', $status['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'statuses', 'action' => 'edit', $status['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'statuses', 'action' => 'delete', $status['id']), array('confirm' => __('Are you sure you want to delete # %s?', $status['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Status'), array('controller' => 'statuses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Stock Books'); ?></h3>
	<?php if (!empty($group['StockBook'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Begin At'); ?></th>
		<th><?php echo __('End At'); ?></th>
		<th><?php echo __('Is Locked'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['StockBook'] as $stockBook): ?>
		<tr>
			<td><?php echo $stockBook['id']; ?></td>
			<td><?php echo $stockBook['group_id']; ?></td>
			<td><?php echo $stockBook['code']; ?></td>
			<td><?php echo $stockBook['name']; ?></td>
			<td><?php echo $stockBook['begin_at']; ?></td>
			<td><?php echo $stockBook['end_at']; ?></td>
			<td><?php echo $stockBook['is_locked']; ?></td>
			<td><?php echo $stockBook['user_created']; ?></td>
			<td><?php echo $stockBook['created']; ?></td>
			<td><?php echo $stockBook['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'stock_books', 'action' => 'view', $stockBook['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'stock_books', 'action' => 'edit', $stockBook['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'stock_books', 'action' => 'delete', $stockBook['id']), array('confirm' => __('Are you sure you want to delete # %s?', $stockBook['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Stock Book'), array('controller' => 'stock_books', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Stock Deliverings'); ?></h3>
	<?php if (!empty($group['StockDelivering'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('No'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Delivered'); ?></th>
		<th><?php echo __('Stock Book Id'); ?></th>
		<th><?php echo __('Stock Id'); ?></th>
		<th><?php echo __('Supplier Id'); ?></th>
		<th><?php echo __('Total Qty'); ?></th>
		<th><?php echo __('Total Price'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['StockDelivering'] as $stockDelivering): ?>
		<tr>
			<td><?php echo $stockDelivering['id']; ?></td>
			<td><?php echo $stockDelivering['group_id']; ?></td>
			<td><?php echo $stockDelivering['code']; ?></td>
			<td><?php echo $stockDelivering['no']; ?></td>
			<td><?php echo $stockDelivering['description']; ?></td>
			<td><?php echo $stockDelivering['delivered']; ?></td>
			<td><?php echo $stockDelivering['stock_book_id']; ?></td>
			<td><?php echo $stockDelivering['stock_id']; ?></td>
			<td><?php echo $stockDelivering['supplier_id']; ?></td>
			<td><?php echo $stockDelivering['total_qty']; ?></td>
			<td><?php echo $stockDelivering['total_price']; ?></td>
			<td><?php echo $stockDelivering['note']; ?></td>
			<td><?php echo $stockDelivering['user_created']; ?></td>
			<td><?php echo $stockDelivering['created']; ?></td>
			<td><?php echo $stockDelivering['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'stock_deliverings', 'action' => 'view', $stockDelivering['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'stock_deliverings', 'action' => 'edit', $stockDelivering['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'stock_deliverings', 'action' => 'delete', $stockDelivering['id']), array('confirm' => __('Are you sure you want to delete # %s?', $stockDelivering['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Stock Delivering'), array('controller' => 'stock_deliverings', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Stock Receivings'); ?></h3>
	<?php if (!empty($group['StockReceiving'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('No'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Received'); ?></th>
		<th><?php echo __('Stock Book Id'); ?></th>
		<th><?php echo __('Stock Id'); ?></th>
		<th><?php echo __('Supplier Id'); ?></th>
		<th><?php echo __('Total Qty'); ?></th>
		<th><?php echo __('Total Price'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['StockReceiving'] as $stockReceiving): ?>
		<tr>
			<td><?php echo $stockReceiving['id']; ?></td>
			<td><?php echo $stockReceiving['group_id']; ?></td>
			<td><?php echo $stockReceiving['code']; ?></td>
			<td><?php echo $stockReceiving['no']; ?></td>
			<td><?php echo $stockReceiving['description']; ?></td>
			<td><?php echo $stockReceiving['received']; ?></td>
			<td><?php echo $stockReceiving['stock_book_id']; ?></td>
			<td><?php echo $stockReceiving['stock_id']; ?></td>
			<td><?php echo $stockReceiving['supplier_id']; ?></td>
			<td><?php echo $stockReceiving['total_qty']; ?></td>
			<td><?php echo $stockReceiving['total_price']; ?></td>
			<td><?php echo $stockReceiving['note']; ?></td>
			<td><?php echo $stockReceiving['user_created']; ?></td>
			<td><?php echo $stockReceiving['created']; ?></td>
			<td><?php echo $stockReceiving['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'stock_receivings', 'action' => 'view', $stockReceiving['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'stock_receivings', 'action' => 'edit', $stockReceiving['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'stock_receivings', 'action' => 'delete', $stockReceiving['id']), array('confirm' => __('Are you sure you want to delete # %s?', $stockReceiving['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Stock Receiving'), array('controller' => 'stock_receivings', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Stocks'); ?></h3>
	<?php if (!empty($group['Stock'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['Stock'] as $stock): ?>
		<tr>
			<td><?php echo $stock['id']; ?></td>
			<td><?php echo $stock['group_id']; ?></td>
			<td><?php echo $stock['code']; ?></td>
			<td><?php echo $stock['name']; ?></td>
			<td><?php echo $stock['user_created']; ?></td>
			<td><?php echo $stock['created']; ?></td>
			<td><?php echo $stock['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'stocks', 'action' => 'view', $stock['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'stocks', 'action' => 'edit', $stock['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'stocks', 'action' => 'delete', $stock['id']), array('confirm' => __('Are you sure you want to delete # %s?', $stock['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Stock'), array('controller' => 'stocks', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Suppliers'); ?></h3>
	<?php if (!empty($group['Supplier'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Note'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Tax Code'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['Supplier'] as $supplier): ?>
		<tr>
			<td><?php echo $supplier['id']; ?></td>
			<td><?php echo $supplier['group_id']; ?></td>
			<td><?php echo $supplier['name']; ?></td>
			<td><?php echo $supplier['phone']; ?></td>
			<td><?php echo $supplier['note']; ?></td>
			<td><?php echo $supplier['address']; ?></td>
			<td><?php echo $supplier['tax_code']; ?></td>
			<td><?php echo $supplier['email']; ?></td>
			<td><?php echo $supplier['user_created']; ?></td>
			<td><?php echo $supplier['created']; ?></td>
			<td><?php echo $supplier['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'suppliers', 'action' => 'view', $supplier['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'suppliers', 'action' => 'edit', $supplier['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'suppliers', 'action' => 'delete', $supplier['id']), array('confirm' => __('Are you sure you want to delete # %s?', $supplier['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Supplier'), array('controller' => 'suppliers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Units'); ?></h3>
	<?php if (!empty($group['Unit'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['Unit'] as $unit): ?>
		<tr>
			<td><?php echo $unit['id']; ?></td>
			<td><?php echo $unit['name']; ?></td>
			<td><?php echo $unit['group_id']; ?></td>
			<td><?php echo $unit['weight']; ?></td>
			<td><?php echo $unit['created']; ?></td>
			<td><?php echo $unit['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'units', 'action' => 'view', $unit['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'units', 'action' => 'edit', $unit['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'units', 'action' => 'delete', $unit['id']), array('confirm' => __('Are you sure you want to delete # %s?', $unit['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Unit'), array('controller' => 'units', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Users'); ?></h3>
	<?php if (!empty($group['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Is Group Admin'); ?></th>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('User Created'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['group_id']; ?></td>
			<td><?php echo $user['is_group_admin']; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['password']; ?></td>
			<td><?php echo $user['name']; ?></td>
			<td><?php echo $user['phone']; ?></td>
			<td><?php echo $user['address']; ?></td>
			<td><?php echo $user['data']; ?></td>
			<td><?php echo $user['weight']; ?></td>
			<td><?php echo $user['status']; ?></td>
			<td><?php echo $user['user_created']; ?></td>
			<td><?php echo $user['created']; ?></td>
			<td><?php echo $user['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), array('confirm' => __('Are you sure you want to delete # %s?', $user['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
