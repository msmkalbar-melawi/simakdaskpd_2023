<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
    
	<style>    
    #tagih {
        position: relative;
        width: 500px;
        height: 70px;
        padding: 0.4em;
    }  
    </style>
    <script type="text/javascript">
    
     var  zno_upload = '';   
    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 450,
                width: 920,
                modal: true,
                autoOpen:false                
            });
            
            $( "#dialog-modal-cekdata" ).dialog({
                height: 590,
                width: 920,
                modal: true,
                autoOpen:false                
            });              
           load_sisa_bank(); 
                                 
        });    
        
      $(function(){                
      $('#dg').edatagrid({
		rowStyler:function(index,row){        
        if ((row.status_uploadx==1 && row.status_validasix==1)){
		   return 'background-color:#B0E0E6';
        }else if ((row.status_uploadx==1)){
		   return 'background-color:#90EE90';
        }
                
		},
		url: '<?php echo base_url(); ?>index.php/clist_upload/load_listbelum_upload',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        columns:[[    	    
			{field:'no_voucher',
    		title:'No.VO',
    		width:8},
            {field:'tgl_voucher',
    		title:'TGL Voucher',
    		width:15},
            {field:'tgl_upload',
    		title:'TGL Upload',
    		width:15},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:13,
            align:"center"},
            {field:'ket',
    		title:'Keterangan',
    		width:46,
            align:"left"},
			{field:'total',
    		title:'Nilai Pengeluaran',            
    		width:25,
            align:"right"},
            {field:'bersih',
    		title:'Bersih',            
    		width:25,
            align:"right",hidden:true},
			{field:'status_upload',
    		title:'STT',
    		width:5,
            align:"center"},
            {field:'ck',
    		checkbox:'true'},
            {field:'rekening_awal',
    		title:'Rek Bend',
    		width:10,
            align:"left",hidden:true},
            {field:'nm_rekening_tujuan',
    		title:'Nama Rek',
    		width:10,
            align:"left",hidden:true},
            {field:'rekening_tujuan',
    		title:'Rek Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'bank_tujuan',
    		title:'Bank Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'ket_tujuan',
    		title:'Ket. Tujuan',
    		width:10,
            align:"left",hidden:true}
        ]],
        onSelect:function(rowIndex,rowData){                                                      
          skdvoucher    = rowData.no_voucher; 
          stglvoucher   = rowData.tgl_voucher;         
          skdskpd       = rowData.kd_skpd;
          stotal        = rowData.total;  
          cekskpd       = rowData.nm_skpd; 
          ceknomor      = rowData.no_voucher;  
          cektgl        = rowData.tgl_voucher;                
          ceksp2d       = rowData.no_sp2d;
          cekket        = rowData.ket;
          cektotal      = rowData.total;
          cekrekawal    = rowData.rekening_awal;                
          ceknmrekawal  = rowData.nm_rekening_tujuan;
          cekrek_tuj    = rowData.rekening_tujuan;
          cekbank_tu    = rowData.bank_tujuan;
          cekgiat       = rowData.kd_sub_kegiatan;
          ceknmgiat     = rowData.nm_sub_kegiatan;
          
          if(rowData.status_validasix==1){
            alert('sudah di-Validasi');
            bersih_list();
            exit();
          }else if(rowData.status_uploadx==1){
            alert('sudah di-Upload');
            bersih_list();
            exit();
          } 
          
          get(cekskpd,ceknomor,cektgl,ceksp2d,cekket,cektotal,cekrekawal,ceknmrekawal,cekrek_tuj,cekbank_tu,cekgiat,ceknmgiat);
          load_total_sub();
        },
        onDblClickRow:function(rowIndex,rowData){                                       
        }
    }); });
    
    $(function(){                
      $('#dg5').edatagrid({
		rowStyler:function(index,row){        
        if ((row.status_uploadx==1 && row.status_validasix==1)){
		   return 'background-color:#B0E0E6';
        }                
		},
		//url: '<?php echo base_url(); ?>index.php/tukd_cms/load_list_upload',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        columns:[[    	    
			{field:'no_upload',
    		title:'No.UPL',
    		width:8,hidden:true},
            {field:'no_upload_tgl',
    		title:'URUT',
    		width:8},
            {field:'no_voucher',
    		title:'No.TR',
    		width:8},
            {field:'tgl_voucher',
    		title:'TGL Trans.',
    		width:15},
            {field:'tgl_upload',
    		title:'TGL Upload',
    		width:15},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:15,
            align:"center"},
            {field:'ket',
    		title:'Keterangan',
    		width:40,
            align:"left"},
			{field:'total',
    		title:'Nilai Pengeluaran',            
    		width:25,
            align:"right"},
			{field:'status_upload',
    		title:'STT',
    		width:5,
            align:"center"},
            {field:'ck',
    		checkbox:'true'},
            {field:'rekening_awal',
    		title:'Rek Bend',
    		width:10,
            align:"left",hidden:true},
            {field:'nm_rekening_tujuan',
    		title:'Nama Rek',
    		width:10,
            align:"left",hidden:true},
            {field:'rekening_tujuan',
    		title:'Rek Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'bank_tujuan',
    		title:'Bank Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'ket_tujuan',
    		title:'Ket. Tujuan',
    		width:10,
            align:"left",hidden:true}
        ]],
        onSelect:function(rowIndex,rowData){                                                      
          skdvoucher    = rowData.no_voucher; 
          stglvoucher   = rowData.tgl_voucher;         
          skdskpd       = rowData.kd_skpd;
          stotal        = rowData.total;  
          cekskpd       = rowData.nm_skpd; 
          ceknomor      = rowData.no_voucher;  
          cektgl        = rowData.tgl_voucher;                
          ceksp2d       = rowData.no_sp2d;
          cekket        = rowData.ket;
          cektotal      = rowData.total;
          cekrekawal    = rowData.rekening_awal;                
          ceknmrekawal  = rowData.nm_rekening_tujuan;
          cekrek_tuj    = rowData.rekening_tujuan;
          cekbank_tu    = rowData.bank_tujuan;
          cekgiat       = rowData.kd_sub_kegiatan;
          ceknmgiat     = rowData.nm_sub_kegiatan;
          
          if(rowData.status_validasix==1){
            alert('sudah di-Validasi');
            bersih_list();
            exit();
          } 
          
          get(cekskpd,ceknomor,cektgl,ceksp2d,cekket,cektotal,cekrekawal,ceknmrekawal,cekrek_tuj,cekbank_tu,cekgiat,ceknmgiat);
          load_total_sub();
        },
        onDblClickRow:function(rowIndex,rowData){                                       
        }
    }); });
    
    
    $(function(){
    $('#dg2').edatagrid({
		idField:'id',            
        toolbar:'#toolbar',
            rownumbers:"true", 
            fitColumns:"true",            
            autoRowHeight:"false",
            loadMsg:"Tunggu Sebentar....!!",                               
        columns:[[    	    
			{field:'no_voucher',
    		title:'No.TR',
    		width:10},
            {field:'tgl_voucher',
    		title:'Tanggal',
    		width:15},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:13,
            align:"center"},
            {field:'ket',
    		title:'Keterangan',
    		width:40,
            align:"left"},
			{field:'total',
    		title:'Nilai Pengeluaran',            
    		width:23,
            align:"right",
            hidden:true},
            {field:'viewbersih',
    		title:'Netto',            
    		width:23,
            align:"right"},
            {field:'viewpot',
    		title:'Potongan',            
    		width:23,
            align:"right"},
            {field:'viewtotal',
    		title:'Nilai Pengeluaran',            
    		width:23,
            align:"right"},
			{field:'status_upload',
    		title:'Upload',
    		width:10,
            align:"center",
            hidden:true},
            {field:'rekening_awal',
    		title:'Rek Bend',
    		width:10,
            align:"left",hidden:true},
            {field:'nm_rekening_tujuan',
    		title:'Nama Rek',
    		width:10,
            align:"left",hidden:true},
            {field:'rekening_tujuan',
    		title:'Rek Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'bank_tujuan',
    		title:'Bank Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'ket_tujuan',
    		title:'Ket. Tujuan',
    		width:10,
            align:"left",hidden:true}                
        ]],
        onSelect:function(rowIndex,rowData){                                                                       
        },
        onDblClickRow:function(rowIndex,rowData){                                       
        }
    }); });
    
    $(function(){
    $('#dg3').edatagrid({		
		//url: '<?php echo base_url(); ?>index.php/tukd_cms/load_hdraf_upload',
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",
        columns:[[    	    
			{field:'no_upload',
    		title:'No.UPL',
    		width:10,hidden:true},
            {field:'no_upload_tgl',
    		title:'Urutan Upload',
    		width:10},
            {field:'tgl_upload',
    		title:'Tanggal Upload',
    		width:10},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:10,
            align:"center"},
			{field:'total',
    		title:'Total Pengeluaran',            
    		width:15,
            align:"right"}
			
        ]],
        onSelect:function(rowIndex,rowData){                                                      
          zno_upload = rowData.no_upload;
          ztotal = rowData.total;
          $("#no_upload").attr("value",zno_upload);
          $("#total_trans_cek").attr("value",ztotal); 
        },
        onDblClickRow:function(rowIndex,rowData){                                       
        }
    }); });
    
    $(function(){
    $('#tglvoucher').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();    
            	return y+'-'+m+'-'+d;
            }
        });
    });
    
    $(function(){
    $('#tglvoucher_btl').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();    
            	return y+'-'+m+'-'+d;
            }
        });
    });
    
    $(function(){
    $('#tglupload').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();    
            	return y+'-'+m+'-'+d;
            }
        });
    });
    
