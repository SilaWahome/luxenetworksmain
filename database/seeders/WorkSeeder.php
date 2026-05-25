<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Work;

class WorkSeeder extends Seeder
{
    public function run(): void
    {
        $works = [
            [
                'title' => 'Luxenetworks Portal',
                'category' => 'Networking',
                'description' => 'Automation for revenue collection and network monitoring.',
                'link' => 'https://www.luxenetworks.co.ke',
                'icon' => 'fas fa-globe',
                'order' => 1,
            ],
            [
                'title' => 'Kijani Networks',
                'category' => 'Networking',
                'description' => 'Customized plan management and M-PESA integration.',
                'link' => 'https://kijani.luxenetworks.co.ke',
                'icon' => 'fas fa-leaf',
                'order' => 2,
            ],
            [
                'title' => 'The Tour Academy',
                'category' => 'Digital Solutions',
                'description' => 'Comprehensive training and certification system for tourism.',
                'link' => 'https://www.thetouracademy.africa',
                'icon' => 'fas fa-graduation-cap',
                'order' => 3,
            ],
            [
                'title' => 'Silverback Lounge POS',
                'category' => 'Software Development',
                'description' => 'Tailored point-of-sale and inventory for high-end lounges.',
                'link' => 'https://pos.silverbacklounge.co.ug',
                'icon' => 'fas fa-cash-register',
                'order' => 4,
            ],
        ];

        foreach ($works as $work) {
            Work::create($work);
        }
    }
}
