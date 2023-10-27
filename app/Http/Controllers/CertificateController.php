<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function show($id): Response {
        // select recipient certificate where pivot.id = $id -> esto puede ser una alternativa
        $certificatePivot = DB::table('event_recipient')
            ->select('id', 'event_id', 'recipient_id', 'user_data', 'created_at')
            ->where('id', $id)
            ->first();
        if (!$certificatePivot) {
            return Response('', 404);
        }
        $event = Event::with('viewPage')->findOrFail($certificatePivot->event_id);
        $event->user_data = $certificatePivot->user_data;
        $certificate =$event->certificate()->firstOrFail();
        $event->certificate->parsed_data = $this->parseData($certificate, $certificatePivot->recipient_id, $certificatePivot);
        return Response($event, 200);
    }

    private function parseData($certificate, $recipientId, $pivotData) {
        $recipientKeys = ['recipient_name', 'recipient_email'];
        $emisorKeys = ['emisor_name', 'emisor_email', 'emisor_webpage', 'emisor_logo'];
        $credentialKeys = [
            'credential_issue_date' => 'created_at',
            'credential_id' => 'id'
        ];

        $JSONCertificate = json_decode($certificate->data);
        $arrayData = $JSONCertificate->children;

        foreach ($arrayData as $child) {
            if ($child->attrs->type === 'variable') {
                $variables = $child->children;
                foreach ($variables as $variable) {
                    $varWithoutBrackets = substr($variable->attrs->text, 1, -1);
                    if (in_array($varWithoutBrackets, $recipientKeys)) {
                        $variable->attrs->text = $this->getDataFromRecipient($recipientId, $varWithoutBrackets);
                    } else if (array_key_exists($varWithoutBrackets, $credentialKeys)) {
                        $variable->attrs->text = $this->getDataFromCredential($pivotData, $credentialKeys[$varWithoutBrackets]);
                    }
                    else {
                        $variable->attrs->text = $this->getDataFromCustomAttributes($pivotData->user_data, $varWithoutBrackets);
                    }
                }
                break;
            }
        }
        return $JSONCertificate;
    }
    private function getDataFromRecipient($recipientId, $variable) {
        $recipient = Recipient::find($recipientId);
        return $recipient->$variable;
    }

    private function getDataFromCredential($pivot, $variable) { // from pivot table
        return $pivot->$variable;
    }
    private function getDataFromEmisor() {
        // TODO
    }

    private function getDataFromCustomAttributes($pivotUserData, $variable) {
        $JSONPivotUserData = json_decode($pivotUserData);
        return $JSONPivotUserData->$variable ?? ' ';
    }
}
