<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisMuseum;
use Illuminate\Support\Facades\DB;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123')
        ]);

        DB::table('museums')->insert([
            'nama' => 'Museum Bali',
            'jenis_id' => '1',
            'alamat' => 'Jl. Mayor Wisnu No.1, Dangin Puri, Kec. Denpasar Tim., Kota Denpasar, Bali 80232',
            'telepon' => '0361222680',
            'desc' => 'Museum Bali adalah museum negara yang berada di Kota Denpasar, Bali. Museum bali menjadi museum penyimpanan peninggalan masa lampau manusia dan etnografi.',
            'lat' => '-8.656317246665921',
            'long' => '115.21821764230113'
        ]);

        DB::table('images')->insert([
            'museum_id' => '1',
            'path' => '1683214545_artikel_201905120502_MuseumBali.jpg'
        ]);

        $data = [
            ['jenis' => 'Museum Arkeologi'],
            ['jenis' => 'Museum Seni'],
            ['jenis' => 'Museum Otomotif'],
            ['jenis' => 'Museum Militer'],
            ['jenis' => 'Museum Biografi'],
            ['jenis' => 'Museum Sejarah'],
        ];
        JenisMuseum::insert($data);
    }
}
