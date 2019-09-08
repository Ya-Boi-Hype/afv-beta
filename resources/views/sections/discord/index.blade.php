@extends('layouts.master')
@section('title', 'My Discord')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h1 class="m-0 text-dark">Discord Settings</h1>
      </div>
      <div class="card-body">
      <div class="card">
        <div class="card-header">
          <h1 class="m-0 text-dark">Preferred Discord Name</h1>
          <small>Select your preferred name to be shown on the server</small>
        </div>
        <div class="card-body">
          <form class="form-horizontal" method="POST" action="{{ route('discord.update', auth()->user()->discord) }}">
            @csrf
            @method('PATCH')
            <div class="row">
              <div class="col-lg-12">
                <select class="w-100 bg-light" id="view_range">
                  <option value="1">{{ auth()->user()->discord->mode1 }}</option>
                  <option value="2">{{ auth()->user()->discord->mode2 }}</option>
                  <option value="3">{{ auth()->user()->discord->mode3 }}</option>
                </select>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row mt-3 text-center">
              <div class="col-12">
                <button type="submit" class="btn btn-success w-100">Save</button>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </form>
        </div>
      </div>
      <!-- /.card -->
      </div>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@endsection