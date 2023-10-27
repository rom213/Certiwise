<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Email;
use App\Models\Event;
use App\Models\ViewPage;
use App\Models\Image;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\EventPostRequest;
use App\Http\Requests\ViewPagePostRequest;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class EventController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/{tenant}/events",
     *     summary="Obtener lista de eventos",
     *     tags={"Event"},
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
     *         description="Número de eventos por página",
     *         required=false,
     *         @OA\Schema(type="integer", format="int32", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de eventos",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Lista de eventos"
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
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', env('DEFAULT_PER_PAGE',10));
        $events = Event::with('certificate')->withCount('recipients')->paginate($perPage);

        return Response($events, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/{tenant}/events",
     *     summary="Crear un nuevo evento",
     *     tags={"Event"},
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
     *                 required={"title", "description"},
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="Evento de muestra"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Descripción del evento"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Evento creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Evento creado exitosamente"
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
    public function store(EventPostRequest $request)
    {
        $event = Event::create($request->all());
        return Response($event, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/{tenant}/events/{id}",
     *     summary="Obtener detalles de un evento",
     *     tags={"Event"},
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
     *         description="ID del evento",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del evento",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Detalles del evento"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evento no encontrado"
     *     ),
     *
     * )
     */
    public function show($id)
    {
        $event = Event::with('certificate')->withCount('recipients')->findOrFail($id);
        return Response($event, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/{tenant}/events/{id}",
     *     summary="Actualizar un evento existente",
     *     tags={"Event"},
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
     *         description="ID del evento",
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
     *                     example="Evento actualizado"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Descripción actualizada del evento"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evento actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Evento actualizado exitosamente"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evento no encontrado"
     *     ),
     *
     * )
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return Response($event, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/{tenant}/events/{id}",
     *     summary="Eliminar un evento",
     *     tags={"Event"},
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
     *         description="ID del evento",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Evento eliminado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Evento eliminado exitosamente"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evento no encontrado"
     *     ),
     *
     * )
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return Response('', 204);
    }

    public function images(Request $request, $id): Response {
        $event = Event::findOrFail($id);

        $perPage = $request->query('per_page', env('DEFAULT_PER_PAGE', 10));

        $images = QueryBuilder::for($event->images())
            ->allowedFilters(['type'])
            ->paginate($perPage);

            return Response($images, 200);
        }

    public function addImage(Request $request, $id) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|in:image,signature'
        ]);

        $event = Event::findOrFail($id);
        $tenant = tenancy()->tenant->id;
        $image = $request->image;

        $imageFullName = $image->getClientOriginalName(); // name with extension
        $imageName = pathinfo($imageFullName)['filename']; // name without extension (must be unique)
        $imageName = $this->sanitizeImgName($imageName);
        $imageExtension = $image->extension();

        $filePath = "public/$tenant/events/$id/images/$imageName.$imageExtension";
        $filePath = $this->uniqueImageName($filePath, $tenant, $id, $imageName, $imageExtension);

        Storage::disk('s3')->put($filePath, file_get_contents($image));
        $imageURL = "https://certiwise.s3.amazonaws.com/$filePath";

        $imageDB = new Image($request->all());
        $imageDB->file = $imageURL;
        $imageDB->save();

        $event->images()->attach($imageDB);
        return Response($imageDB, 201);
    }

    public function deleteImage($eventId, $imageId)
    {
        $event = Event::findOrFail($eventId);
        $image = Image::findOrFail($imageId);

        $event->images()->detach($image);

        return Response ('', 204);
    }

    private function uniqueImageName($filePath, $tenant, $id, $imageName, $imageExtension)
    {
        $counter = 1;

        while (Storage::disk('s3')->exists($filePath)) {
            $newImageName = $imageName . '_' . $counter;
            $filePath = "public/$tenant/events/$id/images/$newImageName.$imageExtension";
            $counter++;
        }

        return $filePath;
    }

    private function sanitizeImgName($imageName) {

        $sanitizedName = preg_replace("/[^A-Za-z0-9]/","",$imageName);

        $sanitizedName = str_replace(" ", "", $sanitizedName);
        return $sanitizedName;
    }

    public function certificate($id): Response {
        $event = Event::findOrFail($id);
        $certificate = $event->certificate()->firstOrFail();

        return Response($certificate, 200);
    }

    public function updateOrCreateCertificate(Request $request, $id) {
        $request->validate(['data' => 'required']);

        $certificate = Certificate::updateOrCreate(
            ['event_id' => $id],
            ['data' => $request->data]
        );

        $this->setEventAttributesFromCertificate($request->data, $id);
        return Response($certificate, 201);
    }

    private function setEventAttributesFromCertificate($data, $eventID) {
        $json = json_decode($data);
        $arrayData = $json->children;

        $attributes = collect();
        foreach ($arrayData as $child) {
            if ($child->attrs->type === 'variable') {
                $variables = $child->children;
                foreach ($variables as $variable) {
                    $attributes->push($variable->attrs->text);
                }
                break;
            }
        }
        $event = Event::findOrFail($eventID);
        $event->attributes = $attributes;
        $event->save();
    }

    public function recipients(Request $request, $id): Response {
        $event = Event::findOrFail($id);
        $perPage = $request->query('per_page', env('DEFAULT_PER_PAGE', 10));
        $recipients = $event->recipients()->paginate($perPage);

        return Response($recipients, 200);
    }

    public function addRecipients(Request $request, $id): Response {
        $request->validate(['recipients' => 'required|json']);
        $event = Event::findOrFail($id);

        $lastBatch = $event->recipients()->max('batch');
        $nextBatch = $lastBatch ? $lastBatch + 1 : 1;

        $recipients = json_decode($request->recipients);
        $recipientsById = collect();

        foreach ($recipients as $recipient) {
            $DBRecipient = Recipient::firstOrNew([
                'recipient_email' => $recipient->recipient_email,
                'tenant_id' => tenancy()->tenant->id
            ]);
                $DBRecipient->recipient_name = $recipient->recipient_name;
                $DBRecipient->save();
                $recipientsById[$DBRecipient->id] = ['batch' => $nextBatch, 'user_data' => json_encode($recipient)];
        }
        $event->recipients()->attach($recipientsById);

        return Response($event->recipients, 201);
    }

    public function viewPage($eventId){
        $event = Event::findOrFail($eventId);
        $viewPage = $event->viewPage()->firstOrFail();

        return Response($viewPage, 200);
    }

    public function updateOrCreateViewPage(viewPagePostRequest $request, $id) {
        $viewPage = ViewPage::updateOrCreate(
            ['event_id' => $id],
            [
                'certificate_name' => $request->certificate_name,
                'event_description' => $request->event_description,
                'criteria_for_obtaining' => $request->criteria_for_obtaining,
            ]
        );

        return Response($viewPage, 201);
    }

    public function email($id): Response {
        $event = Event::findOrFail($id);
        $email = $event->email;

        return Response($email, 200);
    }

    public function updateOrCreateEmail(Request $request, $id): Response {
        $request->validate([
            'email_header_id' => 'required',
            'email_styles_id' => 'required',
            'header_color' => 'required',
            'image_logo' => 'active_url',
            'body' => 'required',
            'button_color' => 'required',
            'button_text' => 'required',
            'footer_text' => 'required',
            'helper_text' => 'required|boolean',
        ]);
        $email = Email::updateOrCreate(
            ['event_id' => $id],
            [
                'email_header_id' => $request->email_header_id,
                'email_styles_id' => $request->email_styles_id,
                'header_color' => $request->header_color,
                'image_logo' => $request->image_logo,
                'body' => $request->body,
                'button_color' => $request->button_color,
                'button_text' => $request->button_text,
                'footer_text' => $request->footer_text,
                'helper_text' => $request->helper_text,
            ]
        );
        return Response($email, 201);
    }
}

