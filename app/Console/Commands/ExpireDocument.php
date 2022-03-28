<?php

namespace App\Console\Commands;

use App\Mail\ExpireDocumentMail;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ExpireDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and set document expiricy';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Deactivate Expire Document Job Started');

        $documents = Document::all();
        $curDate = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        $exp = array();

        foreach ($documents as $key => $document) {
            if ($document->end_date == '0001-01-01') continue;

            $endDate = Carbon::parse($document->end_date)->format('Y-m-d');
            if ($endDate <= $curDate && $document->status == "Active") {
                $data = Document::where('id', $document->id)->first();
                $data->status = "Expired";
                $data->save();
                
                $this->info('Deactivate Expire Document: ' . $document->number);
                array_push($exp, $document);
            }
        }

        if (count($exp) > 0) {
            $users = User::select('email')->get();
            Mail::to($users)->send(new ExpireDocumentMail($data));
        }

        $this->info('Deactivate Expire Document Job Done');
        return 0;
    }
}
