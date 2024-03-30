<!DOCTYPE html>
<html>
<head>
    <title>Laravel 10 Image Upload Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
      
<body>
<div class="container">
       
    <div class="panel panel-primary">
  
      <div class="panel-heading">
        <h2>upload image </h2>
      </div>
 
      <div class="panel-body">
       
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        <img src="images/{{ Session::get('image') }}">
        @endif

        <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
            @csrf <!-- Add CSRF token field -->
  
            <div class="mb-3">
                <label class="form-label" for="inputImage">Image:</label>
                <input 
                type="file" 
                name="image" 
                id="inputImage"
                class="form-control">
                {{-- @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror --}}
            </div>
   
            <div class="mb-3">
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
       
        </form>
      
      </div>
    </div>
</div>
</body>
    
</html>
