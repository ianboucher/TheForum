<?php

use Illuminate\Database\Seeder;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Thread::class, 250)->create()->each(function ($thread) {
            $thread->replies()->saveMany(factory(App\Reply::class, 5)->make());
        });
    }
}
