@extends('layouts.master')  
@section('content')  
<h1>Post Page</h1>
@csrf
<table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Skills</th>
                    <th>Hobby</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{$employees}} --}}
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->e_id }}</td>
                        <td>{{ $employee->firstname }}</td>
                        <td>{{ $employee->lastname }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>
                            @if ($employee->gender == 'female')
                               Female
                            @elseif($employee->gender == 'male')
                                Male
                            @else
                                Other
                            @endif
                        </td>
                        <td>{{ $employee->address }}</td>
                        <div>
                            @php
                            $id = $employee->e_id;
                            $skill =DB::select("SELECT * FROM skills_view where e_id=$id");
                            $string1 = [];
                            $str1 = "" ;
                            foreach($skill as $skillvalue)
                            {
                                $myskill = $skillvalue->language;
                                $string1[] = $myskill;
                                $str1 = implode(',', $string1);
                            }
                            @endphp
                        </div>
                        <td>{{ $str1 }}</td>
                        <div>
                        @php
                            $id1 = $employee->e_id;
                            $hob =  DB::select("SELECT * FROM hobbyview WHERE e_id =$id1");
                            $string2=[];
                            $str2 = "";
                           foreach($hob as $hobbyvalue)
                            {
                                $myhobby = $hobbyvalue->hobby;
                                $string2[] = $myhobby;
                                $str2 = implode(',', $string2);
                            }
                        @endphp
                            </div>
                            <td>{{  $str2  }}</td>
                            <td>
                            <img src="/img/employees/{{ $employee->image }}" height="150px" width="150px" alt="">
                        </td>
                        <td>
                            <a href="{{ route('employee.delete', ['eid' => $employee->e_id]) }}">
                            <button class="btn btn-danger" >Delete</button></a>
                        </td>
                        <td><a href="{{ route('employee.edit', ['eid' => $employee->e_id]) }}">
                            <button class="btn btn-success">Edit</button></a>
                        </td>
                    </tr>
                @endforeach
                            
            </tbody>
        </table>
    </div>                      
@stop