<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Newsreader">
    <title>Document</title>

    <style>
        h1
        {
            font-family: Newreader;
        }
    </style>

</head>


<body>
    <div class="p-3 mt-2 container shadow-lg">

        <h1 class="text-bold text-center" style="font-family: Newsreader">
                Add Products
        </h1>

        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
        
            <div class="form-group row">
                <label 
                    for="name"
                    class="col-md-4 col-form-label text-md-right" 
                    style="font-weight: bold">
                    Product Name:
                </label>
        
                <div class="col-md-6">
                    <input type="text" 
                        class="form-control" 
                        placeholder="Product Name" 
                        id="name" 
                        name="name"
                        value="{{old ('name') }}">    
                    @error('name')
                        <span class="font-italic text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>   
            </div> <!-- end of name field -->
        
        
            <div class="form-group row">
                <label 
                    for="desc"
                    class="col-md-4 col-form-label text-md-right" style="font-weight: bold">
                    Product Description:
                </label>
        
                <div class="col-md-6">
                    <textarea 
                        class="form-control" 
                        id="desc" 
                        placeholder="Product Description | Something about product" 
                        name="desc" value="{{old ('desc') }}"></textarea>
        
                    @error('desc')
                        <span class="font-italic text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div> <!-- end of desc -->
        
            <div class="form-group row">
                <label 
                    for="price" 
                    class="col-md-4 col-form-label text-md-right" style="font-weight: bold">
                    Product Price:
                </label>
        
                <div class="col-md-6">
                    <input id="price" 
                        type="number" 
                        class="form-control" 
                        name="price" 
                        value="{{ old('price') }}" 
                        placeholder="Price in Rupples"
                        required>
        
                    @error('price')
                        <span class="font-italic text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div> <!-- end of price -->
        
            <div class="form-group row">
                <label 
                    for="quantity" 
                    class="col-md-4 col-form-label text-md-right" style="font-weight: bold">
                    In Quantity:
                </label>
        
                <div class="col-md-6">
                    <input id="quantity" 
                        type="number" 
                        class="form-control" 
                        name="quantity" 
                        value="{{ old('quantity') }}" 
                        placeholder="Quantity"
                        required>
        
                    @error('quantity')
                        <span class="font-italic text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div> <!-- end of quantity -->
        
            <div class="form-group row">
                <label 
                    for="discount" 
                    class="col-md-4 col-form-label text-md-right" style="font-weight: bold">
                    Discount in %
                </label>
        
                <div class="col-md-6">
                    <input id="discount" 
                        type="number" 
                        class="form-control" 
                        name="discount" 
                        value="{{ old('discount') }}" 
                        placeholder="Discount in %"
                        required>
        
                    @error('discount')
                        <span class="font-italic text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div> <!-- end of discount -->
        
            <div class="form-group row">
                <label 
                    for="image"
                    class="col-md-4 col-form-label text-md-right" style="font-weight: bold">
                    Image:
                </label>
        
                <div class="col-md-6">
                    <input type="file" name="file" class="form-control" placeholder="Product Image" required>
                </div>
            </div>
        
            <div class="form-group row justify-content-center">
                <button type="submit" class="btn btn-dark col-2">Add</button>
            </div>
        
        </form>
        
    </div>

</body>
</html>