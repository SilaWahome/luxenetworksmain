<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    /**
     * Store a new subscriber.
     *
     * Expected request fields:
     *   - email (required, valid email, unique in subscribers table)
     *   - interests (optional array of strings – e.g. technology, networking, gaming)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'interests' => 'sometimes|array',
            'interests.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $subscriber = Subscriber::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->email, // placeholder name – can be updated later
                    'interests' => $request->has('interests') ? json_encode($request->interests) : null,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Subscription saved.',
            ]);
        } catch (\Exception $e) {
            Log::error('Subscriber store failed', ['exception' => $e]);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to save subscription.',
            ], 500);
        }
    }
}
?>