function cari(){
    var kriteria = $('#tglvoucher').datebox('getValue');
    
    if(kriteria=='' || kriteria==null){
        alert('Tanggal Transaksi Belum dipilih !');
        exit();
    }
    
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>index.php/clist_upload/load_listbelum_upload',
        queryParams:({cari:kriteria})
        });        
     });
    }	
    
function cari_upload(){
    var kriteria = $('#tglupload').datebox('getValue');
    
    if(kriteria=='' || kriteria==null){
        alert('Tanggal Upload Belum dipilih !');
        exit();
    }
    ctotal_upload();
    $(function(){ 
     $('#dg3').edatagrid({
        url: '<?php echo base_url(); ?>index.php/clist_upload/load_hdraf_upload',		
        queryParams:({cari:kriteria})
        });        
     });     
    }    	

function cari_batal(){
    var kriteria = $('#tglvoucher_btl').datebox('getValue');
    
    if(kriteria=='' || kriteria==null){
        alert('Tanggal Upload Belum dipilih !');
        exit();
    }
    set_gridbatal();
    
    $(function(){ 
     $('#dg5').edatagrid({
		url: '<?php echo base_url(); ?>index.php/clist_upload/load_list_telahupload',
        queryParams:({cari:kriteria})
        });        
     });
    }		

    
