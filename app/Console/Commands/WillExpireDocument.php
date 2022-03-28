<?php

namespace App\Console\Commands;

use App\Mail\WillExpireDocumentMail;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WillExpireDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:willExpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and notify document that will expire soon!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking Document that will expire : Started');

        $documents = Document::all();
        $curDate = Carbon::now()->timezone('Asia/Jakarta');
        $willDate = Carbon::now()->timezone('Asia/Jakarta')->addMonth(6)->format('Y-m-d');
        $data = array();

        foreach ($documents as $key => $document) {
            if ($document->end_date == '0001-01-01') continue;

            $endDate = Carbon::parse($document->end_date)->format('Y-m-d');
            if ($endDate <= $willDate && $document->status == "Active") {
                $this->info('Document that will expire : ' . $document->id . ' ' . $curDate->diff($endDate)->format('%a'));
                array_push($data, $document);
            }
        }

        if (count($data) > 0) {
            $users = User::select('email')->get();
            Mail::to($users)->send(new WillExpireDocumentMail($data));
        }

        $this->info('Checking Document that will expire : Done');
        return 0;
    }
}
