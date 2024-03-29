<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Models\WppContact;
use App\Models\WppSession;
use Illuminate\Http\Request;

use App\Http\Resources\WppContact as WppContactResource;

class WppContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $wppSession = WppSession::where('user_id', $request->user()->id)->first();
        // Caso n tenha uma sessão mostrar uam tela diferente falando para criar
        return Inertia::render('WppContacts/Index', [
            'wppContacts' => WppContact::paginate(6)->transform(function ($wppContact) {
                    return WppContactResource::make($wppContact);
            }),
            'wppSession' => $wppSession
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('WppContacts/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contacts = $request->contacts;
        foreach ($contacts as $key => $value) {
            $wppContact = WppContact::updateOrCreate(
                [
                    'user_id' =>  $request->user()->id,
                    'wpp_session_id' => $request->wpp_session_id,
                    'user_phone' =>  $value['id']['user'],
                ],

                [
                    'name' =>  $value['name'],
                    'server' =>  $value['id']['server'],
                    'user_phone' =>  $value['id']['user'],
                    '_serialized' =>  $value['id']['_serialized'],
                    'user_id' =>  $request->user()->id,
                    'wpp_session_id' => $request->wpp_session_id
                ]
            );
        }
        return redirect()->back()->with('message', 'Contatos Importados com sucesso!.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WppContact  $wppContact
     * @return \Illuminate\Http\Response
     */
    public function show(WppContact $wppContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WppContact  $wppContact
     * @return \Illuminate\Http\Response
     */
    public function edit(WppContact $wppContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WppContact  $wppContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WppContact $wppContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WppContact  $wppContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(WppContact $wppContact)
    {
        //
    }

    public function saveContacts()
    {

    }
}
