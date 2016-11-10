var showmenu = 0;
var ajaxRequest = '';
$(function() {
	$('.mki_header_back, .mki_news_ticker_back').css({opacity:.6});
	$('.mki_app_menu').css({opacity:.9});
	$('.mki_app_menu').css({top:$('.mki_app_menu').outerHeight()*-1});
	$('#mki_right_content_petatematik').css({right:0});
	$('.mki_quick_search').css({opacity:.95});
	$('#mki_active_right').val('mki_right_content_petatematik');
 
	$(window).resize(function() {
		$('.mki_right_content').css({height:$(window).height()-$('.mki_header_front').outerHeight()-60});
		$('.mki_right_content_data').css({height:$(window).height()-$('.mki_header_front').outerHeight()-100});
		$('.mki_map_area').css({height:$(window).height()-$('.mki_header_front').outerHeight()-40});
		$('#mki_map_view').css({height:$(window).height()-$('.mki_header_front').outerHeight()-60, width:$(window).width()-$('.mki_right_content').outerWidth()-20});
		$('.mki_left_content').css({height:$('.mki_right_content').outerHeight(), width:$(window).width()-$('.mki_right_content').outerWidth()});
		//$('#mki_map_view').css({position:absolute});
		//$('#mki_content_responden, #mki_content_dashboard').css({width:$(window).width()-40});
		$('#mki_quick_search_result').css({height:($('.mki_left_content').outerHeight()-$('#mki_form_quick_search').outerHeight())});
	});

	$('.mki_app_logout').hover(function() {
		$(this).addClass('mki_app_logout_hover');
	}, function() {
		$(this).removeClass('mki_app_logout_hover');
	});
	$('.mki_app_logout').click(function() {
		window.location.href=base_url+'auth/logout';
	});


	$('.mki_menu_arrow').hover(function() {
		$(this).css({'background-color':'#999'});
	}, function() {
		$(this).css({'background-color':'#888'});
	});

	$('.mki_app_menu ul').hover(function() { }, function() {
		showmenu = 0;
		$('.mki_app_menu').stop().animate({top:$('.mki_app_menu').outerHeight()*-1});
	});

	$('.mki_app_menu ul li').hover(function() {
		$(this).stop().animate({'padding-left':25}, 300);
		$(this).addClass('mki_app_menu_hover');
	},function() {
		$(this).stop().animate({'padding-left':20}, 200);
		$(this).removeClass('mki_app_menu_hover');
	});

	$('.mki_app_menu ul li').click(function() {
		$('.mki_app_menu_selected').each(function() {
			$(this).removeClass('mki_app_menu_selected');
		});
		$(this).addClass('mki_app_menu_selected');
		var thisname = $(this).find('span').html();
		var thisicon = $(this).find('i').attr('class');

		$('.mki_menu_current_icon').html('<i class="'+thisicon+'"></i>');
		$('.mki_menu_current_name').html(thisname);

		var showcontent = $(this).attr('ref');
		var activeright = $('#mki_active_right').val();

		//load content
		if(showcontent=='pemetaan') {
			onMapClick(activeright);
		} else if(showcontent=='pengaturan') {
			onSettingsClick(activeright);
		} else if(showcontent=='petatematik') {
			onTematikClick(activeright);
		}

		//hide menu
		showmenu = 0;
		$('.mki_app_menu').stop().animate({top:$('.mki_app_menu').outerHeight()*-1});
	});

	$('.mki_menu_arrow').click(function() {
		if(showmenu==0) {
			showmenu = 1;
			$('.mki_app_menu').stop().animate({top:70});
		} else {
			showmenu = 0;
			$('.mki_app_menu').stop().animate({top:$('.mki_app_menu').outerHeight()*-1});
		}
	});


	$('#mki_close_responden_detail').click(function() {
		closeRespondenDetail();
	});
	$('#mki_close_responden_edit').click(function() {
		closeRespondenEdit();
	});
	$('#mki_close_survey_edit').click(function() {
		closeSurveyEdit();
	});
	$('#mki_close_option_add').click(function() {
		closeOptionAdd();
	});
	$('#mki_close_pengguna_add').click(function() {
		closeUserAdd();
	});
	$('#mki_close_responden_add').click(function() {
		closeRespondenAdd();
	});

	

	$('.mki_right_list_menu ul li').hover(function() {
		$(this).addClass('mki_right_list_menu_hover');
	}, function() {
		$(this).removeClass('mki_right_list_menu_hover');
	});

	$('.mki_right_list_menu ul li').click(function() {
		closeOptionAdd();
		$('.mki_right_list_menu_selected').each(function() {
			$(this).removeClass('mki_right_list_menu_selected');
		});

		//clear rekap
		$('#mki_btn_custom_recap_clear').hide();
		$('#mki_btn_custom_recap').show();
		$('#mki_custom_item_active').val(0);
		$('#mki_btn_summary_recap').show();
		$('#mki_custom_item').val('-');
		$('#mki_right_custom_recap_list').empty();
		$('.mki_filter_quiz_item').removeAttr('disabled');
		$('#mki_filter_quiz').show();
		$('#mki_right_custom_recap').hide();

		$(this).addClass('mki_right_list_menu_selected');
		var thisid = $(this).attr('id');
		var rw_selected = $('#mki_filter_rw').val();
		thisid = thisid.replace('mki_rekap_','');
		$('#mki_right_list_menu_inload').val(thisid);
		var rwname = $('#rw_'+rw_selected).text();
		rwname = (rw_selected=='nol')?'':' '+rwname;
		$('#mki_preload_rekap div').html('<div class="win-ring small"></div> Menghitung data '+$(this).html()+' semua responden'+rwname+'...');

		$('#mki_preload_rekap').show();
		$('#mki_loaded_rekap').hide();
		ajaxGetRekap('rekap', thisid, rw_selected);
	});

	$('.mki_right_petatematik_menu ul li').hover(function() {
		$(this).addClass('mki_right_petatematik_menu_hover');
	}, function() {
		$(this).removeClass('mki_right_petatematik_menu_hover');
	});
	
	$('.mki_right_petatematik_menu ul li').click(function() {
		closeOptionAdd();
		$('.mki_right_petatematik_menu_selected').each(function() {
			$(this).removeClass('mki_right_petatematik_menu_selected');
		});

		$(this).addClass('mki_right_petatematik_menu_selected');
		var thisid = $(this).attr('id');	
		thisid = thisid.replace('mki_tematik_','');
		$('#mki_right_petatematik_menu_inload').val(thisid);
		//alert(thisid);
		AddTematik('1',thisid);
	});

	

	$(window).resize();

	$('.mki_site_logo').hover(function() {
		$(this).css({'background-color': '#ffffff'});
	},function() {
		$(this).css({'background-color': '#f5f5f5'});
	});
	$('.mki_site_logo').click(function() {
		window.location.href='';
	});

	$('#mki_quick_search').keyup(function(e) {
		var code = e.keyCode || e.which;
		if(code==13) {
			showQuickSearch();
		}
	});

	$('#mki_quick_search_rw').change(function() {
		showQuickSearch();
	});

	$('#mki_close_quick_search').click(function() {
		//$('#mki_quick_search_result').empty();
		$('#mki_quick_search').val('');
		$('#mki_close_quick_search').fadeOut(500);
		$('.mki_quick_search_list').show();
		setTimeout(function() { $('#mki_quick_search').animate({'width':'280px'}, 500); }, 600);
		clearAllMarkers();
		onMapClick();
	});

});

