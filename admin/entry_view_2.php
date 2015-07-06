<table class="table table-striped table-bordered">
					<tr>
						<th colspan="2"><h3><?php _e('Parent/Gardian Details'); ?></h3></th>
					</tr>
					<tr>
						<th><?php _e('Name'); ?></th>
						<td><?php echo $entry->parent_name; ?></td>
					</tr>
					<tr>
						<th><?php _e('Email'); ?></th>
						<td><a href="mailto:<?php echo $entry->email; ?>"><?php echo $entry->email; ?></a></td>
					</tr>
					<tr>
						<th><?php _e('Birthdate'); ?></th>
						<td><?php echo $entry->parent_dob; ?></td>
					</tr>
					<tr>
						<th colspan="2"><h3><?php _e('Mailing Address'); ?></h3></th>
					</tr>
					<tr>
						<th><?php _e('Address'); ?></th>
						<td><?php echo $entry->address; ?></td>
					</tr>
					<tr>
						<th><?php _e('City'); ?></th>
						<td><?php echo $entry->city; ?></td>
					</tr>
					<tr>
						<th><?php _e('State'); ?></th>
						<td><?php echo $entry->state; ?></td>
					</tr>
					<tr>
						<th><?php _e('Zip'); ?></th>
						<td><?php echo $entry->zip; ?></td>
					</tr>
					<tr>
						<th colspan="2"><h3><?php _e("Children Information"); ?></h3></th>
					</tr>
					<tr>
						<td colspan="2">
							<table class="table table-striped table-bordered">
								<tr>
									<th><?php _e('Name'); ?></th>
									<th><?php _e('Birthdate'); ?></th>
								</tr>
						<?php $children_array = unserialize($entry->children);
 							  foreach($children_array as $child){ ?>
								<tr>
									<td><?php echo $child['name']; ?></td>
									<td><?php echo $child['dob']; ?></td>
								</tr>		
							<?php } ?>						
							</table>
						</td>
					</tr>
					<tr>
						<th><?php _e('Status'); ?></th>
						<td><?php if($entry->confirm_status == 1) { echo 'Verified and Confirmed'; } else { echo 'Not Verified'; } ?></td>
					</tr>
				</table>
