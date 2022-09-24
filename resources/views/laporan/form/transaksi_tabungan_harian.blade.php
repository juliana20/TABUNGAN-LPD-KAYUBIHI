@extends('themes.gentelella.template.template')
@section('content')
<div class="col-sm-6 col-sm-offset-3 col-xs-12">
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$title }}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-12">
            <form  method="POST" action="{{ url(@$url_print) }}" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Tanggal</label>
                <div class="col-md-9">
                    <input type="date" class="form-control" name="f[date]" required value="{{ @$item->date}}">
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Kolektor</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select name="f[kolektor]" class="form-control" id="kolektor">
                  <option value="">-- Semua --</option>
                  <?php foreach(@$kolektor as $dt): ?>
                    <option value="<?php echo @$dt->id ?>"><?php echo @$dt->nama ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label"></label>
                <div class="col-md-9">
                    <button type="sumbit" formtarget="_blank" class="btn btn-success btn-block" data-dismiss="modal"><i class="fa fa-print" aria-hidden="true"></i> Preview PDF</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  </div>
</div>

@endsection