<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    //
    public function upload(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);

    $imagePath = $request->file('image')->store('images', 'public');

    $image = new Image();
    $image->name_image = pathinfo($imagePath, PATHINFO_FILENAME);
    $image->extension = $request->file('image')->extension();
    $image->peso = $request->file('image')->getSize();
    $image->save();

    return response()->json(['success' => true, 'message' => 'Imagen subida exitosamente.'], Response::HTTP_OK);

}
    public function getImage()
    {
        $images = Image::get();

        return response()->json(['images'=>$images]);
    }

    public function viewImage($filename)
    {

        $path = asset('storage/images/' . $filename);
// Ruta pública a través del enlace simbólico
        return response(['hola'=>$path]);
        if (!file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);

        return response($file, 200)->header('Content-Type', 'image/jpeg');
    }
    public function deleteImage($id)
    {
        // Obtener la información de la imagen desde la base de datos
        $image = Image::find($id);

        // Verificar si la imagen existe
        if (!$image) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }

        // Eliminar la imagen desde el sistema de archivos
        Storage::delete('images/' . $image->name_image);

        // Eliminar la entrada de la base de datos
        $image->delete();

        return response()->json(['message' => 'Imagen eliminada con éxito']);
    }
}