function load_sisa_bank(){           
        $(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/tukd/load_sisa_bank",
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#sisa_bank").attr("value",n['sisa']);                   
                });
            }
         });
        });
    }    
    
function ctotal_upload(){
    var kriteria = $('#tglupload').datebox('getValue');
    $(function(){      
         $.ajax({
            type: 'POST',
            url:"<?php echo base_url(); ?>index.php/clist_upload/load_total_upload/"+kriteria,                        
            dataType:"json",
            success:function(data){ 
                $.each(data, function(i,n){
                    $("#total_upload").attr("value",n['xtotal_upload']);                   
                });
            }
         });
        });
}    
    
function bersih_list(){
    $('#dg').edatagrid('unselectAll');
    $('#dg2').edatagrid('unselectAll'); 
    $('#dg3').edatagrid('unselectAll');    
    $('#dg2').datagrid('loadData', {"total":0,"rows":[]});   
    $("#total_trans").attr("value",number_format(0,2,'.',','));
    $("#total_trans_cek").attr("value",number_format(0,2,'.',','));
	$("#total_pot").attr("value",number_format(0,2,'.',','));	
    $('#dg').edatagrid('reload');
    
    load_sisa_bank();
}   

function bersih_batallist(){
    $('#dg5').edatagrid('unselectAll');
    $('#dg5').edatagrid('reload');    
} 

function proses_list(){
    get_nourut();      
    get_nouruthari();        
    $('#dg2').edatagrid('unselectAll');   
    $('#dg2').datagrid('loadData', {"total":0,"rows":[]}); 
    
    var x = $('#dg').datagrid('getSelected');     
    if(x==null){
        alert('List Data Transaksi belum dipilih');
        exit();
    }
    $('#csv').linkbutton('disable');   
    $('#csv_lain').linkbutton('disable');    
    $('#proses').linkbutton('enable'); 
    set_grid2();
    var hasil_2=0;
    var rows = $('#dg').datagrid('getSelections');     
		      for(var p=0;p<rows.length;p++){ 
		            cno_voucher   = rows[p].no_voucher;
                    ctgl_voucher  = rows[p].tgl_voucher;
                    cskpd         = rows[p].kd_skpd;
                    cket          = rows[p].ket;
                    ctotal        = angka(rows[p].total);
                    cviewtotal    = rows[p].total;
                    cnetto        = rows[p].bersih;                    
                    cpot          = rows[p].pot;
                    hasil_2       = hasil_2+angka(rows[p].total);  
                    cstt_upload   = rows[p].status_upload;                   
                    crekening_awal     = rows[p].rekening_awal;
                    cnm_rekening_tujuan  = rows[p].nm_rekening_tujuan;
                    crekening_tujuan   = rows[p].rekening_tujuan;
                    cbank_tujuan  = rows[p].bank_tujuan;
                    cket_tujuan   = rows[p].ket_tujuan;  
                                        
                    $('#dg2').edatagrid('appendRow',{no_voucher:cno_voucher,tgl_voucher:ctgl_voucher,kd_skpd:cskpd,ket:cket,total:ctotal,viewbersih:cnetto,viewpot:cpot,viewtotal:cviewtotal,status_upload:cstt_upload,rekening_awal:crekening_awal,nm_rekening_tujuan:cnm_rekening_tujuan,rekening_tujuan:crekening_tujuan,bank_tujuan:cbank_tujuan,ket_tujuan:cket_tujuan});                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
              }    
    $("#total_trans").attr("value",number_format(hasil_2,2,'.',','));
    $("#total_trans_cek").attr("value",number_format(hasil_2,2,'.',','));          
    $("#dialog-modal").dialog('open');     
}    

function load_total_sub(){
    var hasil=0;
	var hasil_pot=0;
    var rows = $('#dg').datagrid('getSelections');     
		      for(var p=0;p<rows.length;p++){ 
                    hasil = hasil+angka(rows[p].total); 
					hasil_pot = hasil_pot+angka(rows[p].tot_pot);
                   }
    $("#total_trans").attr("value",number_format(hasil,2,'.',',')); 
	$("#total_pot").attr("value",number_format(hasil_pot,2,'.',','));
}

