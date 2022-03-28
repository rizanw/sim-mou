<!DOCTYPE html>
<html>

<head>
    <title>Welcome to {{config('app.name')}}</title>
</head>

<body class="bg-light">
    <div class="container">
        <img class="ax-center my-10 w-24" src="{{config('app.url').'/img/logo.png'}}" />
        <div class="card p-6 p-lg-10 space-y-4">
            <h1 class="h3 fw-700"> Welcome to {{config('app.name')}} </h1>
            <p>
                Hi, {{$user['name']}}.<br />
                We are warm welcome you to {{config('app.name')}}.<br />
                Here's your access:
            </p>
            <ul>
                <li>{{ $user['email'] }}</li>
                <li>{{ $user['pwd'] }}</li>
            </ul>
            <p>
                Please change your password as soon as possible!
            </p>
            <a class="btn btn-primary p-3 fw-700" href="{{route('login')}}">Login</a>
        </div>
    </div>
</body>

</html>