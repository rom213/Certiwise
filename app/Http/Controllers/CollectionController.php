<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CollectionPostRequest;

class CollectionController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/v1/{tenant}/collections",
 *     summary="Obtener lista de colecciones",
 *     tags={"Collection"},
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         description="ID del inquilino",
 *         required=true,
 *         example="Academlo",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Número de colecciones por página",
 *         required=false,
 *         @OA\Schema(type="integer", format="int32", default=10)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de colecciones",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Lista de colecciones"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     ),
 * )
 */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', env('DEFAULT_PER_PAGE',10));
        $collections = Collection::paginate($perPage);
        return Response($collections, 200);
    }
/**
 * @OA\Post(
 *     path="/api/v1/{tenant}/collections",
 *     summary="Crear una nueva colección",
 *     tags={"Collection"},
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         description="ID del inquilino",
 *         required=true,
 *         example="Academlo",

 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"name", "description"},
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Colección de muestra"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string",
 *                     example="Descripción de la colección"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Colección creada exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Colección creada exitosamente"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     ),
 *
 * )
 */

    public function store(CollectionPostRequest $request)
    {
        $collection = Collection::create($request->all());
        return Response($collection, 201);
    }

    /**
 * @OA\Get(
 *     path="/api/v1/{tenant}/collections/{id}",
 *     summary="Obtener detalles de una colección",
 *     tags={"Collection"},
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         description="ID del inquilino",
 *         required=true,
 *         example="Academlo",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la colección",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Detalles de la colección",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Detalles de la colección"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Colección no encontrada"
 *     ),
 *
 * )
 */

    public function show($id)
    {
        $collection = Collection::findOrFail($id);
        return Response($collection, 200);
    }

    /**
 * @OA\Put(
 *     path="/api/v1/{tenant}/collections/{id}",
 *     summary="Actualizar una colección existente",
 *     tags={"Collection"},
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         description="ID del inquilino",
 *         required=true,
 *         example="Academlo",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la colección",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"name", "description"},
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Colección actualizada"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string",
 *                     example="Descripción actualizada de la colección"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Colección actualizada exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Colección actualizada exitosamente"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Colección no encontrada"
 *     ),
 *
 * )
 */

    public function update(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);
        $collection->update($request->all());
        return Response($collection, 200);
    }

    /**
 * @OA\Delete(
 *     path="/api/v1/{tenant}/collections/{id}",
 *     summary="Eliminar una colección",
 *     tags={"Collection"},
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         description="ID del inquilino",
 *         required=true,
 *         example="Academlo",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la colección",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Colección eliminada exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Colección eliminada exitosamente"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Colección no encontrada"
 *     ),
 *
 * )
 */

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();
        return Response('', 204);
    }


/**
 * @OA\Get(
 *     path="/api/v1/{tenant}/collections/{id}/events",
 *     summary="Obtener eventos de una colección",
 *     tags={"Collection"},
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         description="ID del inquilino",
 *         required=true,
 *         example="Academlo",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la colección",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Número de eventos por página",
 *         required=false,
 *         @OA\Schema(type="integer", format="int32", default=10)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de eventos de la colección paginados",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Lista de eventos de la colección paginados"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Colección no encontrada"
 *     ),
 *
 * )
 */
public function events(Request $request, $id): Response {
        $collection = Collection::findOrFail($id);
        $perPage = $request->query('per_page', env('DEFAULT_PER_PAGE', 10));
        $events = $collection->events()->paginate($perPage);

        return Response($events, 200);
    }

    /**
 * @OA\Post(
 *     path="/api/v1/{tenant}/collections/{id}/add-event",
 *     summary="Agregar un evento a una colección",
 *     tags={"Collection"},
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         description="ID del inquilino",
 *         required=true,
 *         example="Academlo",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la colección",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"event_id"},
 *                 @OA\Property(
 *                     property="event_id",
 *                     type="integer",
 *                     example="1"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Evento agregado exitosamente a la colección",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Evento agregado exitosamente a la colección"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Colección o evento no encontrado"
 *     ),
 *
 * )
 */

    public function addEvent(Request $request, $id) :Response {
        $collection = Collection::findOrFail($id);
        $event = Event::find($request->event_id);
        $collection->events()->save($event);

        return Response($event, 200);
    }
}
