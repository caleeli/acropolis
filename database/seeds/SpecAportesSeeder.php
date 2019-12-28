<?php

use App\Aporte;
use App\Template;
use App\User;
use Illuminate\Database\Seeder;

class SpecAportesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $template = Template::first();
        $user->sendMessage(
            $template->icon,
            $template->category_id,
            $template->title,
            $template->content,
            $template->link
        );
        factory(Aporte::class, 10)->create([
            'miembro_id' => 1,
        ]);
    }
}
