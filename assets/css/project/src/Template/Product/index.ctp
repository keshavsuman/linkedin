
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a javascript::void(0);>Manage Category</a>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>

		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<div class="table-header">
						Product Management
					</div>

					<div>
						<div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="row"><div class="col-xs-6"><div class="dataTables_length" id="dynamic-table_length"><label>Display <select name="dynamic-table_length" aria-controls="dynamic-table" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> records</label></div></div><div class="col-xs-6"><div id="dynamic-table_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="dynamic-table"></label></div></div></div><table id="dynamic-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dynamic-table_info">
							<thead>
								<tr role="row">
									<th class="center sorting_disabled" rowspan="1" colspan="1" aria-label="">
										<label class="pos-rel">
											<input type="checkbox" class="ace">
											<span class="lbl"></span>
										</label>
									</th>
									<th class="sorting" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Domain: activate to sort column ascending">Product ID</th>
									<th class="sorting" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1">Image</th>
									<th class="sorting" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Domain: activate to sort column ascending">Name(HINDI)</th>
									<th class="sorting" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending">Name(ENGLISH)</th>
									<th class="sorting" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="">
										Primary price
									</th>
									<th class="sorting" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="">
										Special price
									</th>
									<th class="sorting" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="">
										Is Active
									</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($product_data as $product):
								$image = $this->request->getAttribute("webroot") ."image/". $product['pic'];
								if($product['status']==1)
								{
									$status = "Enabled";
									$label = "success";
								}
								elseif($product['status']==2)
								{
									$status = "Disabled";	
									$label = "warning";	
								}
							?>			
								<tr role="row" class="odd">
									<td class="center">
										<label class="pos-rel">
											<input type="checkbox" class="ace">
											<span class="lbl"></span>
										</label>
									</td>
									<td class="center"><a href="<?php echo $this->Url->build(['controller'=>'product','action'=>'edit','?'=>['id'=>$product['id']]])?>"><?php echo $product['id'];?></a></td>
									<td><img src="<?php echo $image;?>" style="max-width: 80px;"></td>
									<td><?php echo $product['name_hn'];?></td>	
									<td><?php echo $product['name_en'];?></td>	
									<td><?php echo $product['primary_price'];?></td>	
									<td><?php echo $product['selling_price'];?></td>	
										
									<td class="hidden-480">
										<span class="label label-sm label-<?php echo $label ?>"><?php echo $status?></span>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table><div class="row"><div class="col-xs-6"><div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">Showing 1 to 10 of 50 entries</div></div><div class="col-xs-6"><div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate"><ul class="pagination"><li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><a href="#">Previous</a></li><li class="paginate_button active" aria-controls="dynamic-table" tabindex="0"><a href="#">1</a></li><li class="paginate_button " aria-controls="dynamic-table" tabindex="0"><a href="#">2</a></li><li class="paginate_button " aria-controls="dynamic-table" tabindex="0"><a href="#">3</a></li><li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><a href="#">Next</a></li></ul></div></div></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- /.main-content -->