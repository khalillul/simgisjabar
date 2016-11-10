var device_width = 0;
var device_height = 0;

function reinit()
{
    $.Metro.initDropdowns('header');
    $.Metro.initPulls('header');
}

$(function(){
    $("[data-load]").each(function(){
        $(this).load($(this).data("load"), function(){
            reinit();
        });
    });

    window.prettyPrint && prettyPrint();

    $(".history-back").on("click", function(e){
        e.preventDefault();
        history.back();
        return false;
    })
})


function headerPosition(){
    if ($(window).scrollTop() > $('header').height()) {
        $("header .navigation-bar")
            .addClass("fixed-top")
            .addClass(" shadow")
        ;
    } else {
        $("header .navigation-bar")
            .removeClass("fixed-top")
            .removeClass(" shadow")
        ;
    }
}

$(function() {
    if ($('nav > .side-menu').length > 0) {
        var side_menu = $('nav > .side-menu');
        var fixblock_pos = side_menu.position().top;
        $(window).scroll(function(){
            if ($(window).scrollTop() > fixblock_pos){
                side_menu.css({'position': 'fixed', 'top':'65px', 'z-index':'1000'});
            } else {
                side_menu.css({'position': 'static'});
            }
        })
    }
});

$(function(){
    setTimeout(function(){headerPosition();}, 100);
})

$(window).scroll(function(){
    headerPosition();
});

$(document).ready(function(){    
	var TriggerClick = 0;
	$('#fluid-button').click(function(){ 
		if(TriggerClick==0){
			TriggerClick=1;
			$( ".fluid-sides" ).animate({width: "+=15%"}, 100);
			$( "#fluid-button" ).animate({left: "+=15%"}, 100);
		}
		else{
			TriggerClick=0;
			$( ".fluid-sides" ).animate({width: "0px"}, 100);
			$( "#fluid-button" ).animate({left: "0"}, 100);
		}
	});

    $('#combox select').change(function () {
        var selProv = $(this).val();
        console.log(selProv);  //menampilan pada log browser apa yang dibawa pada saat dipilih pada combo box
        $.ajax({
            url: "<?=base_url()?>cdinamis/get_kota/",       //memanggil function controller dari url
            async: false,
            type: "POST",     //jenis method yang dibawa ke function
            data: "provinsi="+selProv,   //data yang akan dibawa di url
            dataType: "html",
            success: function(data) {
                $('#kota').html(data);   //hasil ditampilkan pada combobox id=kota
            }
        })
    });


//call in wilayah
//new



	$('#filter_wil').change(function(){
		var gol = $('#filter_wil').val();
		$.ajax({
			type  : 'post',
			url   : base_url+'index.php/site/get_bidang/'+gol,
			cache : false,
			success: function(datas) {
				$('#filter_bid_cont').html(datas);
			}
		});
	});
}); //window

function getFilKelompok(){
	var bid = $('#filter_bid').val();
	$.ajax({
		type  : 'post',
		url   : base_url+'index.php/site/get_kelompok/'+bid,
		cache : false,
		success: function(datas) {
			$('#filter_kel_cont').html(datas);
		}
	});
}



function getFilSubkel(){
	var kel = $('#filter_kel').val();
	$.ajax({
		type  : 'post',
		url   : base_url+'index.php/site/get_subkel/'+kel,
		cache : false,
		success: function(datas) {
			$('#filter_sub_cont').html(datas);
		}
	});
}

function getFilBarang(){
	var kel = $('#filter_sub').val();
	$.ajax({
		type  : 'post',
		url   : base_url+'index.php/site/get_barang/'+kel,
		cache : false,
		success: function(datas) {
			$('#filter_brg_cont').html(datas);
		}
	});
}

