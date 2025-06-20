<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Character;

class ImportCharacters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-characters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Rick and Morty characters from API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://rickandmortyapi.com/api/character';
        $caracters = [];

        while($url && count($caracters)<100){
            $response = Http::withoutVerifying()->get($url);
            $data = $response->json();

            foreach($data['results'] as $item){
                if(count($caracters) >= 100) break;

                $caracters[] = [
                    'api_id'=> $item['id'],
                    'name'=> $item['name'],
                    'status'=> $item['status'],
                    'species'=> $item['species'],
                    'type'=> $item['type'],
                    'gender'=> $item['gender'],
                    'origin_name'=>$item['origin']['name'],
                    'origin_url'=>$item['origin']['url'],
                    'image'=> $item['image'],
                ];
            }
            $url = $data['info']['next'];
        }
        foreach($caracters as $character){
            Character::updateOrCreate(
                ['api_id' => $character['api_id']],
                $character
            );
        }
        $this->info('import completed');
    }
}
