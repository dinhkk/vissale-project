<div style="float: left; margin-right: 20px; margin-left: 20px">
	<img style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;" src="http://graph.facebook.com/<?php echo $customer['fb_name']; ?/picture?type=normal" />
</div>
<div style="margin-left: 20px">
	<table>
		<tbody>
			<tr>
				<td colspan="2"><a></a></td>
			</tr>
			<tr>
				<td><label> Họ Tên:</label></td>
				<td><span><?php echo $customer['fb_name']; ?</span></td>
			</tr>
			<tr>
				<td><label>SĐT:</label></td>
				<td><span><?php echo $customer['phone']; ?</span></td>
			</tr>
			<tr>
				<td><label> Địa Chỉ:</label></td>
				<td><span><?php echo $customer['address']; ?</span></td>
			</tr>
		</tbody>
	</table>
</div>