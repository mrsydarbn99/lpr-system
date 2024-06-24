<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Illuminate\Process\Exceptions\ProcessTimedOutException;
use Symfony\Component\Process\Exception\ProcessFailedException;


class VideoController extends Controller
{
    // public function showUploadForm()
    // {
    //     return view('upload');
    // }

    // public function uploadVideo(Request $request)
    // {
    //     $request->validate([
    //         'video' => 'required|mimes:mp4,avi,mov,wmv|max:204800',
    //     ]);

    //     $video = $request->file('video');
    //     $path = $video->store('videos', 'public');

    //     // Run the Python script with the uploaded video
    //     $process = new Process(['python', base_path('public\assets\dist\python\main.py'), storage_path('app\public\\' . $path)]);
    //     $process->setTimeout(600);
    //     $process->run();

    //     if (!$process->isSuccessful()) {
    //         throw new ProcessFailedException($process);
    //     }

    //     // Handle the output of the script
    //     $output = $process->getOutput();

    //     // You can pass the output to the view or handle it as needed
    //     $d['title'] = 'Resident List';
    //     $d['model'] = Resident::paginate(10);
    //     return view('residents.residentList',$d);
    // }
    protected $stopFile = 'storage/app/public/stop_scan';

    public function startScan(Request $request)
    {
        // Define the path to the Python script
        $scriptPath = base_path('public/assets/dist/python/main.py');

        // Run the Python script in the background
        $process = new Process(['python', $scriptPath]);
        $process->setTimeout(60);

        try {
            $process->mustRun();

            // Get the output from the Python script
            $output = $process->getOutput();

            // Process the output as needed
            $carInDatabase = strpos($output, 'found in the') !== false;

            // Get the latest image file from the scanned_plate directory
            $latestImagePath = null;
            if ($carInDatabase) {
                $files = File::files(storage_path('app/public/scanned_plate'));
                $latestFile = collect($files)->sortByDesc(function ($file) {
                    return $file->getMTime();
                })->first();
                $latestImagePath = $latestFile ? 'storage/scanned_plate/' . $latestFile->getFilename() : null;
            }

            // Return a view with the output and latest image path
            return view('scan', [
                'output' => $output,
                'carInDatabase' => $carInDatabase,
                'latestImagePath' => $latestImagePath,
                'timeout' => false
            ]);

        } catch (ProcessTimedOutException $e) {
            // Handle timeout
            return view('scan', [
                'output' => 'The scan process took too long and was terminated.',
                'carInDatabase' => false,
                'latestImagePath' => null,
                'timeout' => true
            ]);
        } catch (ProcessFailedException $e) {
            // Handle other process failures
            return view('scan', [
                'output' => 'The scan process failed: ' . $e->getMessage(),
                'carInDatabase' => false,
                'latestImagePath' => null,
                'timeout' => false
            ]);
        }
    }

    public function stopScan(Request $request)
    {
        // Ensure the stop file directory exists
        $stopFileDirectory = dirname(storage_path($this->stopFile));
        if (!File::exists($stopFileDirectory)) {
            File::makeDirectory($stopFileDirectory, 0755, true);
        }

        // Create a stop file to signal the running script to stop
        File::put(storage_path($this->stopFile), 'stop');

        // Return a response to indicate the scan has stopped
        return response()->json(['message' => 'Scan stopped successfully.']);
    }
}
