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
    public function index()
    {
        $d['title'] = 'Scan for vehicle';
        return view('scan',$d);
    }

    public function startScan(Request $request)
    {
        // Define the path to the Python script
        $scriptPath = base_path('public/assets/dist/python/main.py');

        // Run the Python script with an increased timeout value
        $process = new Process(['python', $scriptPath]);
        $process->setTimeout(12000);  // Set timeout to 10 minutes

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
        return view('scan', ['output' => $output, 'carInDatabase' => $carInDatabase, 'latestImagePath' => $latestImagePath, 'title' => 'Scan for vehicle']);
    }

}
