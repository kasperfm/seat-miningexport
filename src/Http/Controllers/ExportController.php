<?php

namespace KasperFM\Seat\MiningExport\Http\Controllers;

use KasperFM\Seat\MiningExport\Models\TaxSetting;
use Seat\Eveapi\Models\Industry\CharacterMining;
use Seat\Eveapi\Models\Sde\InvType;
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

    public function taxSettings()
    {
        $moonOreGroupTypes = [
            1923, //r64
            1922, //r32
            1921, //r16
            1920, //r8
            1884, //r4
        ];

        $moonOres = InvType::select(['typeName', 'typeID', 'groupID', 'volume'])
            ->whereIn('groupID', $moonOreGroupTypes)
            ->orderBy('typeID')
            ->get()
            ->where('volume', '!=', '0.1') // Exclude compressed ore
            ->groupBy('groupID');

        $taxSettingValues = TaxSetting::get();

        return view('miningexport::settings', ['moonOres' => $moonOres, 'taxSettingValues' => $taxSettingValues]);
    }

    public function saveTaxSettings(Request $request)
    {
        foreach ($request->get('taxvalues') ?? [] as $setting) {
            TaxSetting::updateOrCreate(
                ['type_id' => $setting['type_id'], 'group_id' => $setting['group_id']],
                ['tax' => $setting['value']]
            );
        }

        return response()->json(['success' => true]);
    }

    public function requestToGenerate(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $this->generateOutput($fromDate, $toDate);
    }

    public function generateOutput($fromDate, $toDate)
    {
        $filename = 'corp-mining-ledger-' . $fromDate . '_' . $toDate;
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

        header("Content-Disposition:attachment;filename=".$filename.".csv");
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");

        fputcsv($output, array('Type', 'Quantity', 'Volume'));
        foreach($result as $item) {
            fputcsv($output, $item);
        }
        fclose($output) or die("Can't close php://output");
    }
}