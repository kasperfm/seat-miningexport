<?php

namespace KasperFM\Seat\MiningExport\Http\Controllers;

use Seat\Eveapi\Models\Industry\CharacterMining;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class ExportController
 *
 * @package KasperFM\Seat\MiningExport
 */
class ExportController extends Controller
{
    public function index()
    {
        return view('miningexport::index');
    }

    public function generateOutput(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $filename = 'corp-mining-ledger';
        $entries = CharacterMining::select('date', 'type_id', 'quantity', 'character_id')
            ->whereBetween('date', [$fromDate, $toDate])
            ->orderBy('time', 'asc')
            ->get()
            ->groupBy('type_id');

        $result = [];

        foreach($entries as $entry) {
            $quantity = 0;
            $volumeValue = 0;
            $type = null;
            foreach ($entry as $mining) {
                $quantity += $mining->quantity;

                if (!$type) {
                    $type = $mining->type->typeName;
                    $volumeValue = $mining->type->volume;
                }
            }

            $volume = $quantity * $volumeValue;

            $result[$type] = [
                'type' => $type,
                'quantity' => $quantity,
                'volume' => $volume
            ];
        }

        $output = fopen("php://output",'w') or die("Can't open php://output");
        header("Content-Type:application/csv");
        header("Content-Disposition:attachment;filename=".$filename.".csv");

        fputcsv($output, array('Type', 'Quantity', 'Volume'));
        foreach($result as $item) {
            fputcsv($output, $item);
        }
        fclose($output) or die("Can't close php://output");
    }
}