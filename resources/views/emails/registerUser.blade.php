@component('mail::message')
# Welcome to {{config('app.name')}}

Hi, {{$user['name']}}.   
We are warm welcome you to {{config('app.name')}}.   
Here's your access:    
- {{ $user['email'] }}    
- {{ $user['pwd'] }}     
    
Please change your password as soon as possible!    

@component('mail::button', ['url' => route("login")])
Login
@endcomponent
@endcomponent
