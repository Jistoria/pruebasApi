<?php

namespace App\Http\Controllers;

use App\Events\UserVerified;
use App\Events\Verified;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validar los datos del formulario si es necesario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Crear un nuevo usuario
        $new_user = new User;
        $new_user->name = $request->input('name');
        $new_user->email = $request->input('email');
        $new_user->password = $request->input('password');
        $new_user->save();
          // Enviar correo electrónico de verificación
        $new_user->sendEmailVerificationNotification();
        // Puedes autenticar al usuario automáticamente si lo deseas
        // auth()->login($new_user);

        // Redireccionar a la página de inicio o a donde desees después de registrar al usuario
        return response()->json(['success' => true, 'message' => 'usuario creado exitosamente'], Response::HTTP_CREATED);
    }

    public function verify($id, $hash)
    {
        // Buscar al usuario por ID
        $user = User::find($id);

        // Verificar si el usuario existe y si el hash es correcto
        if (!$user || sha1($user->getEmailForVerification()) !== $hash) {
            return response()->json(['success'=>false, 'message'=>'enlace no válido']);
        }

        // Verificar si el usuario ya ha sido verificado
        if ($user->hasVerifiedEmail()) {
            return response()->json(['success'=>true, 'message'=>'Este correo electrónico ya ha sido verificado previamente.']);
        }

        // Verificar el correo electrónico del usuario
        $user->markEmailAsVerified();

        // Generar un evento de verificación
        event(new UserVerified($user));

        // Redireccionar a donde desees después de la verificación
        return response()->json(['success'=>true, 'message'=>'Se ha verificado el email']);
    }

    public function login(Request $request)
    {
        // Validación básica de datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Obtener el usuario autenticado
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);

        // Obtener el número de notificaciones del usuario
        $notificationsCount = $user->unreadNotifications->count();
        $user = [
            'name'=> $user->name,
            'email'=> $user->email,
        ];
        // Retornar una respuesta JSON con éxito y el usuario
        // return response(['token'=>$token], Response::HTTP_OK)->withCookie(($cookie));
        return response(['token'=>$token, 'user'=> $user, 'countN'=>$notificationsCount], Response::HTTP_OK)->withCookie(($cookie));
        } else {
            // La autenticación ha fallado
            return response(['success'=>false, 'message'=>'Credenciales invalidas'], Response::HTTP_UNAUTHORIZED);
        }
    }
    public function userNotifications(Request $request){
        $notifications = auth()->user()->notifications;
        return response()->json(['notifications'=>$notifications],Response::HTTP_OK);
    }

    public function getUser (Request $request){
        return response()->json([
            'message'=> "Obteniendo Usuario",
            'user'=> auth()->user()
        ],Response::HTTP_OK);
    }
    public function logout ()
    {
        auth()->user()->tokens()->delete();
        $cookie = Cookie::forget('cookie_token');
        return response(['message' => 'Cerró Sesión'], Response::HTTP_OK)->withCookie($cookie);
    }
}

