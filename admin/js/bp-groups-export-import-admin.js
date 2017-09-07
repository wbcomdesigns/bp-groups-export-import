jQuery(document).ready(function( $ ) {
	'use strict';

	//Support Tab
	var acc = document.getElementsByClassName("bpgei-accordion");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].onclick = function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.maxHeight){
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			} 
		}
	}

	$(document).on('click', '.bpgei-accordion', function(){
		return false;
	});

	$('#bpgei-export-groups-status').selectize({
		placeholder		: "Select group status",
		plugins			: ['remove_button'],
	});
	$('#bpgei-export-group-types').selectize({
		placeholder		: "Select group types",
		plugins			: ['remove_button'],
	});

	/** 
	 * Export Groups
	 */
	$(document).on('click', '#bpgei-export-bp-groups', function(e){
		var btn = $(this);
		var btn_txt = $(this).html();
		var g_status = $('#bpgei-export-groups-status').val();
		var g_types = $('#bpgei-export-group-types').val();
		btn.html( '<i class="fa fa-refresh fa-spin"></i>  Exporting...' );
		var data = {
			'action'	: 'bpgei_export_groups',
			'g_status'	: g_status,
			'g_types'	: g_types
		}
		$.ajax({
			dataType: "JSON",
			url: bpgei_admin_js_object.ajaxurl,
			type: 'POST',
			data: data,
			success: function( response ) {
				console.log(response['data']['message']);
				console.log(response['data']['groups_exported']);
				btn.html( '<i class="fa fa-check"></i>  Export Success!' );
				var groups = response['data']['groups'];
				$("#dvjson").excelexportjs({
					containerid: "dvjson",
					datatype: 'json',
					dataset: groups,
					columns: getColumns( groups )
				});
			}
		});
	});
});
