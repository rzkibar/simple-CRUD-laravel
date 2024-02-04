@extends('layouts.main')

@push('css')
<link href="{{ URL::asset('assets/vendor/jquery-datatable/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/vendor/select2/css/select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/vendor/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css">

@endpush

@section('content')
<!-- <div class="block-header">
    <div class="row">
        <div class="col-lg-5 col-md-8 col-sm-12">
            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Adm. Vaksin</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active">Adm. Vaksin</li>
            </ul>
        </div>
    </div>
</div> -->

<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card planned_task">
            <div class="body">
              <button type="button" class="btn btn-outline-primary btnAddVaksin">Tambah Vaksin</button>
              <table class="table table-bordered table-hover js-basic-example dataTable table-custom" id="sample_1" style="width: 100%">
                  <thead>
                      <tr>
                          <th class="text-center" style="width:75%">Vaksin</th>
                          <th class="text-center" style="width:25%"></th>
                      </tr>
                  </thead>
              </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddVaksin">
    <div class="modal-dialog modal-st" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="defaultModalLabel">Vaksin Info</h5>
            </div>
            <form id="formData">
              <div class="modal-body">
                <div class="form-group">
                  <label class="control-label">vaksin</label>
                  <input type="hidden" id="id_vaksin" name="id">
                  <input type="text" class="form-control" name="vaksin" id="vaksin">
                  @csrf
  						  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLampiran">
    <div class="modal-dialog modal-st" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title" id="defaultModalLabel">Attachment</h5>
            </div>
            <form id="formUploadFile" autocomplete="off" enctype="multipart/form-data">
            @csrf
              <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <input type="file" id="file" name="file" class="form-control" placeholder="Input group example" aria-label="File Lampiran">
                              <button class="btn btn-outline-primary" type="submit">Upload File</button>
                            </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <hr>
                  <!-- <table class="table table-bordered table-hover js-basic-example dataTable" id="sample_file">
                    <thead>
                      <tr>
                        <th style="width:80%">
                           File Desc.
                        </th>
                        <th style="width:20%"></th>
                      </tr>
                    </thead>
                  </table> -->
              </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="{{ URL::asset('assets/vendor/jquery-datatable/datatables.min.js') }}" type="text/javascript" ></script>
<script src="{{ URL::asset('assets/vendor/jquery-datatable/dataTables.bootstrap.js') }}" type="text/javascript" ></script>
<script src="{{ URL::asset('assets/vendor/select2/js/select2.full.min.js') }}" type="text/javascript" ></script>
<script src="{{ URL::asset('assets/vendor/toastr/toastr.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.blockUI.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/vendor/bootbox/bootbox.min.js') }}" type="text/javascript"></script>


<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers : {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

  var table = $("#sample_1").DataTable({
    bLengthChange: false,
    ordering: false,
    processing: true,
    serverSide: true,
    ajax: APP_URL + "/master/vaksin/getdata",
    columns: [
      {
          data      : 'vaksin'
      },
      {
          data      : 'id',
          render    : function(data){
            return "<div class='btn-group btn-group-sm' role='group' aria-label='Small button group'>" +
                      "<button type='button' class='btn btn-default editData' value='" + data + "'>Edit</button>" +
                      "<button type='button' class='btn btn-default hapusData' value='" + data + "'>Hapus</button>" +
                      "<button type='button' class='btn btn-default lampiran' value='" + data + "'>lampiran</button>" +
                   "</div>";
          },
          className : 'text-center'
      }
    ],
    buttons: [
        {
            extend: 'excel',
            exportOptions: {
                columns: [0,1,2]
            }
        }
    ]
  });

  $('#sample_1_filter').hide();

  $(table.table().container()).on('keyup', 'thead input', function(index){

     table
         .column($(this).attr('id').substring(7,10))
         .search(this.value)
         .draw();
  });

  $('.btnAddVaksin').on('click', function(){

      $('#id_vaksin').val('');
      $('#vaksin').val('');
      $('#modalAddVaksin').modal('show');
  });

  $('#formData').on('submit', function(event){
      event.preventDefault();
      $.ajax({
          type : 'POST',
          url  : APP_URL + '/master/vaksin',
          data : $('#formData').serialize(),
          beforeSend: function() {
              $('#modalAddVaksin').modal('hide');
              $.blockUI({
								overlayCSS: { backgroundColor: '#005ba2' }
							});
            console.log('beforeSend');
          },
          success :  function(response){
              table.draw(false);
              $.unblockUI();
              toastr["success"]("Data berhasil disimpan!", "Notifikasi");
              console.log(response);
          },
          error: function(data){
            
              setTimeout(function() {
                  $('#modalData').modal('show');
              }, 1000);

              var msg     = data.responseJSON;
              var message = "";
              $.each(msg.errors, function(key, valueObj){
                  valueObj.forEach((item, i) => {
                      message += ". " + item + "<br>"
                  });
              });
              console.log(data);
              toastr["error"](message, "Error");
          }
      });
  });

  $('#sample_1').on('click', '.editData', function(){

      $.getJSON(APP_URL + "/master/vaksin/getitem/" + this.value, function(result){

          $('#id_vaksin').val(result.id);
          $('#vaksin').val(result.vaksin);

          $('#modalAddVaksin').modal('show');
      });
  });

  $('#sample_1').on('click', '.hapusData', function(){

    var id = this.value;
    bootbox.confirm("Hapus Data tsb?", function(result) {
      if(result){
        $.ajax({
            type : 'DELETE',
            url  : APP_URL + '/master/vaksin',
            data : "id=" + id + '&_token={{ csrf_token() }}',
            beforeSend: function() {
                $.blockUI({
                  overlayCSS: { backgroundColor: '#005ba2' }
                });
            },
            success :  function(response){
                $.unblockUI();
                toastr["success"]("Data berhasil dihapus!.", "Notifikasi");
                table.draw();
            },
            error: function(data){
                $.unblockUI();
                toastr["error"]("Masih terdapat Error!", "Error");
            }
        });
      }
    });
  });
  $('#sample_1').on('click', '.lampiran', function(e){
    e.preventDefault();
    $('#modalLampiran').modal('show');
  });

  $('#formUploadFile').on('submit', function(event){

    event.preventDefault();

    var formData = new FormData($("#formUploadFile")[0]);

    $.ajax({
        type : 'POST',
        url  : APP_URL + '/master/vaksin/storefile',
        processData: false,
        contentType: false,
        data : formData,
        beforeSend: function() {
            $('#modalLampiran').block({
                overlayCSS: { backgroundColor: '#005ba2' }
            });
        },
        success :  function(){
            $('#modalLampiran').unblock();
            //tableFile.draw(false);
            $('#formUploadFile').trigger('reset');
            toastr["success"]("File berhasil disimpan!.", "Notifikasi");
        },
        error: function(){
            console.log()
            $('#modalLampiran').unblock();
            toastr["error"]("Masih terdapat Error!", "Error");
        }
    });
  });
});
</script>


@endpush
