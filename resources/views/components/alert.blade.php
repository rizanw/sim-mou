@if ($message = Session::get('success'))
<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-check" style="margin-right: 10px;"></i>
    <strong> {{ $message }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
    <strong> {{ $message }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif