<?php

namespace Database\Seeders;

use App\Events\UpdatedMahasiswaPreference;
use App\Helpers\DecisionMaking\ROC;
use App\Models\BidangIndustri;
use App\Models\KriteriaBidangIndustri;
use App\Models\KriteriaJenisMagang;
use App\Models\KriteriaLokasiMagang;
use App\Models\KriteriaOpenRemote;
use App\Models\KriteriaPekerjaan;
use App\Models\LokasiMagang;
use App\Models\Mahasiswa;
use App\Models\Pekerjaan;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Faker\Generator;

class KriteriaPreferensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();
        $faker->seed(123);

        $mahasiswaIDs = Mahasiswa::orderBy('id')->pluck('id')->toArray();
        $bidangIndustriIDs = BidangIndustri::orderBy('id')->pluck('id')->toArray();
        $lokasiMagangIDs = LokasiMagang::orderBy('id')->pluck('id')->toArray();
        $pekerjaanIDs = Pekerjaan::orderBy('id')->pluck('id')->toArray();


        $preferences = array_map(function ($mahasiswaID) use ($faker, $bidangIndustriIDs, $lokasiMagangIDs, $pekerjaanIDs) {
            $ranks = $faker->shuffleArray([1, 2, 3, 4, 5]);

            return [
                'mahasiswa_id' => $mahasiswaID,
                'bidang_industri' => [
                    'bidang_industri_id' => $faker->randomElement($bidangIndustriIDs),
                    'rank' => $ranks[0],
                ],
                'jenis_magang' => [
                    'jenis_magang' => $faker->randomElement(['berbayar', 'tidak berbayar']),
                    'rank' => $ranks[1]
                ],
                'lokasi_magang' => [
                    'lokasi_magang_id' => $faker->randomElement($lokasiMagangIDs),
                    'rank' => $ranks[2]
                ],
                'open_remote' => [
                    'open_remote' => $faker->randomElement(['ya', 'tidak']),
                    'rank' => $ranks[3]
                ],
                'pekerjaan' => [
                    'pekerjaan_id' => $faker->randomElement($pekerjaanIDs),
                    'rank' => $ranks[4]
                ]
            ];
        }, $mahasiswaIDs);

        foreach ($preferences as $item) {
            KriteriaBidangIndustri::create([
                'bidang_industri_id' => $item['bidang_industri']['bidang_industri_id'],
                'mahasiswa_id' => $item['mahasiswa_id'],
                'rank' => $item['bidang_industri']['rank'],
                'bobot' => ROC::getWeight($item['bidang_industri']['rank'], config('recommendation-system.roc.total_criteria'))
            ]);

            KriteriaJenisMagang::create([
                'mahasiswa_id' => $item['mahasiswa_id'],
                'jenis_magang' => $item['jenis_magang']['jenis_magang'],
                'rank' => $item['jenis_magang']['rank'],
                'bobot' => ROC::getWeight($item['jenis_magang']['rank'], config('recommendation-system.roc.total_criteria'))
            ]);

            KriteriaLokasiMagang::create([
                'mahasiswa_id' => $item['mahasiswa_id'],
                'lokasi_magang_id' => $item['lokasi_magang']['lokasi_magang_id'],
                'rank' => $item['lokasi_magang']['rank'],
                'bobot' => ROC::getWeight($item['lokasi_magang']['rank'], config('recommendation-system.roc.total_criteria'))
            ]);

            KriteriaOpenRemote::create([
                'mahasiswa_id' => $item['mahasiswa_id'],
                'open_remote' => $item['open_remote']['open_remote'],
                'rank' => $item['open_remote']['rank'],
                'bobot' => ROC::getWeight($item['open_remote']['rank'], config('recommendation-system.roc.total_criteria'))
            ]);

            KriteriaPekerjaan::create([
                'mahasiswa_id' => $item['mahasiswa_id'],
                'pekerjaan_id' => $item['pekerjaan']['pekerjaan_id'],
                'rank' => $item['pekerjaan']['rank'],
                'bobot' => ROC::getWeight($item['pekerjaan']['rank'], config('recommendation-system.roc.total_criteria'))
            ]);

            $mahasiswa = Mahasiswa::find($item['mahasiswa_id']);
            event(new UpdatedMahasiswaPreference($mahasiswa));
        }
    }
}
