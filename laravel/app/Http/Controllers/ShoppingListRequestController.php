<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShoppingListRequestController extends Controller {
    public function index(Request $request) {
        $shoppingListItems = explode(',', $request->input('text'));

        $response = [
            'text' => '@' . $request->input('user_name') . ' created a shopping list. Choose some items to bring.',
            'response_type' => 'in_channel',
            'attachments' => [
            ]
        ];

        $attachment = [
            'fallback' => 'You are unable to choose an item',
            'color' => '#3AA3E3',
            'attachment_type' => 'default',
            'actions' => []
        ];

        foreach ($shoppingListItems as $key => $shoppingListItem) {
            $shoppingListItem = trim($shoppingListItem);

            if (empty($shoppingListItem)) {
                continue;
            }

            $snake_case = str_replace([' ', '-'], '_', strtolower($shoppingListItem));

            $newAttachment = $attachment;
            $newAttachment['callback_id'] = 'item' . $key;
            $newAttachment['actions'][] = [
                'name' => $snake_case,
                'text' => $shoppingListItem,
                'type' => 'button',
                'value' => $snake_case
            ];
            $response['attachments'][] = $newAttachment;
        }

        return response()->json($response);
    }
}
