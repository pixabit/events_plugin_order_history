<?php global $wpdb; ?>
<div id="wpbody" role="main">
	<div id="wpbody-content" aria-label="Main content" tabindex="0">
		<div class="wrap">
			<div class="cust-header">
				<form action="?page=passed-event-list" id="posts-filter" method="post">
				<p class="search-box">
					<label class="screen-reader-text" for="post-search-input">Search Events:</label>
					<input type="search" id="stext" name="stext" value="">
					<input type="submit" name="submit" id="submit" class="button" value="Search Events">
				</p>
				</form>
				<form action="?page=passed-event-list" id="month-filter" method="post">
					<p class="search-box">
					<select id="ddlMonth" name="ddlMonth">
					<option selected value="">Select Month</option>
					<?php 
					$mquery = "SELECT p.ID, DATE_FORMAT(pm.meta_value,'%Y-%m') AS created_month FROM ece_posts as p INNER JOIN ece_postmeta pm ON p.ID = pm.post_id WHERE p.post_type = 'tribe_events' AND p.post_status = 'publish' AND pm.meta_key='_EventStartDate' GROUP BY created_month ORDER BY created_month DESC LIMIT 0, 12";

					$mresult = $wpdb->get_results($mquery);
					foreach($mresult as $gmet_results){	

						$id = $gmet_results->ID;
						$getstart = get_post_meta($id,'_EventStartDate',true); 
						$getdate = date('Y-m', strtotime($getstart));
						$getdateformat = date('F, Y', strtotime($getstart));

						if (!empty($_POST['ddlMonth']) && $_POST['ddlMonth'] == $getdate) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}

						echo '<option '.$selected.' value="' .$getdate. '">' . $getdateformat . ' </option>';
					}	
					?>		
					</select>
					<input type="submit" id="filtermonth" name="filtermonth" class="button action" value="Apply">
				</p>
				</form>
			</div><!-- cust-header -->
					<?php
					$today = date('Y-m-d');
					$where = '';

					if ( isset($_POST['submit']) || $_GET['searchtype']=='text') {

						$searchtype = "text";

						if(!empty($_POST['stext'])){
							$stext = $_POST['stext'];
						}
						if(!empty($_GET['search'])){
							$stext = $_GET['search'];
						}

						$where = 'p.post_type = "tribe_events" AND p.post_status = "publish" AND pm.meta_key="_EventStartDate" AND pm2.meta_key="_EventEndDate" AND pm.meta_value < "'.$today.'" AND pm2.meta_value < "'.$today.'" AND p.post_title LIKE "%'.$stext.'%"';

					}elseif ( isset($_POST['filtermonth']) || $_GET['searchtype']=='month') {
						$searchtype = "month";

						if(!empty($_POST['ddlMonth'])){
							$stext = $_POST['ddlMonth'];
						}
						if(!empty($_GET['search'])){
							$stext = $_GET['search'];
						}

						$where = 'p.post_type = "tribe_events" AND p.post_status = "publish" AND pm.meta_key="_EventStartDate" AND pm2.meta_key="_EventEndDate" AND pm.meta_value < "'.$today.'" AND pm2.meta_value < "'.$today.'"  AND DATE_FORMAT(pm.meta_value,"%Y-%m") LIKE "%'.$stext.'%"';

					}else{
						$searchtype = "all";
						$stext = "all";
						$where = 'p.post_type = "tribe_events" AND p.post_status = "publish" AND pm.meta_key="_EventStartDate" AND pm2.meta_key="_EventEndDate" AND pm.meta_value < "'.$today.'" AND pm2.meta_value < "'.$today.'"';

					}	

					$query3 = "SELECT p.ID, p.post_title, pm.post_id, pm.meta_value as start_date, pm2.meta_value as end_date FROM ece_posts as p INNER JOIN ece_postmeta pm ON p.ID = pm.post_id INNER JOIN ece_postmeta pm2 ON pm.post_id=pm2.post_id WHERE ".$where." ORDER BY pm2.meta_value DESC"; 

					$result2 = $wpdb->get_results($query3);

						$limit = 20; 
						if (isset($_GET["paged"])){
						 $paged  = $_GET["paged"]; 
						 $start_from = ($paged-1) * $limit;  
						}else{
						 $start_from = 0;	
						 $paged = 1;
						};
					$total_records = $wpdb->num_rows;	

					$query2 = "SELECT p.ID, p.post_title, pm.post_id, pm.meta_value as start_date, pm2.meta_value as end_date FROM ece_posts as p INNER JOIN ece_postmeta pm ON p.ID = pm.post_id INNER JOIN ece_postmeta pm2 ON pm.post_id=pm2.post_id WHERE ".$where." ORDER BY pm2.meta_value DESC LIMIT ".$start_from.", ".$limit.""; 

					$result = $wpdb->get_results($query2);
					
					?>
					<h1 class="wp-heading-inline">Old Events List</h1>
					<?php
					if(!empty($total_records)){
				        $total_pages = ceil($total_records / $limit);  
				        ?>
				      <div class='ext-nav'><span class='t_no'><?php echo $total_records.' items'; ?></span><ul class='pagination'>
				        <?php for ($i=1; $i<=$total_pages; $i++) {  ?>
				             <li class='<?php 
				             if($i==$_GET['active']){ echo "active"; }?>'><a href='/ece/wp-admin/admin.php?page=passed-event-list&paged=<?php echo $i; ?>&searchtype=<?php echo $searchtype ?>&search=<?php echo $stext ?>&active=<?php echo $i; ?>'><?php echo $i; ?></a></li>
				        <?php }; ?>
				       </ul></div>
			    	<?php }
					?>
					<hr class="wp-header-end">

					<table class="wp-list-table widefat fixed striped posts">
						<thead><tr><th>No.</th><th>Event Name</th><th>Start Date</th><th>End Date</th></tr></thead>
						<tbody id="the-list">
						<?php if(empty($total_records)){ ?>
						<tr class="no-items"><td class="colspanchange" colspan="4">No events found</td></tr>
						<?php } ?>
						<?php 
						$count = 1;
						foreach($result as $get_results){
						echo '<tr>';
						$id = $get_results->ID;
						$post_url = admin_url( 'post.php?post='.$id).'&action=edit';
						?>
						<td><?php echo $count; ?></td>
						<td><a rel="<?php echo $post->post_title; ?>" href="<?php echo $post_url; ?>"><?php echo $get_results->post_title; ?></a></td>
						<td><?php $getstart = get_post_meta($id,'_EventStartDate',true); 
							echo date('j F, Y', strtotime($getstart)); ?></td>
							<td><?php $getend =  get_post_meta($id,'_EventEndDate',true);
								echo date('j F, Y', strtotime($getend)); ?></td>
								<?php 
								echo '</tr>';
								$count++; ?>
								<?php } ?>
						</tbody>		
						<tfoot><tr><th>No.</th><th>Event Name</th><th>Start Date</th><th>End Date</th></tr></tfoot>
					</table>
					<?php
					if(!empty($total_records)){
				        $total_pages = ceil($total_records / $limit);  
				        ?>
				      <div class='ext-nav'><span class='t_no'><?php echo $total_records.' items'; ?></span><ul class='pagination'>
				        <?php 
						for ($i=1; $i<=$total_pages; $i++) {  ?>
				             <li class='<?php 
				             if($i==$_GET['active']){ echo "active"; }?>'><a href='/ece/wp-admin/admin.php?page=passed-event-list&paged=<?php echo $i; ?>&searchtype=<?php echo $searchtype ?>&search=<?php echo $stext ?>&active=<?php echo $i; ?>'><?php echo $i; ?></a></li>
				        <?php }; ?>
				       </ul></div>
			    	<?php }
					?>
			
			<!-- </form> -->
		</div>
	</div>
</div>
