<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemRequestController extends Controller {
    public function index(Request $request) {
        $payload = json_decode($request->input('payload'), true);

        $response = $payload['original_message'];

        foreach ($response['attachments'] as $key => $attachment) {
            if ($attachment['callback_id'] !== $payload['callback_id']) {
                continue;
            }
            $attachment['fallback'] = 'This item has already been chosen.';
            $attachment['fields'] = [
                [
                    'title' => $attachment['actions'][0]['text'],
                    'value' => '@' . $payload['user']['name'],
                    'short' => true
                ]
            ];

            unset($attachment['actions']);
            $response['attachments'][$key] = $attachment;
        }
        return response()->json($response);
    }
}
