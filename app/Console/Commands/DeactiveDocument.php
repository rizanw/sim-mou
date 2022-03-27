<?php

namespace App\Console\Commands;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeactiveDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:deactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate Document that already expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Deactivate Document Job Started');

        $documents = Document::all();
        $curDate = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');

        foreach ($documents as $key => $document) {
            if ($document->end_date == '0001-01-01') continue;

            $endDate = Carbon::parse($document->end_date)->format('Y-m-d');
            if ($endDate <= $curDate && $document->status == "Active") {
                $data = Document::where('id', $document->id)->first();
                $data->status = "Expired";
                $data->save();
                $this->info('Deactivate Document: ' . $document->number);
            }
        }

        $this->info('Deactivate Document Job Done');
        return 0;
    }
}
