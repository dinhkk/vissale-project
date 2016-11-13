<div style="float: left; margin-right: 20px; margin-left: 20px">
	<img id="customerImg"
		 style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
		 src="https://graph.facebook.com/<?php echo $customer['FBCustomers']['fb_id']; ?>/picture?type=normal"/>
</div>
<div style="margin-left: 20px">
	<table>
		<tbody>
			<tr>
				<td colspan="2"><a></a></td>
			</tr>
			<tr>
				<td><label> Họ Tên:</label></td>
				<td><span id="customerName"><?php echo $customer['FBCustomers']['fb_name']; ?></span></td>
			</tr>
			<tr>
				<td><label>SĐT:</label></td>
				<td><span id="customerPhone"><?php echo $customer['FBCustomers']['phone']; ?></span></td>
			</tr>
			<tr>
				<td><label> Địa Chỉ:</label></td>
				<td><span id="customerAddr"><?php echo $customer['FBCustomers']['address']; ?></span></td>
			</tr>
		</tbody>
	</table>
</div>