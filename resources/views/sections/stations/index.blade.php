@extends('layouts.master')
@section('title', 'Stations')

@section('head')
  @parent
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
@endsection

@section('content')
<!-- Main content -->
<div class="content-header">
  <div class="col">
    <div class="card w-100">
      <div class="card-header">
        <h1 class="text-dark">Stations</h1>
      </div>
      <!-- /.card-header -->
      <div class="card-body row">    
        <div class="col-12 card">
          <div class="card-header">
            Search
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form class="form-horizontal" method="GET" action="{{ route('stations.index') }}">
              <input type="text" class="form-control text-uppercase @error('search') is-invalid @enderror" name="search" placeholder="LON_CTR" value="{{ old('search') }}">
              <button type="submit" class="btn btn-success mt-3 w-100">Search</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.col -->

        <div class="col-12 card mt-3">
          <div class="card-header">
            Create
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('stations.store') }}">
              @csrf
              <div class="row">
                <div class="col-12 mt-3 mt-md-auto">
                  <input type="text" class="form-control text-uppercase @error('name') is-invalid @enderror" name="name" placeholder="LON_CTR" value="{{ old('name') }}" required>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row mt-3 text-center">
                <div class="col-12">
                  <button type="submit" class="btn btn-success w-100">Create</button>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.content-header -->
@endsection