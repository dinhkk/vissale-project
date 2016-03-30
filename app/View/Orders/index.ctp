<div class="orders index">
	<h2><?php echo __('Orders'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fb_customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fb_page_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fb_post_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fb_comment_id'); ?></th>
			<th><?php echo $this->Paginator->sort('total_qty'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('postal_code'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_name'); ?></th>
			<th><?php echo $this->Paginator->sort('mobile'); ?></th>
			<th><?php echo $this->Paginator->sort('telco_code'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('address'); ?></th>
			<th><?php echo $this->Paginator->sort('note1'); ?></th>
			<th><?php echo $this->Paginator->sort('note2'); ?></th>
			<th><?php echo $this->Paginator->sort('cancel_note'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_note'); ?></th>
			<th><?php echo $this->Paginator->sort('is_top_priority'); ?></th>
			<th><?php echo $this->Paginator->sort('is_send_sms'); ?></th>
			<th><?php echo $this->Paginator->sort('is_inner_city'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_service_id'); ?></th>
			<th><?php echo $this->Paginator->sort('bundle_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status_id'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('discount_price'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_price'); ?></th>
			<th><?php echo $this->Paginator->sort('other_price'); ?></th>
			<th><?php echo $this->Paginator->sort('total_price'); ?></th>
			<th><?php echo $this->Paginator->sort('weight'); ?></th>
			<th><?php echo $this->Paginator->sort('duplicate_id'); ?></th>
			<th><?php echo $this->Paginator->sort('duplicate_note'); ?></th>
			<th><?php echo $this->Paginator->sort('user_confirmed'); ?></th>
			<th><?php echo $this->Paginator->sort('user_assigned'); ?></th>
			<th><?php echo $this->Paginator->sort('user_created'); ?></th>
			<th><?php echo $this->Paginator->sort('user_modified'); ?></th>
			<th><?php echo $this->Paginator->sort('confirmed'); ?></th>
			<th><?php echo $this->Paginator->sort('delivered'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($orders as $order): ?>
	<tr>
		<td><?php echo h($order['Order']['id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['group_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['fb_customer_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['fb_page_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['fb_post_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['fb_comment_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['total_qty']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['code']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['postal_code']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['customer_name']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['mobile']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['telco_code']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['city']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['address']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['note1']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['note2']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['cancel_note']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['shipping_note']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['is_top_priority']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['is_send_sms']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['is_inner_city']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['shipping_service_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['bundle_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['status_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['price']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['discount_price']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['shipping_price']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['other_price']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['total_price']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['weight']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['duplicate_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['duplicate_note']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['user_confirmed']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['user_assigned']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['user_created']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['user_modified']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['confirmed']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['delivered']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['created']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $order['Order']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $order['Order']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $order['Order']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $order['Order']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Order'), array('action' => 'add')); ?></li>
	</ul>
</div>
