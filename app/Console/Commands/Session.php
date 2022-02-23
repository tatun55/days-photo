<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Session extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // session(['nameB' => 'testB']);
        // session()->forget(['aaa', 'aaa_index']);
        // session()->forget('aaa_index');
        // if (!session()->has('aaa')) {
        //     session(['aaa' => 3]);
        //     session()->push('aaa_index', 'a');
        //     session()->push('aaa_index', 'b');
        //     dump(session('aaa'));
        //     dump(session('aaa_index'));
        // }
    }
}