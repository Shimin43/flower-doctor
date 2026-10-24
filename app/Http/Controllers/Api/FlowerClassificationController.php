<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlowerImage;
use Illuminate\Http\Request;

class FlowerClassificationController extends Controller
{
    public function predict(Request $request)
    {
        $request->validate([
            'image' => [
                'required_without:image_id',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:10240',
            ],
            'image_id' => [
                'required_without:image',
                'integer',
                'exists:flower_images,id',
            ],
        ]);

        $flowerImage = null;

        if ($request->filled('image_id')) {
            $flowerImage = FlowerImage::findOrFail(
                $request->input('image_id')
            );

            $imagePath = storage_path(
                'app/public/' . $flowerImage->image_path
            );

            if (!is_file($imagePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stored flower image file not found.',
                ], 404);
            }
        } else {
            $imagePath = $request->file('image')->getRealPath();
        }

        $pythonPath = base_path('ai-env/Scripts/python.exe');
        $scriptPath = base_path('predict_flower.py');

        if (!file_exists($pythonPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Python executable not found.',
                'path' => $pythonPath,
            ], 500);
        }

        if (!file_exists($scriptPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Prediction script not found.',
                'path' => $scriptPath,
            ], 500);
        }

        $command =
            escapeshellarg($pythonPath) . ' ' .
            escapeshellarg($scriptPath) . ' ' .
            escapeshellarg($imagePath) .
            ' 2>NUL';

        try {
            $output = shell_exec($command);

            if ($output === null || trim($output) === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Python returned no output.',
                ], 500);
            }

            $prediction = json_decode(trim($output), true);

            if (
                !is_array($prediction) ||
                !($prediction['success'] ?? false)
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Flower prediction failed.',
                    'error' => $prediction['error'] ?? 'Invalid prediction response.',
                ], 500);
            }

            if ($flowerImage) {
                $scores = $prediction['scores'] ?? [];
                $predictedFlower = $prediction['predicted_flower'] ?? null;

                if (
                    !$predictedFlower ||
                    !isset($scores[$predictedFlower]) ||
                    !is_numeric($scores[$predictedFlower])
                ) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Prediction confidence is missing.',
                    ], 500);
                }

                $flowerImage->update([
                    'predicted_flower_species' => $predictedFlower,
                    'prediction_confidence' =>
                        (float) $scores[$predictedFlower],
                ]);

                $prediction['data'] = [
                    'image_id' => $flowerImage->id,
                    'predicted_flower_species' => $predictedFlower,
                    'prediction_confidence' =>
                        (float) $scores[$predictedFlower],
                ];
            }

            return response()->json($prediction);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to run flower prediction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