function set_grid2(){
        $('#dg2').edatagrid({                                                                   
            columns:[[    	    
			{field:'no_voucher',
    		title:'No.Voucher',
    		width:10},
            {field:'tgl_voucher',
    		title:'TGL Voucher.',
    		width:15},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:13,
            align:"center"},
            {field:'ket',
    		title:'Keterangan',
    		width:40,
            align:"left"},
			{field:'total',
    		title:'Nilai Pengeluaran',            
    		width:23,
            align:"right",
            hidden:true},
            {field:'viewbersih',
    		title:'Netto',            
    		width:23,
            align:"right"},
            {field:'viewpot',
    		title:'Potongan',            
    		width:23,
            align:"right"},
            {field:'viewtotal',
    		title:'Nilai Pengeluaran',            
    		width:23,
            align:"right"},
			{field:'status_upload',
    		title:'Upload',
    		width:10,
            align:"center",hidden:true},
            {field:'rekening_awal',
    		title:'Rek Bend',
    		width:10,
            align:"left",hidden:true},
            {field:'nm_rekening_tujuan',
    		title:'Nama Rek',
    		width:10,
            align:"left",hidden:true},
            {field:'rekening_tujuan',
    		title:'Rek Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'bank_tujuan',
    		title:'Bank Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'ket_tujuan',
    		title:'Ket. Tujuan',
    		width:10,
            align:"left",hidden:true}
            ]]
        });                 
    }

 function set_grid3(){        
    $('#dg3').edatagrid({                                                                           
    columns:[[    	    
			{field:'no_upload',
    		title:'No.UPL',
    		width:10,hidden:true},
            {field:'no_upload_tgl',
    		title:'Urutan Upload',
    		width:10},
            {field:'tgl_upload',
    		title:'Tanggal Upload',
    		width:10},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:10,
            align:"center"},
			{field:'total',
    		title:'Total Pengeluaran',            
    		width:15,
            align:"right"}			
        ]]
    });
 }
 
 function set_grid2_b(){
        $('#dg2').edatagrid({                                                                   
            columns:[[    	    
            {field:'no_voucher',
    		title:'No.Voucher',
    		width:10},
            {field:'tgl_voucher',
    		title:'TGL Voucher.',
    		width:10},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:10,
            align:"center"},
            {field:'rekening_awal',
    		title:'Rek Bend',
    		width:10,
            align:"left",hidden:true},
            {field:'nm_rekening_tujuan',
    		title:'Nama Rek',
    		width:10,
            align:"left",hidden:true},
            {field:'rekening_tujuan',
    		title:'Rek Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'bank_tujuan',
    		title:'Bank Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'ket_tujuan',
    		title:'Keterangan',
    		width:15,
            align:"left"},
            {field:'nilai',
    		title:'Nilai',            
    		width:13,
            align:"right",
            hidden:true},
            {field:'viewbersih',
    		title:'Netto',            
    		width:13,
            align:"right"},
            {field:'viewpot',
    		title:'Potongan',            
    		width:13,
            align:"right"},
            {field:'viewtotal',
    		title:'Nilai',            
    		width:13,
            align:"right"}			
            ]]
        });                 
    }
 
function set_gridbatal(){
    $('#dg5').edatagrid({
		rowStyler:function(index,row){        
        if ((row.status_uploadx==1 && row.status_validasix==1)){
		   return 'background-color:#B0E0E6';
        }                
		},
		//url: '<?php echo base_url(); ?>index.php/tukd_cms/load_list_telahupload',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        columns:[[    	    			
            {field:'no_upload',
    		title:'No.UPL',
    		width:8,hidden:true},
            {field:'no_upload_tgl',
    		title:'URUT',
    		width:8},
            {field:'no_voucher',
    		title:'No.Voucher',
    		width:8},
            {field:'tgl_voucher',
    		title:'TGL Voucher.',
    		width:15},
            {field:'tgl_upload',
    		title:'TGL Upload',
    		width:15},
            {field:'kd_skpd',
    		title:'SKPD',
    		width:15,
            align:"center"},
            {field:'ket',
    		title:'Keterangan',
    		width:40,
            align:"left"},
			{field:'total',
    		title:'Nilai Pengeluaran',            
    		width:25,
            align:"right"},
			{field:'status_upload',
    		title:'STT',
    		width:5,
            align:"center"},
            {field:'ck',
    		checkbox:'true'},
            {field:'rekening_awal',
    		title:'Rek Bend',
    		width:10,
            align:"left",hidden:true},
            {field:'nm_rekening_tujuan',
    		title:'Nama Rek',
    		width:10,
            align:"left",hidden:true},
            {field:'rekening_tujuan',
    		title:'Rek Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'bank_tujuan',
    		title:'Bank Tujuan',
    		width:10,
            align:"left",hidden:true},
            {field:'ket_tujuan',
    		title:'Ket. Tujuan',
    		width:10,
            align:"left",hidden:true}
        ]]
    }); 
} 
    
function load_gridcekrek(){
        $('#dg8').edatagrid({          
            loadMsg:"Tunggu Sebentar....!!",
            columns:[[
			    {field:'kd_rek6',
        		title:'Kode Rek',
        		width:190},
                {field:'nm_rek6',
        		title:'Nama Rekening',
        		width:400,
                align:"left"},
                {field:'nilai_nformat',
        		title:'Nilai',
        		width:160,
                align:"right"},
                {field:'sumber',
        		title:'Sumber',
        		width:100,
                align:"center"}
            ]]
        });                 
}   

function load_gridcekpotongan(){
        $('#dg9').edatagrid({               
            loadMsg:"Tunggu Sebentar....!!",
            columns:[[
				{field:'kd_rek6',
        		title:'Kode Rek',
        		width:190},
                {field:'nm_rek6',
        		title:'Nama Rekening',
        		width:400,
                align:"left"},
                {field:'nilai_nformat',
        		title:'Nilai',
        		width:160,
                align:"right"}                
            ]]
        });                 
}

function set_grid6(){
        $('#dg6').edatagrid({                                                                
            columns:[[
            {field:'no_bukti',
    		title:'No Bukti',    		
            hidden:"true"},
            {field:'tgl_bukti',
    		title:'Tanggal',    		
            hidden:"true"},
    	    {field:'rekening_awal',
    		title:'Rek. Bendahara',
            width:135},
            {field:'nm_rekening_tujuan',
    		title:'Atas Nama Rek. Tujuan',    		
            width:310},
            {field:'rekening_tujuan',
    		title:'Rek. Tujuan',
    		width:140},            
            {field:'kd_skpd',
    		title:'SKPD',           
            hidden:'true'},
            {field:'nilai',
    		title:'Nilai',
    		width:160,
            align:"right"},          
            {field:'bank_tujuan',
    		title:'Bank',
    		width:100}
            ]]
        });                  
    } 
 
function get_nourut()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/clist_upload/no_urut_uploadcms',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#no_upload").attr("value",data.no_urut);
        							  }                                     
        	});  
        }