function closeRespondenDetail() {
	$('#mki_content_responden_detail').fadeOut();
}
function closeRespondenEdit() {
	$('#mki_content_responden_edit').fadeOut();
}
function closeSurveyEdit() {
	$('#mki_content_survey_edit').fadeOut();
}
function closeOptionAdd() {
	$('#mki_content_kuisoner_option_add').fadeOut();
}
function closeUserAdd() {
	$('#mki_content_add_pengguna').fadeOut();
}
function closeRespondenAdd() {
	$('#mki_content_add_responden').fadeOut();
}



function showQuickSearch() {
	var rws = $('#mki_quick_search_rw').val();
	var kw = $('#mki_quick_search').val();
	//alert(rws); alert(kw);
	if(kw!='') {
		$.ajax({
			type  : 'post',
			url   : base_url+'map/quick_search/'+rws,
			data  : 'qs='+kw,
			cache : false,
			success: function(datas) {
				var data = $.parseJSON(datas);
				$('#mki_quick_search').animate({'width':'238px'}, 500);
				setTimeout(function() { $('#mki_close_quick_search').fadeIn(); }, 600);
				$('.mki_quick_search_list').hide();
				for(var i=0; i<pid.length; i++) {
					markers[pid[i]].setMap(null);
				}
				if(data.status) {
					//$('#mki_quick_search_result').empty();
					//var bounds = new google.maps.LatLngBounds();
					for(var i=0; i<data.responden.length; i++) {
					    // showMarkers(map,asets,tematik)
						var kdbarang = data.responden[i]['kd_brg'];
						var catikon = 'markers/'+kdbarang.substr(0,6)+'.png';
						showMarker(map, data.responden[i],catikon);
						//markers['rid_'+data.responden[i].data_id].setMap(map);
						//bounds.extend(markers['rid_'+data.responden[i].data_id].getPosition());
						$('#mki_quick_search_result').append('<div class="mki_quick_search_list"><i class="icon-target-2" style="font-size:12px;cursor:pointer;" onClick="showRespondenMap('+data.responden[i].data_id+')"></i> <span style="cursor: pointer;" onClick="showRespondenDetil('+data.responden[i].data_id+');">'+data.responden[i].no_reg+'</span></div>');
						$('#mki_quick_search_list_'+data.responden[i].data_id).show();
					}
					//map.fitBounds(bounds);

				} else {

					$('#mki_quick_search_result').html('<center><br/>Data responden dengan kata kunci <i>"<b>'+kw+'</b>"</i> tidak ditemukan, silahkan masukkan kata kunci yang lain!</center>');
					
				}
			}
		});
	}
}

