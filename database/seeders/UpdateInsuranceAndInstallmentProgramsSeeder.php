<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateInsuranceAndInstallmentProgramsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $programs = DB::table('installment_programs')
            ->select('id', 'description', 'card_image', 'features')
            ->get();

        foreach ($programs as $p) {
            DB::table('installment_programs')
                ->where('id', $p->id)
                ->update([
                    'description' => $p->description ?? '',
                    'card_image'  => $p->card_image ?? '',
                    'features'    => $p->features ?: json_encode([]),
                    'updated_at'  => $now,
                ]);
        }

        if ($programs->isEmpty()) {
            $bank = DB::table('banks')->select('id')->orderBy('id')->first();
            if ($bank) {
                DB::table('installment_programs')->insert([
                    [
                        'bank_id' => $bank->id,
                        'name' => 'الخطة الاقتصادية',
                        'description' => 'خطة تقسيط مرنة مناسبة لمعظم العملاء.',
                        'interest_rate_per_year' => 12.50,
                        'applicable_to' => 1,
                        'card_image' => 'standard.png',
                        'features' => json_encode([
                            ['name' => 'Tenor', 'value' => 'حتى 60 شهر'],
                            ['name' => 'Min Down Payment', 'value' => '10%'],
                            ['name' => 'Admin Fee', 'value' => '1.5%'],
                        ]),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                ]);
            }
        }

        $insurances = DB::table('insurance')->select('id', 'company_logo', 'description')->get();

        foreach ($insurances as $ins) {
            if (empty($ins->company_logo) || empty($ins->description)) {
                DB::table('insurance')
                    ->where('id', $ins->id)
                    ->update([
                        'company_logo' => 'default.png',
                        'description'  => 'شركة تأمين معروفة في العالم وموثوقة ومتميزة في تقديم خدمات التأمين.',
                        'updated_at'   => $now,
                    ]);
            }
        }

        if ($insurances->isEmpty()) {
            DB::table('insurance')->insert([
                [
                    'insurance_company' => 'ثروة للتأمين',
                    'company_logo'      => 'insurancelogo.png',
                    'program_name'      => 'الكارت الازرق',
                    'coverage_rate'     => 95.00,
                    'annual_price'      => 12000,
                    'monthly_payment'   => 1000,
                    'applicable_to'     => 1,
                    'description'       => 'شركة تأمين معروفة في العالم وموثوقة ومتميزة في تقديم خدمات التأمين.',
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ],
            ]);
        }
    }
}
