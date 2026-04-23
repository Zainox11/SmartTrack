<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────
        DB::table('users')->insert([
            [
                'name'       => 'Zain Zahid',
                'email'      => 'admin@smarttrack.com',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
                'phone'      => '0300-1234567',
                'company'    => 'SmartTrack Agency',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Aisha Khan',
                'email'      => 'aisha@client.com',
                'password'   => Hash::make('password'),
                'role'       => 'client',
                'phone'      => '0311-2345678',
                'company'    => "Aisha's Boutique",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Ahmed Ali',
                'email'      => 'ahmed@client.com',
                'password'   => Hash::make('password'),
                'role'       => 'client',
                'phone'      => '0333-9876543',
                'company'    => 'Ahmed Enterprises',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ── Projects ────────────────────────────────────
        DB::table('projects')->insert([
            [
                'client_id'   => 2,
                'title'       => "Logo Design for Aisha's Boutique",
                'description' => 'Design a modern and elegant logo for the boutique brand.',
                'budget'      => 15000,
                'deadline'    => '2025-06-12',
                'status'      => 'in_progress',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'client_id'   => 2,
                'title'       => 'E-Commerce Website',
                'description' => 'Full e-commerce website with cart and payment integration.',
                'budget'      => 80000,
                'deadline'    => '2025-07-30',
                'status'      => 'in_progress',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'client_id'   => 3,
                'title'       => 'Business Management System',
                'description' => 'Custom ERP for managing inventory, sales, and staff.',
                'budget'      => 150000,
                'deadline'    => '2025-09-01',
                'status'      => 'not_started',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // ── Tasks ───────────────────────────────────────
        DB::table('tasks')->insert([
            ['project_id'=>1,'title'=>'Initial Concept Sketches',    'description'=>'Create 3 logo concepts.',           'priority'=>'high',   'status'=>'done',        'due_date'=>'2025-04-15','created_at'=>now(),'updated_at'=>now()],
            ['project_id'=>1,'title'=>'Logo Variations (3 options)', 'description'=>'Develop 3 full-color variations.',   'priority'=>'high',   'status'=>'in_progress', 'due_date'=>'2025-05-01','created_at'=>now(),'updated_at'=>now()],
            ['project_id'=>1,'title'=>'Client Feedback Round 1',     'description'=>'Present and gather feedback.',       'priority'=>'medium', 'status'=>'todo',        'due_date'=>'2025-05-10','created_at'=>now(),'updated_at'=>now()],
            ['project_id'=>1,'title'=>'Final Logo Delivery',         'description'=>'Deliver in PNG, SVG, PDF formats.',  'priority'=>'medium', 'status'=>'todo',        'due_date'=>'2025-06-12','created_at'=>now(),'updated_at'=>now()],
            ['project_id'=>2,'title'=>'Wireframe & UI Design',       'description'=>'Design all page mockups.',           'priority'=>'high',   'status'=>'done',        'due_date'=>'2025-04-20','created_at'=>now(),'updated_at'=>now()],
            ['project_id'=>2,'title'=>'Frontend Development',        'description'=>'Build pages with HTML, CSS, Bootstrap.','priority'=>'high','status'=>'in_progress', 'due_date'=>'2025-05-30','created_at'=>now(),'updated_at'=>now()],
            ['project_id'=>2,'title'=>'Backend & Database',          'description'=>'PHP backend with MySQL.',            'priority'=>'high',   'status'=>'todo',        'due_date'=>'2025-06-30','created_at'=>now(),'updated_at'=>now()],
            ['project_id'=>2,'title'=>'Payment Gateway Integration', 'description'=>'Integrate JazzCash/EasyPaisa.',      'priority'=>'medium', 'status'=>'todo',        'due_date'=>'2025-07-15','created_at'=>now(),'updated_at'=>now()],
        ]);

        // ── Requests ────────────────────────────────────
        DB::table('requests')->insert([
            ['client_id'=>2,'title'=>'Mobile App UI Design',      'description'=>'Complete UI/UX for shopping app.','budget'=>35000,'deadline'=>'2025-08-01','status'=>'pending','created_at'=>now(),'updated_at'=>now()],
            ['client_id'=>3,'title'=>'Company Portfolio Website', 'description'=>'Professional portfolio website.', 'budget'=>25000,'deadline'=>'2025-07-15','status'=>'pending','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