function get_nouruthari()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/clist_upload/no_urut_uploadcmsharian',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#no_uploadhari").attr("value",data.no_urut);
        							  }                                     
        	});  
        }        
 
function proses_upload_db(){
     
	 var tot_transval2 = 0; 
	 var tot_potval = 0;
	 
	  var x = $('#dg').datagrid('getSelected');     
    if(x==null){
        alert('List Data belum dipilih');
        exit();
    }
	 
     var total_trns = angka(document.getElementById('total_trans_cek').value); 
        var total_bank = angka(document.getElementById('sisa_bank').value); 
        
		 var rows = $('#dg').datagrid('getSelections');                                        
            for(var p=0;p<rows.length;p++){			 
                    tot_potval     = tot_potval+ angka(rows[p].tot_pot);
					tot_transval = total_trns-tot_potval;
            }  
		
        if(tot_transval > total_bank){
            alert('Total Transaksi melebihi sisa Bank, Cek Kembali !');
            exit();
        }
     
     var r = confirm("Apakah data yang akan di-Upload sudah benar ?");
     if (r == true) {                
        
     $('#proses').linkbutton('disable');                          
        var dskpd = '';                            
        var csql = '';
        var p=0;
        var nomor_upload = document.getElementById('no_upload').value;
        var nomor_uplhari= document.getElementById('no_uploadhari').value;
        var total_2 = angka(document.getElementById('total_trans_cek').value);
        var initnumber='';
        var init_nomor_up = nomor_uplhari;
            $('#dg2').edatagrid('selectAll');        
            var total = $('#dg2').datagrid('getData').total;
            //var rows = $('#dg2').datagrid('getSelections'); 
            var rows = $('#dg2').datagrid('getRows');                                        
            for(var p=0;p<rows.length;p++){
			 
                    cno_voucher   = rows[p].no_voucher;
                    ctgl_voucher  = rows[p].tgl_voucher;
                    cskpd         = rows[p].kd_skpd;
                    cket          = rows[p].ket;                    
                    ctotal        = rows[p].total;                    
                    cstt_upload   = rows[p].status_upload;                   
                    crekening_awal       = rows[p].rekening_awal;                   
                    cnm_rekening_tujuan  = rows[p].nm_rekening_tujuan;
                    crekening_tujuan     = rows[p].rekening_tujuan;
                    cbank_tujuan  = rows[p].bank_tujuan;
                    cket_tujuan   = rows[p].ket_tujuan;                    
                    dskpd = cskpd;
                      
                    
                initnumber = ctotal.toString();                                            
              
                if (p>0) {
                csql = csql+","+"('"+cno_voucher+"','"+ctgl_voucher+"','"+nomor_upload+"','"+crekening_awal+"','"+cnm_rekening_tujuan+"','"+crekening_tujuan+"','"+cbank_tujuan+"','"+cket_tujuan+"','"+ctotal+"','"+cskpd+"','"+dskpd+"','1','"+init_nomor_up+"')";
                } else {
                csql = "values('"+cno_voucher+"','"+ctgl_voucher+"','"+nomor_upload+"','"+crekening_awal+"','"+cnm_rekening_tujuan+"','"+crekening_tujuan+"','"+cbank_tujuan+"','"+cket_tujuan+"','"+ctotal+"','"+cskpd+"','"+dskpd+"','1','"+init_nomor_up+"')";                                            
                }    
                                                         
			}
            //alert(csql);
            
            $(document).ready(function(){               
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({tabel:'trdupload_cmsbank',no:nomor_upload,sql:csql,skpd:dskpd,total:total_2,urut_tglupload:init_nomor_up}),
                    url: '<?php echo base_url(); ?>index.php/clist_upload/simpan_uploadcms',
                    success:function(data){                        
                        status = data.pesan;   
                         if (status=='1'){               
                            alert('Data Berhasil diproses, Silahkan [Unduh CSV]');		
                            $('#csv').linkbutton('enable');  
                            $('#csv_lain').linkbutton('enable');                                                        					
                        } else{ 
                            alert('Data Gagal diproses...!!!');
                        }                                             
                    }
                });
                });           
                                  
            } else {
                alert('Silahkan Cek lagi, Pastikan Data Sudah Benar...');
            } 
        }            

function proses_kembali(){        
    bersih_list();
    $("#dialog-modal").dialog('close'); 
}  

function section2(){
         $(document).ready(function(){                
             $('#section2').click();                                                          
         });                 
         set_grid3();
         
     }      

function section3(){
         $(document).ready(function(){                
             $('#section3').click();                                                          
         });                 
         set_gridbatal();         
     }      


function section_awal(){
        /*$(document).ready(function(){                
             $('#section1').click();                                                          
         });                 
         bersih_list();*/
        urll ='<?php echo base_url(); ?>index.php/clist_upload/list_transout';
        window.open(urll, '_self');
        window.focus();
     }                

function lihat_list(){
    var x = $('#dg3').datagrid('getSelected');     
    if(x==null){
        alert('List Data Upload belum dipilih');
        exit();
    }
    
    set_grid2_b();
    $('#csv').linkbutton('enable');
    $('#csv_lain').linkbutton('enable');
    $('#proses').linkbutton('disable');
    $("#dialog-modal").dialog('open'); 
    
    $(function(){ 
     $('#dg2').edatagrid({
		url: '<?php echo base_url(); ?>index.php/clist_upload/load_draf_upload',
        queryParams:({cari:zno_upload})
        });        
     });
}     

