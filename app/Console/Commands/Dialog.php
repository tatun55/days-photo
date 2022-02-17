<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Dialog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dialog';

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

    protected static function highlight($str): string
    {
        return '<fg=white;options=bold,underscore>' . $str . '</>';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $confirm = $this->confirm(
            implode(
                "\n",
                [
                    'S3に保存してある画像データを削除しますか？',
                    'よければ' . self::highlight('yes') . 'を入力してください。',
                    '',
                ]
            )
        );
        if (!$confirm) {
            $this->error('削除はキャンセルされました。');
        } else {
            $this->info('削除が実行されました。');
        }
    }
}