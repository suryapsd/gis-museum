<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisMuseum;
use App\Models\Galeri;
use App\Models\Koleksi;
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
            'icon' => 'museum.png',
            'lat' => '-8.656317246665921',
            'long' => '115.21821764230113'
        ]);

        $galeris = [
            ['museum_id' => '1',
            'nama' => 'Gedung Karangasem',
            'desc' => 'Gedung Karangasem merupakan galeri dengan arsitektur khas Bali Timur untuk memamerkan koleksi Panca Yadnya'],
            ['museum_id' => '1',
            'nama' => 'Gedung Tabanan',
            'desc' => 'Gedung Tabanan merupakan galeri yang memamerkan koleksi prasejarah, sejarah dan seni rupa'],
            ['museum_id' => '1',
            'nama' => 'Gedung Buleleng',
            'desc' => 'Gedung Buleleng merupakan galeri dengan dengan arsitektur gaya Bali Utara untuk memamerkan koleksi kain tradisional'],
        ];
        Galeri::insert($galeris);
        // DB::table('galeris')->insert([
        //     'museum_id' => '1',
        //     'nama' => 'Gedung Karangasem',
        //     'desc' => 'Gedung Karangasem merupakan galeri dengan arsitektur khas Bali Timur untuk memamerkan koleksi Panca Yadnya'
        // ]);

        $koleksi = [
            ['galeri_id' => '1',
            'nama' => 'Patung Cili',
            'desc' => 'Dalam perlengkapan upacara Yadnya Cili berperan penting yang diharapkan dapat mendapatkan kesejahteraan lahir dan batin dariNya. Bentuk-bentuk Cili tersebut diaplikasikan dalam berbagai perlengkapan upakara misalnya sasap, penyeneng, sampian gantung, lamak dengan hiasan cili, tutup sajen, gebogan, dan salang.',
            'tahun' => '2023-06-23',
            'artist' => 'I Gede Suteja'],
            ['galeri_id' => '2',
            'nama' => 'Keris',
            'desc' => 'Keris lurus, siwa guru dipegang oleh Brahmana yang suka mempelajari sastra ataupun Sari Ratna Kumala yang biasa dipegang oleh pemimpin. Keris luk sembilan, Naga Retna yang dipegang oleh raja. Keris Luk Tujuh Belas, Jati Tingkir/Wesia Wirawata yang biasa dipegang oleh pedagang.',
            'tahun' => '2023-06-23',
            'artist' => 'I Gede Suamba'],
            ['galeri_id' => '3',
            'nama' => 'Pis Bolong',
            'desc' => 'Benda-benda yang pernah dipergunakan sebagai alat tukar pada zaman dahulu diantaranya kerang dan taring, sementara uang kepeng cina belum digunakan dan pada abad ke-14 barulah uang kepeng cina digunakan sebagai alat pembayaran yang sah hingga akhirnya pada tahun 1950-an. Dalam perkembangannya uang kepeng tersebut tak hanya digunakan sebagai alat pembayaran yang sah tetapi juga dipergunakan sebagai sarana upacara.',
            'tahun' => '2023-06-23',
            'artist' => 'I Gede Suarjaya'],
        ];
        Koleksi::insert($koleksi);

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
