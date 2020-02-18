<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Company;

class ContactController extends Controller
{
    public function index() {
        $companies = Company::orderBy('name')->pluck('name', 'id')->prepend('[All Companies]', '');
        $contacts = Contact::latestFirst()->filter()->paginate(7); //$contacts->pluck('id')->random();

        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create() {
        $contact = new Contact();
        $companies = Company::orderBy('name')->pluck('name', 'id');
        return view('contacts.create', compact('companies', 'contact'));
    }

    public function store(Request $request) {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            //'phone' => '',
            'address' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);
        Contact::create($request->all());
        return redirect()->route('contacts.index')->with('message', "{$request['first_name']} {$request['last_name']} has been added successfully");
    }

    public function show($id) {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact')); // ['contact' => $contact ]
    }

    public function edit($id) {
        $contact = Contact::findOrFail($id);
        $companies = Company::orderBy('name')->pluck('name', 'id');

        return view('contacts.edit', compact('contact', 'companies'));
    }

    public function update($id, Request $request) {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            //'phone' => '',
            'address' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('message', "Contact #$contact->id has been updated successfully");
    }

    public function destroy($id) {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with('message', "Contact has been deleted successfully");
    }
}
