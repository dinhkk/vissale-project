<div class="orders index">
	<h2><?php echo __('Orders'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('total_qty'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('postal_code'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_name'); ?></th>
			<th><?php echo $this->Paginator->sort('mobile'); ?></th>
			<th><?php echo $this->Paginator->sort('telco_code'); ?></th>
			<th><?php echo $this->Paginator->sort('address'); ?></th>
			<th><?php echo $this->Paginator->sort('note1'); ?></th>
			<th><?php echo $this->Paginator->sort('cancel_note'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_note'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_service_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status_id'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('total_price'); ?></th>
			<th><?php echo $this->Paginator->sort('duplicate_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_confirmed'); ?></th>
			<th><?php echo $this->Paginator->sort('user_assigned'); ?></th>
			<th><?php echo $this->Paginator->sort('confirmed'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($orders as $order): var_dump($order); die(); ?>
	<tr>
		<td><?php echo h($order['Orders']['total_qty']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['code']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['postal_code']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['customer_name']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['mobile']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['telco_code']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['address']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['note1']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['cancel_note']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['shipping_note']); ?>&nbsp;</td>
		<?php foreach($shipping_services as $ship) {
			if($ship['ShippingServices']['id']==$order['Orders']['shipping_service_id']) {
		?>
			<td><?php echo h($ship['ShippingServices']['name']); ?>&nbsp;</td>
		<?php } else { ?>
			<td></td>
		<? } ?>
		<?php foreach($statuses as $status) {
			if($status['Statuses']['id']==$order['Orders']['status_id']) {
		?>
			<td><?php echo h($status['Statuses']['name']); ?>&nbsp;</td>
		<?php } else { ?>
			<td></td>
		<? } ?>
		<td><?php echo h($order['Orders']['price']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['total_price']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['duplicate_id']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['user_confirmed']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['user_assigned']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['confirmed']); ?>&nbsp;</td>
		<td><?php echo h($order['Orders']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $order['Orders']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $order['Orders']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $order['Orders']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $order['Orders']['id']))); ?>
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
