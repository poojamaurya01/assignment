<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class EncryptionController extends Controller
{
    public function encryptData(Request $request)
    {
        $request->validate([
            'data' => 'required',
        ]);

        try
        {
            $user = Auth::user();
            if (!$user)
            {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $encryptedData = Crypt::encryptString($request->data);

            return response()->json([
                'success' => true,
                'message' => 'Data encrypted successfully',
                'encrypted_data' => $encryptedData,
            ], 200);
        } catch (\Exception $e) {
            logger()->error("Encryption error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error encrypting data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function decryptData(Request $request)
    {
        $request->validate([
            'encrypted_data' => 'required|string',
        ]);

        try
        {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $decryptedData = Crypt::decryptString($request->encrypted_data);

            return response()->json([
                'success' => true,
                'message' => 'Data decrypted successfully',
                'decrypted_data' => $decryptedData,
            ], 200);
        } catch (\Exception $e) {
            logger()->error("Decryption error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error decrypting data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
