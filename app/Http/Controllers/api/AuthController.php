<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\todos\Controller;
use App\Models\Escolta;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Lista;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'restablecerContrasena']]);
        $this->auth = auth()->guard('api');
    }

    public function login()
    {
        $credentials = request(['documento', 'password']);
        if (!$token = $this->auth->attempt($credentials))
            return response()->json(['error' => 'Credenciales erróneas']);
        if (!empty(request('token_firebase')))
            $this->setTokenFirebase(request('token_firebase'));
        return $this->respondWithToken($token);
    }

    public function setTokenFirebase(string $tokenFirebase)
    {
        $user = $this->auth->user();
        $user->token_firebase = $tokenFirebase;
        $user->save();
    }

    public function me()
    {
        return response()->json(['response' => $this->auth->user()]);
    }

    public function logout()
    {
        $this->auth->logout();
        return response()->json(['response' => 'Cierre de sesión exitoso']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->auth->refresh());
    }

    protected function respondWithToken($token)
    {
        if (($this->auth->user()->perfil_id ?? 0) != 4)
            return response()->json(['error' => 'No tienes permisos']);
        $user = $this->auth->user();
        $user->escolta_id = $user->escolta_id ?? -1;
        if ($escolta = $user->escolta) {
            foreach (['banco', 'tipo_cuenta', 'empresa'] as $campo) {
                $user->{"{$campo}_nombre"} = $escolta->$campo->nombre ?? null;
            }
            $user->numero_cuenta = $escolta->numero_cuenta;
        }
        $user->foto = '';
        $user->adicional = $user->descripcion_zona ?? '';
        $user->max_novedades = 2;
        if (is_dir($rutaFoto = "storage/fotos_escoltas/{$user->escolta_id}")) {
            $rutaCompleta = public_path($rutaFoto);
            $adjunto = array_diff(scandir($rutaCompleta), ['..', '.']);
            if (isset($adjunto[2]))
                $user->foto = asset("{$rutaFoto}/{$adjunto[2]}");
        }
        return response()->json([
            'response' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => $user
            ]
        ]);
    }

    protected function restablecerContrasena(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $url = url('password/email');
                $client = new Client();
                $res = $client->request('POST', $url, [
                    'form_params' => [
                        'email' => $user->email
                    ]
                ]);
                $res->getBody();
                return response()->json(['response' => ['mensaje' => 'Se ha enviado un enlace a su correo con instrucciones para restablecer su contraseña']]);
            }
            return response()->json(['error' => ['mensaje' => 'El correo ingresado no se encuentra registrado en el sistema']]);
        } catch (\Throwable $th) {
            return response()->json(['error' => ['mensaje' => $th->getMessage()]]);
        }
    }

    protected function actualizarFoto(Request $request)
    {
        try {
            $escolta = $this->auth->user()->escolta;
            $escolta->cargarFoto($request->file('imagen'), true);
            return response()->json(['response' => asset($escolta->ruta_foto)]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    protected function actualizarDatos(Request $request)
    {
        try {
            foreach ($request->only('tipo_cuenta_nombre', 'banco_nombre', 'empresa_nombre') as $key => $campo) {
                switch ($key) {
                    case 'tipo_cuenta_nombre':
                        $id = 12;
                        break;
                    case 'banco_nombre':
                        $id = 11;
                        break;
                    case 'empresa_nombre':
                        $id = 10;
                        break;
                }
                $arrCampos[str_replace('nombre', 'id', $key)] = Lista::findByNombre($campo, $id)->id;
            }
            $arrCampos['numero_cuenta'] = $request->numero_cuenta;
            $escolta = $this->auth->user()->escolta;
            $escolta->update($arrCampos);
            return response()->json(['response' => ['mensaje' => 'Se han actualizado los datos satisfactoriamente']]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
