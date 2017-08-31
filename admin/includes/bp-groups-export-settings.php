<?php 
$args = array( 'per_page' => 99999 );
$groups = BP_Groups_Group::get( $args );
$groups_found = $groups['total'];
if( $groups_found != 0 ) {?>
	<table class="form-table bpgei-admin-page-table">
		<tbody>
			<!-- GROUPS STATUS -->
			<tr>
				<th scope="row"><label for="group-status"><?php _e( 'Group Status', BPGEI_TEXT_DOMAIN );?></label></th>
				<td>
					<select id="bpgei-export-groups-status">
						<option value=""><?php _e( '--Select--', BPGEI_TEXT_DOMAIN );?></option>
						<option value="public"><?php _e( 'Public', BPGEI_TEXT_DOMAIN );?></option>
						<option value="private"><?php _e( 'Private', BPGEI_TEXT_DOMAIN );?></option>
						<option value="hidden"><?php _e( 'Hidden', BPGEI_TEXT_DOMAIN );?></option>
					</select>
					<p class="description"><?php _e( 'Select the status of the groups to be exported.', BPGEI_TEXT_DOMAIN );?></p>
				</td>
			</tr>

			<!-- GROUP TYPES -->
			<tr>
				<th scope="row"><label for="group-types"><?php _e( 'Group Types', BPGEI_TEXT_DOMAIN );?></label></th>
				<td>
					<select id="bpgei-export-group-types">
						<option value=""><?php _e( '--Select--', BPGEI_TEXT_DOMAIN );?></option>
						<option value="public"><?php _e( 'Public', BPGEI_TEXT_DOMAIN );?></option>
						<option value="private"><?php _e( 'Private', BPGEI_TEXT_DOMAIN );?></option>
						<option value="hidden"><?php _e( 'Hidden', BPGEI_TEXT_DOMAIN );?></option>
					</select>
					<p class="description"><?php _e( 'Select the group types of the groups to be exported.', BPGEI_TEXT_DOMAIN );?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<button type="button" name="bpgei-export-bp-groups" class="button button-primary"><?php _e( 'Export', BPGEI_TEXT_DOMAIN );?></button>
	</p>
<?php } else {?>
	<div class="bpgei-no-groups-available">
		<p><?php _e( 'Sorry, no groups to export!', BPGEI_TEXT_DOMAIN );?></p>
	</div>
<?php }?>