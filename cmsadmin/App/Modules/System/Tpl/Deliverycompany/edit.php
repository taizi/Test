<?php include_once './App/Tpl/Public/iframe_header.php';?>
<script type="text/javascript" src="/Public/My97DatePicker/WdatePicker.js"></script>
<form  id="edit_form" method="post">
<input name="pos[id]" id="id" type="hidden" value="<?php echo $row['id'];?>">	
<fieldset class="fieldset"> 
<legend>修改</legend>
<dl><label>名称：</label><input name="pos[name]" id="name" type="text" class="inp200" value="<?php echo $row['name'];?>" /></dl>
<dl><label>付款周期：</label><input name="pos[payment_time]" id="payment_time" type="text" class="inp200" value="<?php echo $row['payment_time'];?>" />天</dl>
<dl><label>日最大配送：</label><input name="pos[maxbyday]" id="maxbyday" type="text" class="inp200" value="<?php echo $row['maxbyday'];?>" />单</dl>
<dl><label>首重：</label><input name="pos[firstweight]" id="firstweight" type="text" class="inp200" value="<?php echo $row['firstweight'];?>" />g</dl>
<dl><label>续重：</label><input name="pos[secondweight]" id="secondweight" type="text" class="inp200" value="<?php echo $row['secondweight'];?>" />g</dl>
<dl><label>发货时间：</label><input name="pos[delivery_time]" id="delivery_time" type="text" class="inp200" value="<?php echo date("Y-m-d H:i:s",$row['delivery_time']);?>" onfocus="WdatePicker({doubleCalendar:false,dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly /></dl>
<dl><label>查询地址：</label><input name="pos[inquiryurl]" id="inquiryurl" type="text" class="inp200" value="<?php echo $row['inquiryurl'];?>" /></dl>
<dl><label>联系人：</label><input name="pos[contact_person]" id="contact_person" type="text" class="inp200" value="<?php echo $row['contact_person'];?>" /></dl>
<dl><label>联系电话：</label><input name="pos[phone]" id="phone" type="text" class="inp200" value="<?php echo $row['phone'];?>" /></dl>
<dl id="sel_type_link"><label>说明：</label>
<textarea name="pos[remark]" id="remark" cols="" rows="" class="inp200" style="height:60px;"><?php echo $row['remark'];?></textarea>
<dl style="height:30px;"><label class="float">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a onclick="savecompany()" class="btn_blue float" href="javascript:;">保存 </a></dl>
</fieldset>
</form>

<script>
function savecompany(){
	if($("#edit_form #name").attr("value")==''){
		alert('请输入名称');
        return false;
    }
	if(new RegExp($('#payment_time').val()).test('^-?[0-9]*\\.[0-9]*$')){
		alert('请输入数值型付款周期');
        return false;
	}
	if(new RegExp($('#maxbyday').val()).test('^-?[0-9]*\\[0-9]*$')){
		alert('请输入数值型日最大配送量');
        return false;
	}
	if(new RegExp($('#firstweight').val()).test('^-?[0-9]*\\[0-9]*$')){
		alert('请输入数值型首重');
        return false;
	}
	if(new RegExp($('#secondweight').val()).test('^-?[0-9]*\\[0-9]*$')){
		alert('请输入数值型续重');
        return false;
	}
	if($('#delivery_time').val()==''){
		alert('请选择发货时间');
        return false;
	}
	if($("#edit_form #remark").attr("value")==''){
		alert('请输入说明');
        return false;
    }
	$.ajax({
        type: "POST",
	    url: "<?php echo __URL__.'/edit';?>",
	    data:$("#edit_form").serialize(),
	     dataType:'json',
	    success: function(ref){
         if(ref.status<1){
             alert(ref.info);
         }else{
        	 parent.window.location.reload();
	     }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
          alert(XMLHttpRequest.status);
          alert(XMLHttpRequest.readyState);
          alert(textStatus);
      }
   });
}
</script>
<?php include_once './App/Tpl/Public/iframe_footer.php';?>