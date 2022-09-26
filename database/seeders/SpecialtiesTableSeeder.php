<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialty;
use App\Models\User;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            'Neurologia',
            'Quirurgica',
            'Pediatria',
            'Cardiologia',
            'Urologia',
            'medicina Forense',
            'dermatologia',
        ];
        foreach ($specialties as $specialtyName){
            $specialty = Specialty::create([
                'name' => $specialtyName
            ]);
            $specialty->users()->saveMany(
                User::factory(4)->state(['role' => 'doctor'])->make()
            );
        }
        User::find(3)->specialties()->save($specialty);
    }
}
