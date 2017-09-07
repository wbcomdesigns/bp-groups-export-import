<?php 
$args = array( 'per_page' => 99999 );
$groups = BP_Groups_Group::get( $args );
$groups_found = $groups['total'];
if( $groups_found != 0 ) {

	/**
	 * Grab the group types, if available
	 */
	$group_types = bp_groups_get_group_types( array(), 'objects' );
	?>
	<div class="bpgei-groups-export-panel">
		<p><?php _e( 'This is the panel where you can export the groups based on the setting below. All the exported groups can then be imported using the next tab on any domain.', BPGEI_TEXT_DOMAIN );?></p>
		<table class="form-table bpgei-admin-page-table">
			<tbody>
				<!-- GROUPS STATUS -->
				<tr>
					<th scope="row"><label for="group-status"><?php _e( 'Group Status', BPGEI_TEXT_DOMAIN );?></label></th>
					<td>
						<select id="bpgei-export-groups-status" multiple>
							<option value="public"><?php _e( 'Public', BPGEI_TEXT_DOMAIN );?></option>
							<option value="private"><?php _e( 'Private', BPGEI_TEXT_DOMAIN );?></option>
							<option value="hidden"><?php _e( 'Hidden', BPGEI_TEXT_DOMAIN );?></option>
						</select>
						<p class="description"><?php _e( 'Select the status of the groups to be exported.', BPGEI_TEXT_DOMAIN );?></p>
					</td>
				</tr>

				<!-- GROUP TYPES, IF AVAILABLE -->
				<?php if( !empty( $group_types ) ) {?>
					<tr>
						<th scope="row"><label for="group-types"><?php _e( 'Group Types', BPGEI_TEXT_DOMAIN );?></label></th>
						<td>
							<select id="bpgei-export-group-types" multiple>
								<?php foreach( $group_types as $slug => $group_type ) {?>
									<option value="<?php echo $slug;?>"><?php echo $group_type->labels['name'];?></option>
								<?php }?>
							</select>
							<p class="description"><?php _e( 'Select the group types of the groups to be exported.', BPGEI_TEXT_DOMAIN );?></p>
						</td>
					</tr>
				<?php }?>
			</tbody>
		</table>
		<p class="submit">
			<div id="dvjson"></div>
			<button type="button" id="bpgei-export-bp-groups" class="button button-primary"><?php _e( 'Export', BPGEI_TEXT_DOMAIN );?></button>
		</p>
	</div>
<?php } else {?>
	<div class="bpgei-groups-export-panel">
		<div class="bpgei-no-groups-available">
			<p><?php _e( 'Sorry, no groups to export!', BPGEI_TEXT_DOMAIN );?></p>
		</div>
	</div>
<?php }?>