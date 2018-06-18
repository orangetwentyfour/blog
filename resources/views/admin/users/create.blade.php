@extends("layout_admin.master")
@section('title', 'Create User')
@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="w-50 p-3 m-3 bg-light">
            <form action="{{route('users.store')}}" method="post">
                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                    @endif
                </div>
                {{csrf_field()}}
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label for="">Confirm Email</label>
                    <input type="email" class="form-control" name="email_confirmation">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
                <div class="form-group">
                    <label for="">Set Role</label>
                    <select name="role" class="form-control">
                        @foreach($roles as $role)
                            <option value="{{$role->role_code}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('users.index')}}" class="btn text-light btn-danger">Cancel</a>
                </div>
            </form>
        </div>

    </div>
@endsection