@extends('layouts.master-admin')

@section('title','create user')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Create User</h3>
    </div>

     <div id="session" data-session="{{ session('success') }}"></div>

    <div class="card-body">
        <form action="{{ route('user.update', $user->id) }}" method="POST">
             @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                </div>
                 <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" value="{{$user->username}}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <input type="password" class="form-control" name="password"  placeholder="Leave blank if not changed">
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection

@push('service')

@endpush
