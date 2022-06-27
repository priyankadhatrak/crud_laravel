<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Hobby;
use App\Models\Skills;
use App\Models\Employees_Hobby;
use App\Models\Employees_Skills;
use Illuminate\Support\Facades\File;
 
class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $url = url('/home');
        $employees = new Employees();
        $hob = Hobby::all();
        $skill = Skills::all();
        $hobarray = [];
        $skillarray = [];
        $search='';
        $data = compact('url', 'employees', 'hob', 'hobarray', 'skill','skillarray', 'search');
        return view('index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $request->validate(
            [
                'firstname' => 'required|alpha',
                'lastname'  =>  'required|alpha',
                'email' => 'required|email|unique:employees,email',
                'gender' => 'required',
                'address' => 'required',
                'image' =>'required',
                'language' => 'required|min:1',
                'hobby' => 'required|min:1',
            ],
                [
                    'language.required' => 'Please select atleast one Language.',
                    'hobby.required' => 'Please select atleast one Hobby.',
                ]
        );
        $employees = new Employees;
        $employees->firstname = $request['firstname'];
        $employees->lastname = $request['lastname'];
        $employees->email = $request['email'];
        $employees->gender = $request['gender'];
        $employees->address = $request['address'];
        
            if ($request->hasFile('image')) {
                $files=$request->file('image');
                $name=$files->getClientOriginalName();  
                $files->move('img/employees/',$name);  
                $employees->image=$name;  
            }
        $employees->save();

        $lastid = $employees->e_id;

        $skill = new Employees_Skills();
        $hob = new Employees_Hobby();
        $skill->e_id = $lastid;
        $hob->e_id = $lastid;
        $skills = $skill->fetchskills = $request['language'];
        foreach($skills as $svalue)
        {
            DB::insert("insert into employees_skills (e_id,s_id) values ('$lastid', '$svalue')");
        }
        $hobby = $hob->fetchhobby = $request['hobby'];
        foreach ($hobby as  $value) {
            DB::insert("insert into employees_hobby (e_id,h_id) values ('$lastid', '$value')");
        }        
        return redirect('employees/show');
    
}
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       
        $search = $request['search'] ?? "";
        if ($search != "") {
            $employees = Employees::where('firstname', 'LIKE', "%$search%")->orWhere('e_id', '=', "$search")->get();
        } else {
            $employees = Employees::all();
        }
        $data = compact('employees', 'search');
        return view('view')->with($data);
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($eid)
    {
        try{
        $employees = Employees::where('e_id', $eid)->first();
        $skill = Skills::all();
        $hob = Hobby::all();

        if (is_null($employees)) {
            return redirect('view');
        } 
        else {
            $url = url('/employees/update') . "/" . $eid;
            $employees_skills = Employees_Skills::where('e_id', $eid)->get();
            $skillarray = [];
            foreach($employees_skills as $value1)
            {
                $skillarray[] = $value1->s_id;
            }
            $employees_hobby = Employees_Hobby::where('e_id', $eid)->get();
            $hobarray = [];
            foreach ($employees_hobby as $value) {
                $hobarray[] = $value->h_id;
            }
            $search ='';
            $data = compact('employees', 'url', 'skill', 'employees_skills', 'skillarray', 'hob', 'employees_hobby', 'hobarray', 'search');
            return view('index')->with($data);
        } 
    }
        catch (ModelNotFoundException $exception) 
        {
            return back()->withError("Not Allowed");
        }
        catch (Exception $e) 
        {
            return back()->withError("Invalid route");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $eid)
    {
        
        $employees = Employees::find($eid);
        $employees->firstname = $request['firstname'];
        $employees->lastname = $request['lastname'];
        $employees->email = $request['email'];
        $employees->gender = $request['gender'];
        $employees->address = $request['address'];
      
        if ($request->hasFile('image')) {
            $destination = 'img/employees/' . $employees->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('img/employees/', $filename);
            $employees->image = $filename;
        }

        $employees->save();

        $skill = new Employees_Skills();
        $skillsid = $skill->s_id = $request['language'];
        $all_skills = Employees_Skills::where('e_id',$eid)->get();
        $skill_val = [];

        foreach ($all_skills as $skill_data) {
            $skill_val[] = $skill_data['s_id'];
         
        }
        foreach ($skillsid as $skillvalue) {
            if (!in_array($skillvalue, $skill_val)) {
                $insertq1 = DB::insert("INSERT INTO employees_skills (e_id,s_id) VALUES  ('$eid','$skillvalue')");
            }
        }
        foreach ($skill_val as $row2) {
            if (!in_array($row2, $skillsid)) {
                $deleteq2 = DB::delete("DELETE FROM `employees_skills` WHERE e_id='$eid' AND s_id='$row2'");
            }
        }
       
        $hobby = new Employees_Hobby();
        $hobbyid = $hobby->h_id = $request['hobby'];
        $allhobby = Employees_Hobby::where('e_id',$eid)->get();
        $hobby_val = [];

            foreach ($allhobby as $hobby_data) {
                $hobby_val[] = $hobby_data->h_id;
            }
            // insert new data
            foreach ($hobbyid as $hobbyvalue) {
                if (!in_array($hobbyvalue, $hobby_val)) {
                    $insertq = DB::insert("INSERT INTO employees_hobby (e_id,h_id) VALUES  ('$eid','$hobbyvalue')");
                }
            }
            //delete existing data
            foreach ($hobby_val as $row1) {
                if (!in_array($row1, $hobbyid)) {
                    $deleteq = DB::delete("DELETE FROM `employees_hobby` WHERE e_id='$eid' AND h_id='$row1'");
                }
            }
        return redirect('employees/show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($eid)
    {
        $employees = Employees::where('e_id',$eid)->delete();
        return redirect()->back();
    }

}
