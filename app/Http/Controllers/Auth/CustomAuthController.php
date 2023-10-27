<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomAuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Iniciar sesión",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email", "password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="erik@academlo.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="secret12"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\Header(
     *             header="Set-Cookie",
     *             description="Cookie de autenticación",
     *             @OA\Schema(type="string")
     *         ),
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Inicio de sesión exitoso"
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        // Lógica de autenticación de Laravel Fortify
    }

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Registrar un nuevo usuario",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name", "email", "password", "password_confirmation", "company"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Max"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="max@maximus.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="max12345"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     format="password",
     *                     example="max12345"
     *                 ),
     *                 @OA\Property(
     *                     property="company",
     *                     type="string",
     *                     example="Maximus"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario registrado exitosamente",
     *         @OA\Header(
     *             header="Set-Cookie",
     *             description="Cookie de autenticación",
     *             @OA\Schema(type="string")
     *         ),
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Usuario registrado exitosamente"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function register(Request $request)
    {
        // Lógica para registrar un nuevo usuario
    }
    /**
     * @OA\Post(
     *     path="/api/v1/forgot-password",
     *     summary="Restablecer contraseña",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="erik@academlo.com"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Correo de restablecimiento de contraseña enviado",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Correo de restablecimiento de contraseña enviado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function forgotPassword(Request $request)
    {
        // Lógica para solicitar el restablecimiento de contraseña
    }

    /**
     * @OA\Post(
     *     path="/api/v1/reset-password",
     *     summary="Restablecer contraseña",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"token", "email", "password", "password_confirmation"},
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                     example="00a9609516e286dc05f09473a423911376ac0a216f881b3eb9f93204541c2a37"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="erik@academlo.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="secret12"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     format="password",
     *                     example="secret12"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contraseña restablecida exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Contraseña restablecida exitosamente"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function resetPassword(Request $request)
    {
        // Lógica para restablecer la contraseña
    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="Cerrar sesión",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Sesión cerrada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Sesión cerrada exitosamente"
     *             )
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        // Lógica para cerrar la sesión del usuario
    }
}
