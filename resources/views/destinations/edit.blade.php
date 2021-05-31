@extends('layouts.app')

@section('title', 'Edit Destination')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/quill/dist/quill.core.css') }}" type="text/css">
@endsection

@section('content')
    @include('layouts.headers.main')
    
    <div class="container-fluid">
        <a class="back" href="{{ Route('destinations.index') }}"><i class="fas fa-chevron-left mt-4"></i> Back</a>
        <form class="form-create" id="needs-validation" role="form" method="POST" action="{{ route('destinations.update', ['destination' => $destination->slug]) }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';" novalidate>
            @csrf
            @method('put')
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputName">Destination Name</label>
                                <input type="text" value="{{ old('inputName') ?? $destination->name }}" name="inputName" id="inputName" class="form-control rounded" placeholder="Destination Name" required>
                                <div class="invalid-feedback">*Please provide a valid destination name.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group files">
                                <label for="inputCover">Cover Photo</label>
                                <input type="file" name="file" id="inputCover" class="form-control rounded" accept="image/*">
                            </div>
                            <div class="mb-4">
                                <p>Current Cover Photo</p>
                                <img src="{{asset('/storage/destinations/'.$destination->images[0]->path)}}" alt="images" class="img-fluid" width="320px" height="100%">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputLocation">Destination Location URL</label>
                                <input type="text" value="{{ old('inputLocation') ?? $destination->coordinate }}" name="inputLocation" id="inputLocation" class="form-control rounded" placeholder="Destination Location URL" required>
                                <div class="invalid-feedback">*Please provide a valid destination location URL.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <div data-toggle="quill" data-quill-placeholder="Description" data-image-url="{{ Route('destinations.attachment.store') }}">
                                    {!! old('description') ?? $destination->description !!}
                                </div>
                                <input type="hidden" name="description" data-toggle="quill-value" required value="{{ old('description') ?? $destination->description }}">
                                <!-- <div class="invalid-feedback">*Please provide a valid description.</div> -->
                            </div>
                        </div>
                    </div>
                    <label>Gallery</label><br>
                    <div class="dropzone dropzone-multiple" data-toggle="dropzone" data-dropzone-multiple data-dropzone-url="{{ Route('destinations.gallery.store') }}">
                        <div class="fallback">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="dropzoneMultipleUpload" multiple>
                                <label class="custom-file-label" for="dropzoneMultipleUpload">Choose file</label>
                            </div>
                        </div>
                        <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <img class="avatar-img rounded" src="#" alt="..." data-dz-thumbnail>
                                        </div>
                                    </div>
                                    <div class="col ml--3">
                                        <h4 class="mb-1" data-dz-name>...</h4>
                                        <p class="small text-muted mb-0" data-dz-size>...</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item" data-dz-remove>
                                                    Remove
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <br>
                    @php
                        $i=0
                    @endphp
                    @foreach($destination->images as $images)
                        @php
                            $i++
                        @endphp
                    @endforeach
                    @if($i>1)
                        <label id="current">Current Gallery</label><br>
                    @endif
                    <script>
                        var count = {{ $i-1 }};
                    </script>
                    @for($j=1; $j<$i; $j++)
                    <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush" id="current{{$destination->images[$j]->image_id}}">
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar">
                                        <img class="avatar-img rounded" src="{{ asset('/storage/destinations/gallery/'.$destination->images[$j]->path) }}" alt="...">
                                    </div>
                                </div>
                                <div class="col ml--3">
                                    <h4 class="mb-1">{{ $destination->images[$j]->path }}</h4>
                                </div>
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" id="{{$destination->images[$j]->image_id}}" class="dropdown-item">
                                                Remove
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $('#{{$destination->images[$j]->image_id}}').on('click',function(){
                                        var accept = confirm("Are you sure to delete this picture?");
                                        if(accept){
                                            var id = "{{$destination->images[$j]->image_id}}";
                                            var val = "{{$destination->images[$j]->path}}";
                                            $.ajax({
                                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                url: "{{ route('destinations.gallery.delete') }}",
                                                type: 'POST',
                                                data: {
                                                    id: id, 
                                                    val: val, 
                                                    _token: '{{csrf_token()}}'
                                                },
                                                success: function (data){
                                                    if(data == "Success"){
                                                        $('#current{{$destination->images[$j]->image_id}}').html('');
                                                        count--;
                                                        if(count==0){
                                                            $('#current').html('');
                                                        }
                                                    }
                                                }
                                            });
                                        }
                                    });
                                </script>
                            </div>
                        </li>
                    </ul>
                    @endfor
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary float-right" type="submit" id="submit">Submit</button>
                </div>
            </div>
        </form>
        <script>
            ! function() {
                "use strict";
                window.addEventListener("load", function() {
                    var e = document.getElementById("needs-validation");
                    e.addEventListener("submit", function(t) {
                        !1 === e.checkValidity() && (t.preventDefault(), t.stopPropagation()), e.classList.add("was-validated")
                    }, !1)
                }, !1)
            }()
        </script>
        @include('layouts.footers.auth')
    </div>
    @if (session('status'))
        <script>
            window.onload = () => {
            showNotification('bottom', 'right', 'warning', '<?php echo session('status') ?>');
            };
        </script>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-notify/notification.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/dist/quill.min.js') }}"></script>
    <script src="{{ asset('argon') }}/js/quill-script.js"></script>
    <script src="{{ asset('assets/vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('argon') }}/js/dropzone-script.js"></script>
@endpush