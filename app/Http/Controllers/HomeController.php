<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    // Mostrar los personajes desde la API en el frontend
   public function index()
{
    $characters = Character::all();

    return view('home', compact('characters'));
}


    // Importar los personajes a la base de datos
    public function import()
    {
        $url = 'https://rickandmortyapi.com/api/character';
        $characters = [];

        while ($url && count($characters) < 100) {
            $response = Http::withoutVerifying()->get($url);
            $data = $response->json();

            foreach ($data['results'] as $item) {
                if (count($characters) >= 100) break;

                $characters[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'status' => $item['status'],
                    'species' => $item['species'],
                    'type' => $item['type'],
                    'gender' => $item['gender'],
                    'origin_name' => $item['origin']['name'],
                    'origin_url' => $item['origin']['url'],
                    'image' => $item['image'],
                ];
            }

            $url = $data['info']['next'];
        }

        foreach ($characters as $char) {
            Character::updateOrCreate(
                ['api_id' => $char['id']],
                [
                    'name' => $char['name'],
                    'status' => $char['status'],
                    'species' => $char['species'],
                    'type' => $char['type'],
                    'gender' => $char['gender'],
                    'origin_name' => $char['origin_name'],
                    'origin_url' => $char['origin_url'],
                    'image' => $char['image'],
                ]
            );
        }

        return redirect()->back()->with('success', 'Datos importados correctamente');
    }


}
