<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityDetail;
use App\Models\ActivityTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::query()->delete();
        
        $basePath = database_path('seeder_csv');
        $activityDirs = File::directories($basePath);

        foreach ($activityDirs as $dir) {
            $activityFolderName = basename($dir);
            [$kode, $nama] = explode('_', $activityFolderName, 2);

            $activity = Activity::create([
                'kode' => $kode,
                'nama' => ucwords(str_replace('_', ' ', $nama))
            ]);

            $csvFiles = File::files($dir);
            foreach ($csvFiles as $file) {
                $filename = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                [$kodeDetail, $namaDetail] = explode('_', $filename, 2);

                $detail = ActivityDetail::create([
                    'activity_id' => $activity->id,
                    'kode' => $kodeDetail,
                    'nama' => ucwords(str_replace('_', ' ', $namaDetail))
                ]);

                $csv = Reader::createFromPath($file->getPathname(), 'r');
                $csv->setHeaderOffset(0);

                foreach ($csv as $row) {
                    ActivityTask::create([
                        'activity_detail_id' => $detail->id,
                        'tipe' => $row['Tipe'],
                        'urutan' => $row['Urutan'],
                        'nama' => $row['Nama'],
                    ]);
                }
            }
        }
    }
}
