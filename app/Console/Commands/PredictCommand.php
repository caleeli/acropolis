<?php

namespace App\Console\Commands;

use App\AI\MemberFromText;
use App\Miembro;
use Illuminate\Console\Command;

class PredictCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'predict {text}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $m = new MemberFromText;
        $m->train();
        $id = $m->predict($this->argument('text'));
        dump(Miembro::find($id)->toArray());
    }
}
