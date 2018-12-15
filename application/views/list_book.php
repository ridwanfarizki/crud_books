<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<!--JQUERY-->
	<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js'); ?>"></script>	
	<!--BOOTSTRAP-->
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/bootstrap.min.css'); ?>">
	<script src="<?php echo base_url('assets/bootstrap/bootstrap.min.js'); ?>"></script>
	<!--BOOTSTRAP DATEPICKER-->
	<link rel="stylesheet" href="<?php echo base_url('assets/datepicker/bootstrap-datepicker3.min.css'); ?>">
	<script src="<?php echo base_url('assets/datepicker/bootstrap-datepicker.min.js'); ?>"></script>
	<!--DATATABLE BOOTSTRAP-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/dataTables.bootstrap.min.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/jquery.dataTables.min.css'); ?>"/>
	
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/jquery.dataTables.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/dataTables.bootstrap.min.js'); ?>"></script>
	<meta charset="utf-8">
	<title>Mplus | Programming Test</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/android-icon-36x36_0.png'); ?>" type="image/png" />
</head>
<body>
	<style type="text/css">
		.dataTables_wrapper .dataTables_paginate .paginate_button {
			padding: 0px;
		}
	</style>
<div class="container">
	<div class="row">
		<div class="col-md-12" style="border:1px solid #000; border-radius: 20px; margin:10px 0px;;">
        	<h3><img src="<?php echo base_url('assets/img/logo_big.png'); ?>" style="vertical-align:bottom;"/> | Programming Test (CRUD on a list of books)</h3>
        </div>
        <div class="col-md-12">
        	<div class="row">
        		<div class="col-md-3" style="min-height:72px;">
			        <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Book</button>
			        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
		    	</div>
		    	<div class="col-md-9">
		    		<div class="alert alert-dismissible message" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Info!</strong> <span class="detail-message"></span>.
					</div>
		    	</div>
	    	</div>	
	    </div>
    </div>
    <div class="row" style="margin-top:10px;">
    	<div class="col-md-12">
	        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
	                <tr>
	                    <th>Title</th>
	                    <th>Author</th>
	                    <th>Date Published</th>
	                    <th>Number of Pages</th>
	                    <th>Type of Book</th>
	                    <th style="width:125px;">Action</th>
	                </tr>
	            </thead>
	            <tbody>
	            </tbody>
	 
	            <tfoot>
	            <tr>
	                <th>Title</th>
	                <th>Author</th>
	                <th>Date Published</th>
	                <th>Number of Pages</th>
	                <th>Type of Book</th>
	                <th>Action</th>
	            </tr>
	            </tfoot>
	        </table>
	    </div>
    </div>
 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
	$('.message').hide();
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('mplus/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,  
        changeMonth: true,
    	changeYear: true,
    });
 
    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
 
});
 
 
 
function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.datepicker').val("").datepicker("update");
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('[name="title"]').attr('autofocus',true); 
    $('.modal-title').text('Add Book'); // Set Title to Bootstrap modal title
}
 
function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('mplus/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="title"]').val(data.title);
            $('[name="author"]').val(data.author);
            $('[name="type_of_book"]').val(data.type_of_book);
            $('[name="number_of_pages"]').val(data.number_of_pages);
            $('[name="date_published"]').datepicker('update',data.date_published);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Book '+data.title); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    $('.detail-message').text('');
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('mplus/ajax_add')?>";
    } else {
        url = "<?php echo site_url('mplus/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                $('.message').removeClass('alert-danger');
                $('.message').addClass('alert-success');
                $('.detail-message').text(data.message);
                $(".message").fadeTo(2000, 500).slideUp(500, function(){
	               $(".message").slideUp(500);
	            });
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}
 
function delete_person(id)
{
	$('.detail-message').text('');
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('mplus/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                $('.message').removeClass('alert-success');
                $('.message').addClass('alert-danger');
                $('.detail-message').text(data.message);
                $(".message").fadeTo(2000, 500).slideUp(500, function(){
	               $(".message").slideUp(500);
	            });
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}
 
</script>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title</label>
                            <div class="col-md-9">
                                <input name="title" placeholder="Title" class="form-control" type="text" autofocus>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Author</label>
                            <div class="col-md-9">
                                <input name="author" placeholder="Author" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date Published</label>
                            <div class="col-md-9">
                                <input name="date_published" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" autocomplete="off">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Number of Pages</label>
                            <div class="col-md-9">
                                <input name="number_of_pages" placeholder="Number of Pages" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Type of Book</label>
                            <div class="col-md-9">
                                <select name="type_of_book" class="form-control">
                                    <option value="">--Select Type of Book--</option>
                                    <option value="One of novel">one of novel</option>
                                    <option value="Documentation">Documentation</option>
                                    <option value="Other">Other</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>