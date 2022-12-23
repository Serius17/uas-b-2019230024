<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'id' => 'required|not_in:none',
            'nama' => 'required',
            'stok' => 'required|min:1',
            'harga' => 'required|min:0',
        ];
        $validated = $request->validate($rules);
        $type = '';
        switch ($validated["id"]) {
            case "sepatu":
                $type = 'SP';
                break;
            case "baju":
                $type = 'BJ';
                break;
            case "tas":
                $type = 'TS';
                break;
            default:
                $type = 'OO';
                break;
        }

        $latestId = DB::select("SELECT RIGHT(id,4) rightid FROM items WHERE id LIKE '$type%' ORDER BY rightid DESC");

        if (!$latestId) {
            $currentId = sprintf("%04d", 1);
        } else {
            $currentId = sprintf("%04d", $latestId[0]->rightid + 1);
        }

        $validated["id"] = $type . $currentId;

        Item::create($validated);
        $request->session()->flash('success', "Successfully added {$validated['nama']}!");
        return redirect(route('items.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view("items.edit", compact("item"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $rules = [
            'id' => 'required|not_in:none',
            'nama' => 'required',
            'stok' => 'required|min:1',
            'harga' => 'required|min:0',
        ];
        $validated = $request->validate($rules);
        $type = '';
        switch ($validated["id"]) {
            case "sepatu":
                $type = 'SP';
                break;
            case "baju":
                $type = 'BJ';
                break;
            case "tas":
                $type = 'TS';
                break;
            default:
                $type = 'OO';
                break;
        }

        $latestId = DB::select("SELECT RIGHT(id,4) rightid FROM items WHERE id LIKE '$type%' ORDER BY rightid DESC");

        if (!$latestId) {
            $currentId = sprintf("%04d", 1);
        } else {
            $currentId = sprintf("%04d", $latestId[0]->rightid + 1);
        }

        $validated["id"] = $type . $currentId;

        $item->update($validated);
        $request->session()->flash('success', "Successfully updated {$validated['nama']}!");
        return redirect(route('items.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect(route('items.index'))->with('success', "Successfully deleted {$item['nama']}!");
    }
}
