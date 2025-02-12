<?php

namespace Database\Seeders;

use App\Models\AktualPlan;
use App\Models\Fase;
use App\Models\Kelompok;
use App\Models\User;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // inisialisasi default role 
        Role::create([
            'rol_id'=>'ROL23',
            'rol_name'=>'Mahasiswa',
        ]);
        Role::create([
            'rol_id'=>'ROL25',
            'rol_name'=>'Admin',
        ]);

        Kelompok::create([
            'kel_name' => 'Projek PRG5',
        ]);

        Project::create([
            'prj_id_alternative' => 'ISPK001', 
            'prj_nama' => 'Projek PRG5',
            'prj_jenis' => 'Internal',
            'prj_start_date' => '2025-01-02',
            'prj_deadline' => '2025-12-31'
        ]);

        // buat user
        User::create([
            'usr_name' => 'daffa',
            'usr_password' => Hash::make('123'),
            'kel_id'=>'1',
            'rol_id'=>'ROL23',
            'usr_status'=>'aktif',
        ]);
        User::create([
            'usr_name' => 'himawan',
            'usr_password' => Hash::make('123'),
            'rol_id'=>'ROL25',
            'usr_status'=>'aktif',
        ]);

        // buat Fase
        $faseNames = [
            'Design',
            'RPP',
            'BOM & BOT',
            'PP',
            'Machining',
            'QC',
            'Trial',
            'Repair'
        ];

        foreach ($faseNames as $faseName) {
            Fase::create([
                'nama_fase' => $faseName
            ]);
        }

        // buat AP
        AktualPlan::create([
            'prj_id' => 1,
        ]);


        // buat Task
        Task::create([
            'ap_id' => 1,
            'apf_id' => 1,
            'pic' => 1,
            'progress' => 100,
            'plan_start' => '2025-01-03',
            'plan_end' => '2025-01-20',
            'actual_start' => '2025-01-10',
            'actual_end' => '2025-01-25',
        ]);
    }
}