function showRespondenMap(r_id) {
	$('#mki_menu_petatematik').click();
	for(var i=0; i<pid.length; i++) {
		markers[pid[i]].setMap(null);
	}
	//var bounds = new google.maps.LatLngBounds();
	markers['rid_'+r_id].setMap(map);
	//bounds.extend(markers['rid_'+r_id].getPosition());
	//map.fitBounds(bounds);
}

function showRespondenDetil(r_id) {
	infowindow.close();
	$('#mki_preload_responden_detail').show();
	$('#mki_loaded_responden_detail').hide();
	$('#mki_content_responden_detail').stop().fadeIn();
	$.ajax({
		type  : 'post',
		url   : base_url+'map/responden',
		data  : 'data_id='+r_id,
		cache : false,
		success: function(html) {
			if(html!='') {
				$('#mki_preload_responden_detail').hide();
				$('#mki_loaded_responden_detail').show();
				$('#mki_table_responden_detail tbody').html(html);
			}
		}
	});
}

function showRespondenDetil_reload(r_id) {
	$.ajax({
		type  : 'post',
		url   : base_url+'map/responden',
		data  : 'data_id='+r_id,
		cache : false,
		success: function(html) {
			if(html!='') {
				$('#mki_table_responden_detail tbody').html(html);
			}
		}
	});
}

function showRespondenEdit(r_id) {
	$('#mki_preload_responden_edit').show();
	$('#mki_loaded_responden_edit').hide();
	$('#mki_content_responden_edit').stop().fadeIn();
	$.ajax({
		type  : 'post',
		url   : base_url+'responden/responden_edit',
		data  : 'data_id='+r_id,
		cache : false,
		success: function(html) {
			if(html!='') {
				$('#mki_preload_responden_edit').hide();
				$('#mki_loaded_responden_edit').show();
				$('#mki_table_responden_edit').html(html);
			}
		}
	});
}


function showOptionAdd(id) {
	resetOnReload();
	$('#mki_preload_option_add').hide();
	$('#mki_loaded_option_add').show();
	$('#mki_content_kuisoner_option_add').stop().fadeIn();
	if(id>0) {
		$('#mki_kuisoner_kuisoner_savebtn').hide();
		$('#mki_kuisoner_kuisoner_editbtn').show();
		$('#mki_kadd_pilihan').hide();
		$.ajax({
			type  : 'post',
			url   : base_url+'kuisoner/get_kuisoner/'+id,
			cache : false,
			success: function(datas) {
				var data = $.parseJSON(datas);
				if(data.status) {
					$('#kadd_id').val(data.pertanyaan['kuisoner_group_id']);
					$('#kadd_group').val(data.pertanyaan['kuisoner_group_id']).change();
					$('#kadd_pertanyaan').val(data.pertanyaan['kuisoner_pertanyaan']);
					if(data.pertanyaan['kuisoner_rekap']==1) {
						$('#kadd_isrekap').prop({'checked':'checked'});
						$('#kadd_box_rekap_nama').show();
						$('#kadd_rekap_nama').val(data.pertanyaan['kuisoner_rekap_nama']);
					}
					$('.mki_form_option').remove();
				} else {
					closeOptionAdd();
				}
			}
		});
	}
}

function showPenggunaAdd() {
	$('#uadd_id, #uadd_name, #uadd_username, #uadd_password_1, #uadd_password_2, #uadd_kelurahan').val('');
	$('#mki_preload_adduser').hide();
	$('.mki_form_error_display').html('');
	$('#mki_loaded_adduser').show();
	$('#mki_content_add_pengguna').stop().fadeIn();
}

