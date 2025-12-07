<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'slogan' => ['en' => $this->faker->sentence, 'ar' => $this->faker->sentence],
            'address' => ['en' => $this->faker->address, 'ar' => $this->faker->address],
            'phone' => $this->faker->phoneNumber,
            'hotline' => '16694',
            'location' => $this->faker->url,
            'facebook' => $this->faker->url,
            'linkedin' => $this->faker->url,
            'youtube' => $this->faker->url,
            'instagram' => $this->faker->url,
            'hr_mail' => $this->faker->unique()->safeEmail(),
            'customer_service_mail' => $this->faker->unique()->safeEmail(),
        ];
    }
}
