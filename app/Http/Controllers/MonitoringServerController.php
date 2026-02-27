<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringServerController extends Controller
{
    public function index()
    {
        // Dapatkan CPU Usage
        $cpuLoad = shell_exec('powershell -command "$cpuLoad = Get-WmiObject win32_processor | Measure-Object -property LoadPercentage -Average | Select Average; $cpuLoad.Average"');
        
        // Dapatkan RAM Usage
        $availableRAM = shell_exec('powershell -command "$ram = Get-WmiObject -Class Win32_OperatingSystem | Select-Object -Property FreePhysicalMemory,TotalVisibleMemorySize; $ram.FreePhysicalMemory"');
        $totalRAM = shell_exec('powershell -command "$ram = Get-WmiObject -Class Win32_OperatingSystem | Select-Object -Property FreePhysicalMemory,TotalVisibleMemorySize; $ram.TotalVisibleMemorySize"');

        // Dapatkan Disk Usage
        $freeSpace = shell_exec('powershell -command "$disk = Get-WmiObject Win32_LogicalDisk | Where-Object {$_.DriveType -eq 3}; $disk.FreeSpace"');
        $totalSpace = shell_exec('powershell -command "$disk = Get-WmiObject Win32_LogicalDisk | Where-Object {$_.DriveType -eq 3}; $disk.Size"');

        return view('admin.server.monitor', [
            'cpuUsage' => trim($cpuLoad),
            'availableRAM' => trim($availableRAM),
            'totalRAM' => trim($totalRAM),
            'freeSpace' => trim($freeSpace),
            'totalSpace' => trim($totalSpace),
        ]);
    }

    public function cpuUsage()
    {
        $cpuLoad = shell_exec('powershell -command "$cpuLoad = Get-WmiObject win32_processor | Measure-Object -property LoadPercentage -Average | Select Average; $cpuLoad.Average"');
        return response()->json(['cpuUsage' => trim($cpuLoad)]);
    }

    public function ramUsage()
    {
        $availableRAMKB = shell_exec('powershell -command "$ram = Get-WmiObject -Class Win32_OperatingSystem | Select-Object -Property FreePhysicalMemory; $ram.FreePhysicalMemory"');
        $totalRAMKB = shell_exec('powershell -command "$ram = Get-WmiObject -Class Win32_OperatingSystem | Select-Object -Property TotalVisibleMemorySize; $ram.TotalVisibleMemorySize"');
    
        $usedRAMKB = $totalRAMKB - $availableRAMKB;
    
        // Konversi ke GB
        $usedRAMGB = number_format($usedRAMKB / 1048576, 2); // 1 GB = 1,048,576 KB
        $availableRAMGB = number_format($availableRAMKB / 1048576, 2);
    
        // Hitung persentase
        $usedPercentage = ($usedRAMKB / $totalRAMKB) * 100;
        $availablePercentage = 100 - $usedPercentage;
    
        return response()->json([
            'usedRAMGB' => $usedRAMGB, 
            'availableRAMGB' => $availableRAMGB,
            'usedPercentage' => $usedPercentage,
            'availablePercentage' => $availablePercentage
        ]);
    }

    public function networkStats()
    {
        // Misalkan kita ambil statistik dari NIC dengan nama 'Ethernet'
        $networkStats = shell_exec('powershell -command "$stats = Get-NetAdapterStatistics -Name \'Ethernet\'; $stats"');

        // Anda perlu mem-parsing output dari $networkStats untuk mendapatkan BytesReceived dan BytesSent
        // Pemrosesan berikut ini hanyalah contoh sederhana dan mungkin perlu disesuaikan

        preg_match('/BytesReceived\s+: (\d+)/', $networkStats, $matches);
        $downloadBytes = isset($matches[1]) ? $matches[1] : 0;

        preg_match('/BytesSent\s+: (\d+)/', $networkStats, $matches);
        $uploadBytes = isset($matches[1]) ? $matches[1] : 0;

        // Convert bytes ke KB, MB, dan GB
        $downloadKB = number_format($downloadBytes / 1024, 2);
        $downloadMB = number_format($downloadBytes / (1024 * 1024), 2);
        $downloadGB = number_format($downloadBytes / (1024 * 1024 * 1024), 2);

        $uploadKB = number_format($uploadBytes / 1024, 2);
        $uploadMB = number_format($uploadBytes / (1024 * 1024), 2);
        $uploadGB = number_format($uploadBytes / (1024 * 1024 * 1024), 2);

        return response()->json([
            'download' => [
                'bytes' => $downloadBytes,
                'kb' => $downloadKB,
                'mb' => $downloadMB,
                'gb' => $downloadGB,
            ],
            'upload' => [
                'bytes' => $uploadBytes,
                'kb' => $uploadKB,
                'mb' => $uploadMB,
                'gb' => $uploadGB,
            ]
        ]);
    }

    


}