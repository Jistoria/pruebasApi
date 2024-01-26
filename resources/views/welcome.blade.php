<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- <form action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*">
        <button type="submit">Subir imagen</button>
    </form>
    @if (session('success'))
        <h1>{{ session('success') }}</h1>
    @endif --}}
    @if (session('info'))
        <h1>{{ session('info') }}</h1>
    @endif
    @if (session('success'))
        <h1>{{ session('success') }}</h1>
    @endif
    @if (session('error'))
        <h1>{{ session('error') }}</h1>
    @endif
    @guest
    <form action="{{route('user.register')}}" method="post">
        <h2>Registro</h2>
        name
        @csrf
        <input type="text" name="name" id="name">
        email
        <input type="email" name="email" id="email">
        password
        <input type="password" name="password" id="password">
        <button type="submit" >Registrarse</button>
    </form>
    {{-- <form action="{{route('user.login')}}" method="post">
        <h2>login</h2>
        name
        @csrf
        email
        <input type="email" name="email" id="email">
        password
        <input type="password" name="password" id="password">
        <button type="submit" >Login</button>
    </form> --}}
    @endguest
    @auth
    <div>
        {{ Auth::user()->name }}
    </div>

    @if (Auth::user()->unreadNotifications->count() > 0)
        <div>
            <h4>Notificaciones no leídas:</h4>
            <ul>
                @foreach (Auth::user()->unreadNotifications as $notification)
                    <li>{{ $notification->data['message'] }}</li>
                    {{-- Marcar la notificación como leída --}}
                    {{ $notification->markAsRead() }}
                @endforeach
            </ul>
        </div>
    @else
        <p>No tienes notificaciones no leídas.</p>
    @endif
@endauth

    
</body>
</html>