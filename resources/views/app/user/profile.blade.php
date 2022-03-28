@extends('layouts.app')

@section('pagetitle', 'Profile')

@section('content')
<form action="{{$urlAction}}" method="POST">
    @csrf
    @if (isset($user))
    <div class="card shadow mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            @if (($isReadonly))
            <a href="{{route('user.edit', $user->id)}}" class="btn btn-primary btn-icon-split m-2">
                <span class="icon text-white-50"> <i class="fa-solid fa-pen-to-square"></i> </span>
                <span class="text">Edit Profile</span>
            </a>
            @endif
            <button type="button" class="btn btn-secondary btn-icon-split m-2" data-bs-toggle="modal" data-bs-target="#changePasswrodModal">
                <span class="icon text-white-50"> <i class="fa-solid fa-key"></i> </span>
                <span class="text">Change Password</span>
            </button>
        </div>
    </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Data') }}</h6>
        </div>
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Name<b class="required">*</b>: </label>
                <div class="col-sm-10">
                    <input id="name" name="name" value="{{isset($user)?$user->name:''}}" class="form-control" type="text" placeholder="ex: Your Name" required {{($isReadonly)?'disabled':''}}>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Email<b class="required">*</b>: </label>
                <div class="col-sm-10">
                    <input id="email" name="email" value="{{isset($user)?$user->email:''}}" class="form-control" type="email" placeholder="ex: user@institution.com" required {{($isReadonly)?'disabled':''}}>
                </div>
            </div>
            @isset($pwd)
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Password<b class="required">*</b>: </label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input id="password" name="password" value="{{$pwd}}" class="form-control" type="text" required readonly="readonly">
                        <button class="btn btn-primary" type="button" onclick="copy()"><i class="fa-solid fa-copy"></i></button>
                    </div>
                    <div id="emailHelp" class="form-text">Please keep the generated password save, and change it soon!</div>
                </div>
            </div>
            @endisset
        </div>
    </div>
    @if ((!$isReadonly))
    <div class="card shadow mb-4">
        <div class="card-body">
            <div style="float: right;">
                <a href="{{$urlBack}}" class="btn btn-secondary">Cancel/Back</a>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    @endif
</form>

<div class="modal fade" id="changePasswrodModal" tabindex="-1" aria-labelledby="changePasswrodModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswrodModalTitle">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm" action="{{route('user.update.password', $user->id)}}" method="post">
                    @method('post')
                    @csrf
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Old Password<b class="required">*</b>: </label>
                        <div class="col-sm-9">
                            <input id="oldpassword" name="oldpassword" class="form-control" type="password" placeholder="ex: my secret" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">New Password<b class="required">*</b>: </label>
                        <div class="col-sm-9">
                            <input id="password" name="password" class="form-control" type="password" placeholder="ex: my new secret" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Confirm Password<b class="required">*</b>: </label>
                        <div class="col-sm-9">
                            <input id="password-confirm" name="password_confirmation" class="form-control" type="password" placeholder="ex: my new secret" required autocomplete="new-password">
                        </div>
                    </div>
                    <div>
                        <div style="float: right;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function copy() {
        try {
            let copyText = document.querySelector("#password");
            copyText.select();
            document.execCommand("copy");
            alert(`password copied, please keep it save and change it soon!`)
        } catch (error) {
            alert("failed to copy, please copy it manually!")
        }
    }
</script>
@endsection