function lihat_batallist(){
    var x = $('#dg5').datagrid('getSelected');     
    var nomor = '';
    
    if(x==null){
        alert('List Data belum dipilih');
        exit();
    }
    
    var rows = $('#dg5').datagrid('getSelections');  
    var jumlah_row = rows.length;
    
    if(jumlah_row>1){
        alert('Pilih hanya 1 List Data Transaksi');
        bersih_batallist();
        exit();
    }
    
    nomor   = rows[0].no_voucher;
    kdskpd  = rows[0].kd_skpd;
    
    if(nomor=='' || kdskpd==''){
        alert('List Data harus dipilih');
        bersih_batallist();
        exit();
    }
    
    $("#dialog-modal-cekdata").dialog('open');
    
    load_gridcekrek();    
    $(function(){ 
     $('#dg8').edatagrid({
		url: '<?php echo base_url(); ?>index.php/cms/ctransout_cms/load_dtransout',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     });
    
    load_gridcekpotongan();        
    $(function(){ 
     $('#dg9').edatagrid({
		url: '<?php echo base_url(); ?>index.php/ctrmpot/load_dtransout_trdmpot',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     });
     
    set_grid6();
    $(function(){ 
     $('#dg6').edatagrid({
		url: '<?php echo base_url(); ?>index.php/cms/ctransout_cms/load_dtransout_transfercms',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     }); 

}     


function get(cekskpd,ceknomor,cektgl,ceksp2d,cekket,cektotal,cekrekawal,ceknmrekawal,cekrek_tuj,cekbank_tu,cekgiat,ceknmgiat){
    $("#cek_skpd").attr("value",cekskpd); 
    $("#cek_nomor").attr("value",ceknomor);  
    $("#cek_tgl").attr("value",cektgl);  
    $("#cek_sp2d").attr("value",ceksp2d);  
    $("#cek_ket").attr("value",cekket);  
    $("#cek_rekawal").attr("value",cekrekawal);  
    $("#cek_nmrekawal").attr("value",ceknmrekawal);  
    $("#cek_rektuj").attr("value",cekrek_tuj);  
    $("#cek_giat").attr("value",cekgiat);  
    $("#cek_nmgiat").attr("value",ceknmgiat);  
}

function cekdata_list(){    
    var x = $('#dg').datagrid('getSelected');     
    var nomor = '';
    
    if(x==null){
        alert('List Data belum dipilih');
        exit();
    }
    
    var rows = $('#dg').datagrid('getSelections');  
    var jumlah_row = rows.length;
    
    if(jumlah_row>1){
        alert('Pilih hanya 1 List Data Transaksi');
        bersih_list();
        exit();
    }
    
    nomor   = rows[0].no_voucher;
    kdskpd  = rows[0].kd_skpd;
    
    if(nomor=='' || kdskpd==''){
        alert('List Data harus dipilih');
        bersih_list();
        exit();
    }
    
    $("#dialog-modal-cekdata").dialog('open');
    
    load_gridcekrek();    
    $(function(){ 
     $('#dg8').edatagrid({
		url: '<?php echo base_url(); ?>index.php/cms/ctransout_cms/load_dtransout',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     });
    
    load_gridcekpotongan();        
    $(function(){ 
     $('#dg9').edatagrid({
		url: '<?php echo base_url(); ?>index.php/ctrmpot/load_dtransout_trdmpot',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     });
    
    set_grid6();
    $(function(){ 
     $('#dg6').edatagrid({
		url: '<?php echo base_url(); ?>index.php/cms/ctransout_cms/load_dtransout_transfercms',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     });
     
}

function refresh_list(){    
    var x = $('#dg').datagrid('getSelected');     
    var nomor = '';
    
    if(x==null){
        alert('List Data belum dipilih');
        exit();
    }
    
    var rows = $('#dg').datagrid('getSelections');  
    nomor   = rows[0].no_voucher;
    kdskpd  = rows[0].kd_skpd;
    
    load_gridcekrek();    
    $(function(){ 
     $('#dg8').edatagrid({
		url: '<?php echo base_url(); ?>index.php/cms/ctransout_cms/load_dtransout',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     });
    
    load_gridcekpotongan();        
    $(function(){ 
     $('#dg9').edatagrid({
		url: '<?php echo base_url(); ?>index.php/ctrmpot/load_dtransout_trdmpot',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     });
    
    set_grid6();
    $(function(){ 
     $('#dg6').edatagrid({
		url: '<?php echo base_url(); ?>index.php/cms/ctransout_cms/load_dtransout_transfercms',
        queryParams:({no:nomor,skpd:kdskpd})
        });        
     });
     
}

function cekdata_kembali(){
    $("#dialog-modal-cekdata").dialog('close');
}

function proses_listcsv(){
    
    var nomor_upload = document.getElementById('no_upload').value;
    var kriteria = $('#tglvoucher').datebox('getValue');
    
    /*if(kriteria==''){
        var kriteria = $('#tglupload').datebox('getValue');
            if(kriteria==''){
                alert('Tanggal Belum dipilih !');
                exit();
            }        
    }*/
    
    if(nomor_upload==''){
        alert('List Data Upload belum dipilih');
        exit();
    }
    
    //urll ='<?php echo base_url(); ?>index.php/tukd_cms/csv_cmsbank/'+nomor_upload+'/'+kriteria;
    urll ='<?php echo base_url(); ?>index.php/tukd_cms/csv_cmsbank/'+nomor_upload;
    window.open(urll, '_blank');
    window.focus();
    
}

function proses_listcsv_lain(){
    
    var nomor_upload = document.getElementById('no_upload').value;
    var kriteria = $('#tglvoucher').datebox('getValue');
    
    /*if(kriteria==''){
        var kriteria = $('#tglupload').datebox('getValue');
            if(kriteria==''){
                alert('Tanggal Belum dipilih !');
                exit();
            }        
    }*/
    
    if(nomor_upload==''){
        alert('List Data Upload belum dipilih');
        exit();
    }
    
    //urll ='<?php echo base_url(); ?>index.php/tukd_cms/csv_cmsbank/'+nomor_upload+'/'+kriteria;
    urll ='<?php echo base_url(); ?>index.php/tukd_cms/csv_cmsbank_lain/'+nomor_upload;
    window.open(urll, '_blank');
    window.focus();
    
}

function proses_batalupload(){
    
    var x = $('#dg5').datagrid('getSelected');     
    var nomor = '';
    
    if(x==null){
        alert('List Data belum dipilih');
        exit();
    }
    
    var rows = $('#dg5').datagrid('getSelections');  
    var jumlah_row = rows.length;
    
    if(jumlah_row>1){
        alert('Pilih hanya 1 List Data Transaksi');
        exit();
    }
    
    nomor   = rows[0].no_voucher;
    nomor_up= rows[0].no_upload;
    kdskpd  = rows[0].kd_skpd;      
    
    var r = confirm("Apakah data yang akan di-Batalkan sudah benar ?");
     if (r == true) {                
     
     $(document).ready(function(){               
                $.ajax({
                    type: "POST",   
                    dataType : 'json',                 
                    data: ({tabel:'trdupload_cmsbank',no:nomor,noup:nomor_up,skpd:kdskpd}),
                    url: '<?php echo base_url(); ?>index.php/clist_upload/simpan_bataluploadcms',
                    success:function(data){                        
                        status = data.pesan;   
                         if (status=='1'){               
                            alert('Proses Batal Berhasil');	     
                            cari_batal();                                                                              					
                        } else{ 
                            alert('Proses Batal Gagal...!!!');
                        }                                             
                    }
                });
                });
     
     }else{
        alert('Silahkan Cek Kembali');
     }
}

     
    </script>

</head>
<body>

<div id="content">    
<div id="accordion">
<h3><a href="#" id="section1" >UPLOAD - DAFTAR TRANSAKSI NON TUNAI</a></h3>
    <div>
    <p align="center">         
    <table width="100%">
            <tr>
            <td><label><b>Tanggal Transaksi</b></label> :                         
            <input name="tglvoucher" type="text" id="tglvoucher" style="width:100px; border: 0;"/>            
            &nbsp; 
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
            </td>
            <td align="right"><label><b>Aksi</b></label> :            
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cekdata_list();" title="Hanya Pilih 1 List Data Transaksi">Lihat</a> &nbsp;
            <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:bersih_list();">Bersihkan List</a> &nbsp;
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:proses_list();">Proses Upload</a>  &nbsp;
            <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:section3();">Batal</a> &nbsp;
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:section2();">Draf</a>                        
            </td>
        </tr>        
        </table>
        <table id="dg" title="List Data Transaksi" style="width:860px;height:390px;"  >  
        </table>
        <table width="100%" style="text-align: right;">
            <tr>
            <td><label><b>Total Transaksi</b></label> : 
            <input name="total_trans" type="text" id="total_trans" style="text-align:right; width:200px; border: 0;" readonly="true"/>            
            </td>
            </tr>
			<tr>
            <td><label><b>Total Potongan</b></label> : 
            <input name="total_pot" type="text" id="total_pot" style="text-align:right; width:200px; border: 0;" readonly="true"/>
            </tr>
            <tr>
            <td><label><b>Sisa Saldo Bank</b></label> : 
            <input name="sisa_bank" type="text" id="sisa_bank" style="text-align:right; width:200px; border: 0;" readonly="true"/> 
                        
            </td>
            </tr>        
        </table>
        <font><b>Note : Warna Putih Belum diupload</b></font><br />
        <font color="green"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Warna Hijau sudah diupload</b></font><br />
        <font color="blue"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Warna Biru sudah divalidasi</b></font><br />
        <font><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No.Vo : Nomor Transaksi / Voucher</b></font><br />
    </p> 
    </div>   

<h3><a href="#" id="section2">DRAF ANTRIAN UPLOAD</a></h3>
   <div>
   <p align="center">  
   <table width="100%">
            <tr>
            <td><label><b>Tanggal Upload</b></label> :                         
            <input name="tglupload" type="text" id="tglupload" style="width:100px; border: 0;"/>            
            &nbsp; 
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari_upload();">Cari</a>
            </td>
            <td align="right"><label><b>Aksi</b></label> :            
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:lihat_list();">Lihat Data [CSV]</a> &nbsp;   
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:section_awal();">Daftar Transaksi</a>                                 
            </td>
        </tr>        
   </table>
   <table id="dg3" title="List Data Upload" style="width:860px;height:350px;"  >  
   </table>     
   <table width="100%" style="text-align: right;">
            <tr>
            <td><label><b>Total Upload</b></label> : 
            <input name="total_upload" type="text" id="total_upload" style="text-align:right; width:200px; border: 0;" readonly="true"/>            
            </td>
            </tr>                    
        </table>                       
   </p>
   </div>

<h3><a href="#" id="section3">BATAL UPLOAD</a></h3>
   <div>
   <p align="center">  
   <table width="100%">
            <tr>
            <td><label><b>Tanggal Upload</b></label> :                         
            <input name="tglvoucher_btl" type="text" id="tglvoucher_btl" style="width:100px; border: 0;"/>            
            &nbsp; 
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari_batal();">Cari</a>
            </td>            
            <td align="right"><label><b>Aksi</b></label> :            
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:lihat_batallist();">Lihat</a> &nbsp;   
            <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:bersih_batallist();">Bersihkan List</a> &nbsp;            
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:proses_batalupload();">Batal Upload</a> &nbsp;               
            <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:section_awal();">Daftar Transaksi</a>                                 
            </td>
        </tr>        
   </table>
   <table id="dg5" title="List Data Upload" style="width:860px;height:350px;"  >  
   </table>     
        <font><b>Note : Warna Biru sudah divalidasi</b></font><br />
        <font><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        URUT : Nomor UPLOAD</b></font><br />
        <font><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No.Vo : Nomor Transaksi / Voucher</b></font><br />        
   </p>
   </div>   
</div>
</div>

<div id="dialog-modal" title="List Data Upload">
    <fieldset>
        <table id="dg2" title="Data Transaksi" style="width:870px;height:280px;"  >  
        </table>
        <table width="100%" >
            <tr style="text-align: right;">
            <td><label><b>Total Transaksi</b></label> : 
            <input name="total_trans_cek" type="text" id="total_trans_cek" style="text-align:right; width:200px; border: 0;" readonly="true"/>            
            &nbsp;
            </td>
            <tr>
            <td><hr /></td>
            </tr>
            </tr>
            <tr style="text-align: center;">
            <td>
            <input type="hidden" name="no_upload" id="no_upload"/><input type="hidden" name="no_uploadhari" id="no_uploadhari"/>                          
            <a class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:proses_kembali();">Kembali</a> &nbsp;&nbsp;
            <a class="easyui-linkbutton" id="proses" iconCls="icon-add" plain="true" onclick="javascript:proses_upload_db();">Proses</a> &nbsp;&nbsp;
            <a class="easyui-linkbutton" id="csv" iconCls="icon-print" plain="true" onclick="javascript:proses_listcsv();">[Unduh CSV] Bank Kalbar</a>
            <a class="easyui-linkbutton" id="csv_lain" iconCls="icon-print" plain="true" onclick="javascript:proses_listcsv_lain();">[Unduh CSV] Di Luar Bank Kalbar</a>            
            </td>
            </tr>
        </table>           
    </fieldset>  
</div>

<div id="dialog-modal-cekdata" title="Review Data Transaksi">
    <fieldset>
        <table width="100%">
            <tr style="text-align: left;">
            <td><label><b>SKPD</b></label> </td> 
            <td colspan="5">: <input name="cek_skpd" type="text" id="cek_skpd" style="width:500px; border: 0;" readonly="true"/>&nbsp;</td>
            </tr>            
            <tr style="text-align: left;">
            <td><label><b>Nomor</b></label> </td>
            <td>: <input name="cek_nomor" type="text" id="cek_nomor" style="width:130px; border: 0;" readonly="true"/>&nbsp;</td>
            <td><label><b>Tanggal</b></label></td> 
            <td>: <input name="cek_tgl" type="text" id="cek_tgl" style="width:180px; border: 0;" readonly="true"/>&nbsp;</td>
            <td><label><b>SP2D</b></label> </td>
            <td>: <input name="cek_sp2d" type="text" id="cek_sp2d" style="width:210px; border: 0;" readonly="true"/>&nbsp;</td>
            </tr>
            <tr style="text-align: left;">
            <td><label><b>Keperluan</b></label> </td> 
            <td colspan="5">: <input name="cek_ket" type="text" id="cek_ket" style="width:500px; border: 0;" readonly="true"/>&nbsp;</td>
            </tr>
            <tr style="text-align: left;" hidden="true">
            <td><label><b>Rek. Bend.</b></label> </td> 
            <td>: <input name="cek_rekawal" type="text" id="cek_rekawal" style="width:130px; border: 0;" readonly="true"/>&nbsp;</td>
            <td><label><b>Rek. Tujuan</b></label> </td>
            <td>: <input name="cek_rektuj" type="text" id="cek_rektuj" style="width:160px; border: 0;" readonly="true"/>&nbsp;</td>
            <td><label><b>A.N Bank</b></label> </td> 
            <td>: <input name="cek_nmrekawal" type="text" id="cek_nmrekawal" style="width:210px; border: 0;" readonly="true"/> &nbsp;</td>
            </tr>
            <tr><td colspan="6"><hr /></td></tr>
            <tr style="text-align: left;">
            <td><label><b>Kegiatan</b></label> </td> 
            <td colspan="5">: <input name="cek_giat" type="text" id="cek_giat" style="width:500px; border: 0;" readonly="true"/>&nbsp;</td>
            </tr>
            <tr style="text-align: left;">
            <td></td> 
            <td colspan="5">  &nbsp;&nbsp;<input name="cek_nmgiat" type="text" id="cek_nmgiat" style="width:500px; border: 0;" readonly="true"/>&nbsp;</td>
            </tr>            
        </table> 
        <table id="dg8" title="Rekening Transaksi" style="width:870px;height:110px;"  >  
        </table>
        <table id="dg9" title="Rekening Potongan Transaksi" style="width:870px;height:110px;"  >  
        </table> 
        <table id="dg6" title="Rekening Tujuan Transfer" style="width:870px;height:140px;"  >  
        </table>         
        <p align="center">
        <a class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:cekdata_kembali();">Kembali</a> &nbsp;&nbsp;
        <a class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="javascript:refresh_list();">refresh</a> </p>                   
    </fieldset>  
</div>

</body>

</html>