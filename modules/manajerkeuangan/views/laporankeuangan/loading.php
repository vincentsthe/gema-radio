
<div class='alert alert-info'>
	<h3>Loading ...</h3>
</div>
<?php
$this->registerJs('$.get(\''.$ajax_url.'\',function(data){
	$("html").html(data);
})',self::POS_READY);
?>
