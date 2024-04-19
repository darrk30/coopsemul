<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Validar los inputs
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'DNI' => ['required', 'string', 'max:8'],
            'apellidos' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Verificar si el DNI ya existe y es válido
        $dniValid = $this->validateDNI($input['DNI']);
        if (!$dniValid) {
            throw new \Exception("El DNI no es válido o ya está registrado.");
        }

        // Crear el usuario y su perfil asociado
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->profile()->create([
            'DNI' => $input['DNI'],
            'apellidos' => $input['apellidos'],
            'status' => 1,
        ]);

        return $user;
    }

    /**
     * Verifica si un DNI ya existe en la base de datos y es válido mediante API.
     *
     * @param string $dni
     * @return bool
     */
    private function validateDNI($dni)
    {
        if (Profile::where('DNI', $dni)->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'DNI' => 'El DNI ingresado ya está registrado.'
            ]);
        }

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imxvc3F1ZW1hc3NhYmVucGVydUBnbWFpbC5jb20ifQ.oV8N66H2LLYMu7Jh-zOFmJDGOWyJ6SqNp2QJ0t5ikmg';
        $url = "https://dniruc.apisperu.com/api/v1/dni/$dni?token=$token";

        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (empty($data) || !isset($data['success']) || !$data['success']) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'DNI' => 'El DNI ingresado no es válido.'
                ]);
            }
        } catch (\Exception $e) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'DNI' => 'Hubo un error al verificar el DNI. Por favor, inténtalo de nuevo.'
            ]);
        }

        return true;
    }
}