function getFilter(){
	var gol = $('#filter_wil').val();
	var bid = $('#filter_bid').val();
	// var kel = $('#filter_kel').val();
	// var sub = $('#filter_sub').val();
	// var brg = $('#filter_brg').val();
	// var reg = $('#filter_reg').val();
	var result = '';
	
	if(gol=='nol'){
		//alert('Mohon Pilih Golongan Terlebih Dahulu');
		 $.Notify({
			caption: "Warning",
			content: "Mohon Pilih Wilayah Terlebih Dahulu",
			style:{background: 'orange', color: 'white'}
		});
	}
	else if(bid=='nol'){
		//alert('Mohon Pilih Golongan Terlebih Dahulu');
		 $.Notify({
			caption: "Warning",
			content: "Kecamatan Belum di entri",
			style:{background: 'orange', color: 'white'}
		});
	}
	// else if(reg==''){
	// 	//alert('Mohon Isi Nomor Register Terlebih Dahulu');
	// 	 $.Notify({
	// 		caption: "Warning",
	// 		content: "Mohon Isi Nomor Register Terlebih Dahulu",
	// 		style:{background: 'orange', color: 'white'}
	// 	});
	// }
	else{
		$.ajax({
			type  : 'post',
			url   : base_url+'index.php/site/get_filter/',
			data  : { gol:gol, bid:bid},
			cache : false,
			success: function(datas) {
				var data = $.parseJSON(datas);
				var aset = data.aset;
				if(aset.length>0){
					legend = data.legend;
					legendteks='<ul class="side-menu"><li class="title">Keterangan</li>';
					for (var i = 0; i < legend.length; i++) {    
						legendteks+='<li><a href="#"><img src="assets/markers/'+legend[i].kelompok+'.png" style="width:16px;height:16px;margin-right:5px">'+legend[i].nm_kelompok+'</a></li>';
					}
					legendteks+='</ul>';
					$('#legends').html(legendteks);
					
					for(i=0;i<aset.length;i++){
						result += '<span><i class="icon-target-2" style="cursor:pointer" onclick="clickMarker(\''+aset[i].no_reg+'\')"></i> '+aset[i].no_reg+'</span>';
					}
					if(!addTitik){
						showMarkers(map,aset,gol);
					}
				}else{
					result += '<span>Data Tidak Ditemukan</span>';
				}
				$('#search_result').html(result);
			}
		});
	}
}

function getUnitFilter(){
	var fil = $('#filter_skpd').val();
	var result = '';
	
	if(fil==''){
		alert('Mohon Isi Nomor Register Terlebih Dahulu');
	}else{
		$.ajax({
			type  : 'post',
			url   : base_url+'index.php/site/get_unit_filter/',
			data  : { fil:fil},
			cache : false,
			success: function(datas) {
				var data = $.parseJSON(datas);
				var aset = data.aset;
				if(aset.length>0){
					legend = data.legend;
					legendteks='<ul class="side-menu"><li class="title">Legend</li>';
					for (var i = 0; i < legend.length; i++) {    
						legendteks+='<li><a href="#"><img src="assets/markers/'+legend[i].kd_bidskpd+'.png" style="width:16px;height:16px;margin-right:5px">'+legend[i].nm_uskpd+'</a></li>';
					}
					legendteks+='</ul>';
					$('#legends').html(legendteks);
					
					for(i=0;i<aset.length;i++){
						result += '<span><i class="icon-target-2" style="cursor:pointer" onclick="clickMarker2(\''+aset[i].kd_uskpd+'\')"></i> '+aset[i].nm_uskpd+'</span>';
					}
					if(!addTitik){
						showMarkers2(map,aset,gol);
					}
				}else{
					result += '<span>Data Tidak Ditemukan</span>';
				}
				$('#search_result2').html(result);
			}
		});
	}
}
function getDetail(mode){
	if(mode=='hide'){$( "#detail" ).animate({width: "0%"}, 200);}
	else{$( "#detail" ).animate({width: "78.5%"}, 200);}
}
function getDetail1(mode){
	if(mode=='hide'){$( "#detail1" ).animate({width: "0%"}, 200);}
	else{$( "#detail1" ).animate({width: "78.5%"}, 200);}
}

function loadAsetMenu(){
	clearMarker();
	disableAddData();
    $( "#pencarianUnit" ).animate({width: "0px"}, 200);
	$( "#pencarian" ).animate({width: "0px"}, 200);
	$( "#tematik" ).css("margin", "0px");
	$( "#tematik" ).animate({width: "22%",margin: "0px"}, 200);
}

function loadSearchMenu(unit, add){
	clearMarker();
	disableAddData();
    unit = typeof unit !== 'undefined' ? unit : false;

	$( "#tematik" ).animate({width: "0px",margin:"0 -10px 0 0"}, 200);
    if(unit){
        $( "#pencarian" ).animate({width: "0px"}, 200);
        $( "#pencarianUnit" ).animate({width: "22%"}, 200);
		if(add){enableAddData(true);}
    }else{
        $( "#pencarianUnit" ).animate({width: "0px"}, 200);
        $( "#pencarian" ).animate({width: "22%"}, 200);
		if(add){enableAddData();}
    }
}

function loadPrintMenu(category){
	if(category==''){
		$.Notify({
			caption: "Warning",
			content: "Mohon Pilih Wilayah Terlebih Dahulu",
			style:{background: 'orange', color: 'white'}
		});
	}else{
		window.open(base_url+'index.php/site/printTematik/'+category);  
	}
}

/*
function getDeviceSize(){
    device_width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    //device_height = (window.innerHeight > 0) ? window.innerHeight : screen.height;
    $("#device_width").html(device_width);
    //$("#device_height").html(device_height);
}

$(function(){
    $("<div/>").addClass("padding20 bg-dark fg-white border bd-white no-display").css({
        position: "fixed",
        top: 0,
        right: 0
    }).html('<span id="device_width">0</span>').appendTo("body");
    getDeviceSize();
})

$(window).resize(function(){
    getDeviceSize();
})
*/
