<?php

namespace KasperFM\Seat\MiningExport\Models;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Eveapi\Models\Sde\InvGroup;

class TaxSetting extends Model
{
    public $timestamps = true;

    protected $table = 'kasperfm_miningexport_tax_settings';

    protected $fillable = ['id', 'type_id', 'group_id', 'tax'];

    public function type()
    {
        return $this->hasOne(InvType::class, 'typeID', 'type_id')
            ->withDefault([
                'typeName' => trans('seat::web.unknown'),
            ]);
    }

    public function group()
    {
        return $this->hasOne(InvGroup::class, 'groupID', 'group_id')
            ->withDefault([
                'groupName' => trans('seat::web.unknown'),
            ]);
    }
}