@extends('layouts.master')  
@section('content')  
<h1>Post Page</h1>  
<span class="text-danger">
            {{ "* all fields are required." }}
</span>
<div class="container mt-5 mb-5">
<form action="{{ $url }}" enctype="multipart/form-data" method="post">
@csrf
            <div class="mb-3">
                <label for="firstname" class="form-label">First name:</label><br>
                <input type="text" name="firstname" placeholder="Enter Name" value= "{{ $employees->firstname }}" class="form-control">      
                <span class="text-danger">
                    @error('firstname')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last name:</label><br>
                <input type="text" name="lastname" placeholder="Enter Last Name" value= "{{ $employees->lastname }}" class="form-control">      
                <span class="text-danger">
                    @error('lastname')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label><br>
                <input type="text" name="email" placeholder="Enter Email" value= "{{ $employees->email }}" class="form-control">      
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label><br>
                <input type="radio" name="gender" id="f" value="female" {{ $employees->gender == 'female' ? 'checked' : '' }}> Female
                <input type="radio" name="gender" id="m" value="male" {{ $employees->gender == 'male' ? 'checked' : '' }}> Male
                <input type="radio" name="gender" id="o" value="other"{{ $employees->gender == 'other' ? 'checked' : '' }}> Other
                <br><span class="text-danger">
                    @error('gender')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label><br>
                <input type="text" name="address" placeholder="Enter Address" value= "{{ $employees->address }}" class="form-control">
                <br><span class="text-danger">
                    @error('address')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="mb-3">
            <label for="skills">Programming language:</label> <br>
            {{-- foreach($employees_skills as $val) --}}
            @foreach($skill as $item1)
            <input type="checkbox" id="language" name="language[]" value="{{ $item1->s_id }}" {{ in_array($item1->s_id,$skillarray) ? 'checked' : '' }}>
                {{ $item1->language }}<br>
                {{-- @endforeach --}}
                @endforeach
            <span class="text-danger">
                @error('language')
                    {{ $message }}
                @enderror
            </span>
            </div><br>

            <div class="mb-3">
            <label for="hobby" class="form-label">Hobbies</label><br>
            <select name="hobby[]" id="" multiple>
                    {{-- @foreach ($employees_hobby as $value) --}}
                    @foreach ($hob as $item)     
                        <option value="{{ $item->h_id }}" {{ in_array($item->h_id,$hobarray) ? 'selected' : '' }}>
                            {{ $item->hobby }}</option>
                        {{-- @endforeach --}}
                    @endforeach
                </select><br>
                <span class="text-danger">
                    @error('hobby')
                        {{ $message }}
                    @enderror
                </span>
            </div><br>
            <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type= "file"  class="form-control" id="image" name="image" src="./img/employees/{{ $employees->image}}"  class="form-control">
            <span class="text-danger">
                    @error('image')
                        {{ $message }}
                    @enderror
                </span>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
@stop