function showPenggunaEdit(pid) {
	$('#uadd_id, #uadd_name, #uadd_username, #uadd_password_1, #uadd_password_2, #uadd_kelurahan').val('');
	$('.mki_form_error_display').html('');
	$('#mki_preload_adduser').show();
	$('#mki_loaded_adduser').hide();
	$('#mki_content_add_pengguna').stop().fadeIn();

	$.ajax({
		type  : 'post',
		url   : base_url+'setting/get_user/'+pid,
		cache : false,
		success: function(html) {
			var datas = $.parseJSON(html);
			if(datas.status) {
				$('#uadd_id').val(datas['datas'].pengguna_id+'-'+datas['datas'].pengguna_pegawai_id).attr({'error':0});
				$('#uadd_name').val(datas['datas'].pegawai_nama_depan).attr({'error':0});
				$('#uadd_username').val(datas['datas'].pengguna_nama).attr({'error':0,'lastdata':datas['datas'].pengguna_nama});
				$('#uadd_password_1').val('').attr({'error':0});
				$('#uadd_password_2').val('').attr({'error':0});
				$('#uadd_kelurahan').val(datas['datas'].pengguna_kelurahan_id).attr({'error':0});

				$('#mki_preload_adduser').hide();
				$('#mki_loaded_adduser').show();
			}
		}
	});
}

function showAllMarkers() {
	var bounds = new google.maps.LatLngBounds();
	for(var i=0; i<pid.length; i++) {
		markers[pid[i]].setMap(map);
		bounds.extend(markers[pid[i]].getPosition());
	}
	map.fitBounds(bounds);
}

function clearAllMarkers() {
	//var bounds = new google.maps.LatLngBounds();
	for(var i=0; i<pid.length; i++) {
		markers[pid[i]].setMap(null);
		//bounds.extend(markers[pid[i]].getPosition());
	}
	//map.fitBounds(bounds);
	 $('#mki_quick_search_result').html('');
}

function showRespondenAdd() {
	$('#mki_preload_add_responden').show();
	$('#mki_loaded_add_responden').hide();
	$('#mki_content_add_responden').stop().fadeIn();
	$.ajax({
		type  : 'get',
		url   : base_url+'responden/responden_add',
		cache : false,
		success: function(html) {
			if(html!='') {
				$('#mki_preload_add_responden').hide();
				$('#mki_loaded_add_responden').show();
				$('#mki_left_content_add_responden_html').html(html);
			}
		}
	});
}

function onMapClick(activeright) {
    $('.mki_left_content').stop().fadeOut(1200);
	//$('.mki_left_content').fadeOut();
	if(activeright!='mki_right_content_pemetaan') {
		$('#mki_right_content_pemetaan').css({right:0,'z-index':29});        
		$('#'+activeright).animate({right:-300}, 500);
		setTimeout(function() {
			$('#mki_right_content_pemetaan').css({'z-index':30});
			$('#mki_active_right').val('mki_right_content_pemetaan');
		}, 500);
	}
	showQuickSearch();
}

function onSettingsClick(activeright) {
	$('.mki_left_content').stop().fadeOut(1200);
	$('#mki_content_pengaturan').stop().fadeIn();
	if(activeright!='mki_right_content_pengaturan') {
		$('#mki_right_content_pengaturan').css({right:0,'z-index':29});
		$('#'+activeright).animate({right:-300}, 500);
		setTimeout(function() {
			$('#mki_right_content_pengaturan').css({'z-index':30});
			$('#mki_active_right').val('mki_right_content_pengaturan');
		}, 500);
	}
}

function onTematikClick(activeright) {
	//if($('#mki_left_content_data_html').html()=='') {
		$('#mki_tematik_'+$('#mki_right_petatematik_menu_inload').val()).click();
	//}
	$('.mki_left_content').stop().fadeOut(1200);
	//$('#mki_content_rekapitulasi').stop().fadeIn();
	if(activeright!='mki_right_content_petatematik') {
		$('#mki_right_content_petatematik').css({right:0,'z-index':29});
		$('#'+activeright).animate({right:-300}, 500);
		setTimeout(function() {
			$('#mki_right_content_petatematik').css({'z-index':30});
			$('#mki_active_right').val('mki_right_content_petatematik');
		}, 500);
	}
}


function refreshTable() {
	$('.paginate_active').click();
}

function openInNewTab(url) {
	window.open(url, 'unduh');
}

function reloadKuisoner() {
	$('#mki_list_datakuisoner_option').click();
}


	function delete_elem(thiselem) {
		var grandma = thiselem.parent().parent();
		thiselem.parent().remove();
		var thisstatus = thiselem.parent().attr('ref');
		if(thisstatus=='child') {
			if(grandma.find('.mki_form_option').length==1) {
				grandma.attr({added:0}).hide();
				grandma.prev().show();
				grandma.prev().prev().show();
			}
			grandma.children('.mki_form_option').last().prev().children('input').focus();
		} else if(thisstatus=='parent') {
			if($('#mki_option_elem').children('.mki_form_option').length==2) {
				insert_before_parent($('#mki_form_option_add_elem_parent'));
			}
			$('#mki_form_option_add_elem_parent').prev().children('input').focus();
		}
		renumbering_answer();
	}


