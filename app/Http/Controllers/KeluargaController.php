<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    public function index()
    {
        return Keluarga::all();
    }

    public function getChildrenByParentId($parentId)
    {
        return Keluarga::where('orangTuaId', $parentId)->get();
    }

    public function getGrandchildrenByGrandparentId($grandparentId)
    {
        return Keluarga::select('cucu.id', 'cucu.nama')
            ->from('keluarga as orangtua')
            ->join('keluarga as anak', 'anak.orangTuaId', '=', 'orangtua.Id')
            ->join('keluarga as cucu', 'cucu.orangTuaId', '=', 'anak.Id')
            ->where('orangtua.Id', $grandparentId)
            ->get();
    }

    public function getGranddaughtersByGrandparentId($grandparentId)
    {
        return Keluarga::select('cucu.id', 'cucu.nama')
            ->from('keluarga as orangtua')
            ->join('keluarga as anak', 'anak.orangTuaId', '=', 'orangtua.Id')
            ->join('keluarga as cucu', 'cucu.orangTuaId', '=', 'anak.Id')
            ->where('orangtua.Id', $grandparentId)
            ->where('cucu.Kelamin', 'Wanita')
            ->get();
    }

    public function getAuntsByMemberId($memberId)
    {
        return Keluarga::select('bibi.id', 'bibi.nama')
            ->from('keluarga as anggota')
            ->join('keluarga as orangtua', 'anggota.orangTuaId', '=', 'orangtua.Id')
            ->join('keluarga as bibi', 'bibi.orangTuaId', '=', 'orangtua.orangTuaId')
            ->where('anggota.Id', $memberId)
            ->where('bibi.Id', '!=', 'orangtua.Id')
            ->where('bibi.Kelamin', 'Wanita')
            ->get();
    }

    public function getMaleCousinsByMemberId($memberId)
    {
        return Keluarga::select('sepupu.id', 'sepupu.nama')
            ->from('keluarga as anggota')
            ->join('keluarga as orangtua', 'anggota.orangTuaId', '=', 'orangtua.Id')
            ->join('keluarga as paman_bibi', 'paman_bibi.orangTuaId', '=', 'orangtua.orangTuaId')
            ->join('keluarga as sepupu', 'sepupu.orangTuaId', '=', 'paman_bibi.Id')
            ->where('anggota.Id', $memberId)
            ->where('paman_bibi.Id', '!=', 'orangtua.Id')
            ->where('sepupu.Kelamin', 'pria')
            ->get();
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nama' => 'required|string',
            'Kelamin' => 'required|string',
            'orangTuaId' => 'nullable|integer|exists:keluarga,Id',
        ]);

        return Keluarga::create($validated);
    }

    public function show($id)
    {
        return Keluarga::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $keluarga = Keluarga::findOrFail($id);

        $validated = $request->validate([
            'Nama' => 'string',
            'Kelamin' => 'string',
            'orangTuaId' => 'nullable|integer|exists:keluarga,Id',
        ]);

        $keluarga->update($validated);

        return $keluarga;
    }

    public function destroy($id)
    {
        Keluarga::findOrFail($id)->delete();
        return response()->noContent();
    }
}