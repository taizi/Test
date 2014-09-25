<?php include_once './App/Tpl/Public/iframe_header.php';?>
<form  id="edit_form" method="post">
<input name="pos[id]" type="hidden" value="<?php echo $row['id'];?>">
<fieldset class="fieldset">
<legend>编辑价格</legend>
<dl><label>渠道：</label><select name="pos[delivery_id]" id="delivery_id" class="inp200" >
          <?php 
            if($delivery){
            foreach ($delivery as $v){ ?>
		  <option value="<?php echo $v['id'];?>" <?php if($row['delivery_id']==$v['id']){ echo 'selected'; }?>><?php echo $v['name'];?></option>
		<?php } }?>
		  </select></dl>
<dl style="height:auto;"><label>公司：</label><select name="pos[company_id]" id="company_id" class="inp200" >
          <?php 
            if(!empty($company)){
            foreach ($company as $v){ ?>
		  <option value="<?php echo $v['id'];?>" <?php if($row['company_id']==$v['id']){ echo 'selected'; }?>><?php echo $v['name'];?></option>
		<?php } }?>
		  </select>
</dl>		  
<dl style="height:auto;"><label>地区：</label><select name="pos[area_id]" id="area_id" class="inp200" >
          <?php 
            if(!empty($areas)){
            foreach ($areas as $v){ ?>
		  <option value="<?php echo $v['area_id'];?>" <?php if($row['area_id']==$v['area_id']){ echo 'selected'; }?>><?php echo $v['area_name'];?></option>
		<?php } }?>
		  </select>
			</dl>
<dl><label>首重金额：</label><input name="pos[price]" id="price" type="text" class="inp200" value="<?php echo $row['price'];?>" /></dl>
<dl><label>续重金额：</label><input name="pos[replenish]" id="replenish" type="text" class="inp200" value="<?php echo $row['replenish'];?>" /></dl>
<dl style="height:30px;"><label class="float">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a onclick="savePrice()" class="btn_blue float" href="javascript:;">保存 </a></dl>
</fieldset>
</form>
<script type="text/javascript">
function savePrice(){
	if($("#edit_form #delivery_id").attr("value")==''){
		alert('请选择配送方式');
        return false;
    }
	if($("#edit_form #company_id").attr("value")==''){
		alert('请选择配送公司');
        return false;
    }
	if($("#edit_form #area_id").attr("value")==''){
		alert('请选择配送地区');
        return false;
    }
	if($("#edit_form #price").attr("value")==''){
		alert('请输入首重金额');
        return false;
    }
	if($("#edit_form #replenish").attr("value")==''){
		alert('请输入续重金额');
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