<?php

namespace App\Http\Controllers;

use App\Models\Stagiaires;
use Illuminate\Http\Request;

class StagiaireController extends Controller
{
    public function list_all($added = false)
    {
        $allStagiaires = Stagiaires::all();
        if ($added === true) {
            $data = [$allStagiaires, $added];
            return view('home')->with('data', $data);
        } else {
            return view('home')->with('allStagiaires', $allStagiaires);
        }
    }

    public function add(Request $request)
    {
        if (strlen($request->firstName) < 2 || strlen($request->lastName) < 2 || intval($request->age) < 18) {
            $inserted = false;
            return view('home', compact('inserted'));
        } else {
            $inserted = Stagiaires::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'age' => $request->age,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);

            $id = $inserted->id;

            if ($id) {
                return redirect()->route('home', ['added' => 'y']);
            } else {
                return redirect()->route('home', ['added' => 'n']);
            }
        }
    }

    public function deleteAll()
    {
        Stagiaires::truncate();

        return redirect()->route('home', ['deletedAll' => 'y']);
    }

    public function search(Request $request)
    {
        $allStagiaires = Stagiaires::all()->toArray();

        $result = array_filter($allStagiaires, function ($val) use ($request) {
            $searchVal = $request->toArray()['search'];
            if (str_contains(strtolower($val['firstName']), strtolower($searchVal)) || str_contains(strtolower($val['lastName']), strtolower($searchVal))) {
                return true;
            } else {
                return false;
            }
        });

        if (count($result) > 0) {
            return view('home')->with('result', $result);
        } else {
            return view('home')->with('result', 'NotFound');
        }
    }

    public function edit(Request $request)
    {
        $data = $request->toArray();

        // dd($request->firstName);
        $stagiaire = Stagiaires::find($data['id']);
        // dd($stagiaire);
        $stagiaire->firstName = $data['firstName'];
        $stagiaire->lastName = $data['lastName'];
        $stagiaire->age = $data['age'];

        $stagiaire->save();

        $edited = 'y';
        return redirect()->route('home', compact('edited'));
    }

    public function delete($id)
    {
        $stagiaire = Stagiaires::find($id);
        if ($stagiaire) {
            $stagiaire->delete();
            return redirect()->route('home', ['deleted' => 'y']);
        } else {
            return redirect()->route('home', ['deleted' => 'n']);
        }
    }
}
