<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $photo = DB::table('services_pages')
            ->where(function ($q) {
                $q->where('slug', 'like', '%photovoltaïque%')
                  ->orWhere('slug', 'like', '%photovoltaique%')
                  ->orWhere('title', 'like', '%hotovoltaïque%')
                  ->orWhere('title', 'like', '%hotovoltaique%');
            })
            ->first();

        $isol = DB::table('services_pages')
            ->where(function ($q) {
                $q->where('slug', 'like', '%isolation%')
                  ->orWhere('title', 'like', '%solation thermique%');
            })
            ->first();

        if ($photo && $isol) {
            $numPhoto = $photo->service_num;
            $numIsol  = $isol->service_num;
            DB::table('services_pages')->where('id', $photo->id)->update(['service_num' => $numIsol]);
            DB::table('services_pages')->where('id', $isol->id)->update(['service_num' => $numPhoto]);
        }
    }

    public function down(): void
    {
        $this->up(); // swap is its own inverse
    }
};
