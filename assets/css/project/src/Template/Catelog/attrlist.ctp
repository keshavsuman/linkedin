<?php

   foreach($attrlist as $style){  $style_id=$style['id'];  ?>
											             
													<option value="<?php echo $style_id;?>"><?php echo $style['frontend_label']; ?></option>
<?php } ?>
