@extends('layout.dashboard')
@section('dashboards')
@php
use App\Models\User;
@endphp
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="card-body">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Admin</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Classes</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('admin.classes.store') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="class" class="form-label">Class Name</label>
                                            <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                                                <option disabled selected>-- Select --</option>
                                                <option value="Montessori" {{old('class') == 'Montessori' ? 'selected' : ''}}>Montessori</option>
                                                <option value="Nursery" {{old('class') == 'Nursery' ? 'selected' : ''}}>Nursery</option>
                                                <option value="Pre-Primary 1" {{old('class') == 'Pre-Primary 1' ? 'selected' : ''}}>Pre-Primary 1</option>
                                                <option value="Pre-Primary 2" {{old('class') == 'Pre-Primary 2' ? 'selected' : ''}}>Pre-Primary 2</option>
                                                <option value="1" {{old('class') == '1' ? 'selected' : ''}}>Class 1</option>
                                                <option value="2" {{old('class') == '2' ? 'selected' : ''}}>Class 2</option>
                                                <option value="3" {{old('class') == '3' ? 'selected' : ''}}>Class 3</option>
                                                <option value="4" {{old('class') == '4' ? 'selected' : ''}}>Class 4</option>
                                                <option value="5" {{old('class') == '5' ? 'selected' : ''}}>Class 5</option>
                                                <option value="6" {{old('class') == '6' ? 'selected' : ''}}>Class 6</option>
                                                <option value="7" {{old('class') == '7' ? 'selected' : ''}}>Class 7</option>
                                                <option value="8" {{old('class') == '8' ? 'selected' : ''}}>Class 8</option>
                                                <option value="9" {{old('class') == '9' ? 'selected' : ''}}>Class 9</option>
                                                <option value="10" {{old('class') == '10' ? 'selected' : ''}}>Class 10</option>
                                            </select>
                                            @error('class') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="sections" class="form-label mb-4">Sections</label>
                                            @foreach($sections as $secID => $section)
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="checkbox" class="mb-0 form-check @error('section[]') is-invalid @enderror" name="section[]" id="section{{$secID}}" value="{{$section->section}}">
                                                <label for="section{{$secID}}" class="mb-0 form-label">{{$section->section}}</label>
                                            </div>
                                            @endforeach
                                            @error('section') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-secondary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            @if(count($classes) > 0)
                            <div class="table-responsive">
                                <table id="viewDataTable" class="table mb-0">
                                    <thead class="text-center">
                                        <th>Class</th>
                                        <th>Sections</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($classes as $class)
                                        <tr class="text-center">
                                            <td style="vertical-align: middle">
                                                @if($class->class == 'Montessori' || $class->class == 'Nursery' || $class->class == 'Pre-Primary 1' || $class->class == 'Pre-Primary 2')
                                                {{$class->class}}
                                                @else
                                                Class {{$class->class}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle">
                                                @foreach(@json_decode($class->sec_id) as $section)
                                                <p class="mb-0">{{$section}}</p>
                                                @endforeach
                                            </td>
                                            <td style="vertical-align: middle">
                                                <a data-bs-toggle="modal" data-bs-target="{{'#classEdit-'.$class->id}}" class="btn btn-outline-primary px-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('admin.classes.destroy',$class->id)}}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-danger">No Classes Found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($classes as $Editclass)
<div class="modal fade" id="{{'classEdit-'.$Editclass->id}}" tabindex="-1" aria-labelledby="classEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="classEditLabel">Edit Class</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.classes.update',$Editclass->id) }}">
                    @csrf
                    <div class="col-12">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-control @error('class') is-invalid @enderror" name="class" id="class">
                            <option disabled selected>-- Select --</option>
                            <option value="Montessori" {{old('class',$Editclass->class) == 'Montessori' ? 'selected' : ''}}>Montessori</option>
                            <option value="Nursery" {{old('class',$Editclass->class) == 'Nursery' ? 'selected' : ''}}>Nursery</option>
                            <option value="Pre-Primary 1" {{old('class',$Editclass->class) == 'Pre-Primary 1' ? 'selected' : ''}}>Pre-Primary 1</option>
                            <option value="Pre-Primary 2" {{old('class',$Editclass->class) == 'Pre-Primary 2' ? 'selected' : ''}}>Pre-Primary 2</option>
                            <option value="1" {{old('class',$Editclass->class) == '1' ? 'selected' : ''}}>Class 1</option>
                            <option value="2" {{old('class',$Editclass->class) == '2' ? 'selected' : ''}}>Class 2</option>
                            <option value="3" {{old('class',$Editclass->class) == '3' ? 'selected' : ''}}>Class 3</option>
                            <option value="4" {{old('class',$Editclass->class) == '4' ? 'selected' : ''}}>Class 4</option>
                            <option value="5" {{old('class',$Editclass->class) == '5' ? 'selected' : ''}}>Class 5</option>
                            <option value="6" {{old('class',$Editclass->class) == '6' ? 'selected' : ''}}>Class 6</option>
                            <option value="7" {{old('class',$Editclass->class) == '7' ? 'selected' : ''}}>Class 7</option>
                            <option value="8" {{old('class',$Editclass->class) == '8' ? 'selected' : ''}}>Class 8</option>
                            <option value="9" {{old('class',$Editclass->class) == '9' ? 'selected' : ''}}>Class 9</option>
                            <option value="10" {{old('class',$Editclass->class) == '10' ? 'selected' : ''}}>Class 10</option>
                        </select>
                        @error('class') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    @php
                    $selectedSections = json_decode($Editclass->sec_id, true);
                    @endphp

                    <div class="col-12">
                        <label for="sections" class="form-label mb-4">Sections</label>
                        @foreach($sections as $secID => $section)
                        @php
                        $isChecked = in_array($section->section, $selectedSections ?? []);
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" class="mb-0 form-check @error('section[]') is-invalid @enderror" {{ $isChecked ? 'checked' : '' }} name="section[]" id="section{{$secID}}" value="{{ $section->section }}">
                            <label for="section{{$secID}}" class="mb-0 form-label">{{ $section->section }}</label>
                        </div>
                        @endforeach
                        @error('section')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 d-flex gap-3 justify-content-center">
                        <button type="submit" class="col-4 btn btn-secondary">Save</button>
                        <a href="{{route('admin.classes')}}" class="col-4 btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
