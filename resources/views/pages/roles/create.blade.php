@extends('layouts.master')

@section('title','create Role')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Create Role</h3>
    </div>

     <div id="session" data-session="{{ session('success') }}"></div>

    <div class="card-body">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Role</label>
                    <input type="text" class="form-control" name="name" required>
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
