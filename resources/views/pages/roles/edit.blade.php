@extends('layouts.master')

@section('title','Edit Role')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Edit Role</h3>
    </div>

     <div id="session" data-session="{{ session('success') }}"></div>

    <div class="card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Role</label>
                    <input type="text" class="form-control" name="name" value="{{$role->name}}">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection

@push('service')

@endpush
