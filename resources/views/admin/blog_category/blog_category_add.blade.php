@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Blog Category Add </h4> <br>

            <form method="post" action="{{ route('store.blog.category') }}">
                @csrf



            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Category Name</label>
                <div class="col-sm-10">
                    <input name="category" class="form-control" type="text" id="example-text-input">
                    @error('category')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <!-- end row -->

<input type="submit" class="btn btn-info waves-effect waves-light" value="Insert Blog Data">
            </form>



        </div>
    </div>
</div> <!-- end col -->
</div>



</div>
</div>


@endsection 