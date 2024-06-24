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

    public function startScan(Request $request)
    {
        // Define the path to the Python script
        $scriptPath = base_path('public/assets/dist/python/main.py');

        // Run the Python script with an increased timeout value
        $process = new Process(['python', $scriptPath]);
        // $process->setTimeout(600);  // Set timeout to 10 minutes

        // Run the process
        $process->run();

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Get the output from the Python script
        $output = $process->getOutput();

        // Process the output as needed
        // You might want to parse the output and check the database results here
        $carInDatabase = strpos($output, 'found in the') !== false;

        // Get the latest image file from the scanned_plate directory
        $files = File::files(storage_path('app/public/scanned_plate'));
        $latestFile = collect($files)->sortByDesc(function ($file) {
            return $file->getMTime();
        })->first();
        $latestImagePath = $latestFile ? 'storage/scanned_plate/' . $latestFile->getFilename() : null;

        // Return a view or redirect back with the output
        return view('scan', ['output' => $output, 'carInDatabase' => $carInDatabase, 'latestImagePath' => $latestImagePath]);
    }
}
