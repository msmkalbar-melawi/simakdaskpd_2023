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
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
   
    <script type="text/javascript"> 
    var nip='';
	var kdskpd='';
	var kdrek5='';
	
    $(document).ready(function() { 
      get_skpd();                                                            
    }); 
    
    $(function(){
	//$('#sskpd').combogrid({  
//		panelWidth:630,  
//		idField:'kd_skpd',  
//		textField:'kd_skpd',  
//		mode:'remote',
//		url:'<?php echo base_url(); ?>index.php/akuntansi/skpd',  
//		columns:[[  
//			{field:'kd_skpd',title:'Kode SKPD',width:100},  
//			{field:'nm_skpd',title:'Nama SKPD',width:500}    
//		]],
//		onSelect:function(rowIndex,rowData){
//			kdskpd = rowData.kd_skpd;
//			$("#nmskpd").attr("value",rowData.nm_skpd);
//			$("#skpd").attr("value",rowData.kd_skpd);
//			//validate_giat();
//		}  
//		}); 
         $('#dcetak').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        });
        
         $('#dcetak2').datebox({  
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
            $('#ttd1').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/PPK',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},
                    {field:'nama',title:'Nama',width:400}
                ]],  
           onSelect:function(rowIndex,rowData){
               $("#nm_ttd1").attr("value",rowData.nama);
           } 
            });

		$('#tgl_ttd').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
        }); 
			
         
            $('#ttd2').combogrid({  
                panelWidth:600,  
                idField:'nip',  
                textField:'nip',  
                mode:'remote',
                url:'<?php echo base_url(); ?>index.php/tukd/load_ttd/PA',  
                columns:[[  
                    {field:'nip',title:'NIP',width:200},
                    {field:'nama',title:'Nama',width:400}
                ]],  
           onSelect:function(rowIndex,rowData){
               $("#nm_ttd2").attr("value",rowData.nama);
           } 
            });          
         });
	

        function get_skpd()
        {
        
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
						$("#sskpd").attr("value",data.kd_skpd);
						$("#nmskpd").attr("value",data.nm_skpd);
						$("#skpd").attr("value",data.kd_skpd);
						kdskpd = data.kd_skpd;
        			}                                     
        	});  
        }


		function cetak(ctk){
			var dcetak = $('#dcetak').datebox('getValue');      
			var dcetak2 = $('#dcetak2').datebox('getValue');      
			var skpd   = kdskpd; 
			var ctglttd = $('#tgl_ttd').datebox('getValue');
			var ttd1   = $("#ttd1").combogrid('getValue');
			var ttd2   = $("#ttd2").combogrid('getValue'); 
			var spasi = document.getElementById('spasi').value;  

			if(ctglttd==''){
			alert('Tanggal tidak boleh kosong!');
			exit();
			}
			if(ttd1==''){
				alert('Bendahara Pengeluaran tidak boleh kosong!');
				exit();
			}
			if(ttd2==''){
				alert('Pengguna Anggaran tidak boleh kosong!');
				exit();
			}
			var ttd_1 =ttd1.split(" ").join("123456789");
			var ttd_2 =ttd2.split(" ").join("123456789");
			var url    = "<?php echo site_url(); ?>tukd2/ctk_jurnal_koreksi2";  
			window.open(url+'/'+dcetak+'/'+dcetak2+'/'+skpd+'/'+ctglttd+'/'+ttd_1+'/'+ttd_2+'/'+spasi+'/'+ctk, '_blank');
			window.focus();
        }

    </script>

    <STYLE TYPE="text/css"> 
		 input.right{ 
         text-align:right; 
         } 
	</STYLE> 

</head>
<body>

<div id="content">

<div id="accordion">

<h3>CETAK JURNAL UMUM</h3>
    <div>
    <p align="right">         
        <table id="sp2d" title="Cetak Buku Besar" style="width:870px;height:300px;" >  
		<tr >
			<td width="20%" height="40" ><B>SKPD</B></td>
			<td width="80%"><input id="sskpd" name="sskpd" readonly="true" style="width: 150px; border: 0;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="nmskpd" name="nmskpd" readonly="true" style="width: 500px; border:0;" /></td>
		</tr>
        
		<tr >
			<td width="20%" height="40" ><B>PERIODE</B></td>
			<td width="80%"><input id="dcetak" name="dcetak" type="text"  style="width:155px" />&nbsp;&nbsp;s/d&nbsp;&nbsp;<input id="dcetak2" name="dcetak2" type="text"  style="width:155px" /></td>
		</tr>
		<tr >
			<td width="20%" height="40" ><B>TANGGAL TTD</B></td>
			<td width="80%"><input id="tgl_ttd" name="tgl_ttd" style="width: 150px;" /></td>
		</tr>
		<tr>
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
							<td width="20%">PPK</td>
                            <td><input type="text" id="ttd1" style="width: 200px;" /> &nbsp;&nbsp;
							<input type="text" id="nm_ttd1" readonly="true" style="width: 200px;border:0" /> 
							
                            </td> 
                        </table>
                </div>
        </td> 
		</tr>
		<tr>
		<td colspan="4">
                <div id="div_bend">
                        <table style="width:100%;" border="0">
							<td width="20%">Pengguna Anggaran</td>
                            <td><input type="text" id="ttd2" style="width: 200px;" /> &nbsp;&nbsp;
							<input type="nm_ttd2" id="nm_ttd2" readonly="true" style="width: 200px;border:0" /> 
							
                            </td> 
                        </table>
                </div>
        </td> 
		</tr>
		<tr >
			<td width="20%" height="40" ><B>SPASI</B></td>
			<td width="80%"><input type="number" id="spasi" name="spasi" style="width:150px;" value="4"/></td>
		</tr>
		<tr >
			<td width="20%" height="40" >&nbsp;</td>
			<td width="80%"> <INPUT TYPE="button" VALUE="LAYAR" ONCLICK="cetak(0)" style="height:40px;width:100px" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE="button" VALUE="PDF" ONCLICK="cetak(1)" style="height:40px;width:100px" >
			</td>
		</tr>
		<tr >
			<td >&nbsp;</td>
			<td >&nbsp;</td>
		</tr>
        </table>                      
    </p> 
    </div>
</div>
</div>

 	
</body>

</html>