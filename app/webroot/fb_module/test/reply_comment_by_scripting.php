<?php

function replyCommentByScripting($comment, $comment_time)
{
    $list_scripting = array(
	        'address'=>array(
	            'pattern'=>'ở đâu,địa chỉ,chỗ nào,cửa hàng,đường nào,khúc nào',
	            'reply' => 'Mời bạn ghé thăm BỤI tại:
                        CS1 : 462/1 CMT8, F11, Q3, HCM
                        CS2 : 31 Đông Các, Đống Đa, HN
                        CS3 : 59 Khương Thượng, Đống Đa, HN
                        CS4: 41/41 Thái Hà, Đống Đa, HN'
	        ),
// 	        'price'=>array(
// 	            'pattern'=>'giá,bao nhiêu,tiền,bao nhiu',
// 	            'reply'=>'Noi dung tra loi'
// 	        ),
// 	        'product_detail'=>array(
// 	            'pattern'=>'màu,size,chất lượng,nặng,to',
// 	            'reply'=>'Noi dung tra loi'
// 	        ),
// 	        'transport'=>array(
// 	            'pattern'=>'ship,vận chuyển,nội thành,ngoại thành',
// 	            'reply'=>'Noi dung tra loi'
// 	        ),
// 	        'out_of_work_time'=>array(
// 	            'start'=>'08:01',
// 	            'end'=>'18:01',
// 	            'reply'=>'Noi dung tra loi'
// 	        ),
	    );
	    //$list_scripting = json_decode($this->config['reply_by_scripting'], true);
    	if ($comment_time && isset($list_scripting['out_of_work_time'])){
            $comment_time = strtotime($comment_time);
            $comment_hours = date('H:i', $comment_time);
            // KB 1: ngoai gio lam viec
            if ($out_of_work_time = $list_scripting['out_of_work_time']) {
                if ($out_of_work_time['start'] < $comment_time || $comment_time > $out_of_work_time['end']) {
                    return $out_of_work_time['reply'];
                }
            }
        }
        foreach ($list_scripting as $type => $scripting){
            if ($type=='out_of_work_time'){
                continue;
            }
            $pattern = explode(',', $scripting['pattern']);
            foreach ($pattern as $p){
                if (mb_strpos($comment, $p) !==false){
                    return $scripting['reply'];
                }
            }
        }
        return false;
}

var_dump(replyCommentByScripting('cửa hàng ở đâu vậy?', null));