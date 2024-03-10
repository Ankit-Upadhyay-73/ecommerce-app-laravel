@extends('layouts.app')
@section('header')

      <style>

        .carousel{
          background:  #39364a;
          margin: 0%;
        }
        .carousel-item{
          text-align: center;
          max-height: 200px; /* Prevent carousel from being distorted if for some reason image doesn't load */
        }

        .form-group
        {
          margin-bottom: 0rem;
        }
        hr.solid {
            border-top: 3px solid #bbb;
          }          

        .productview
        {
            border: 1px solid #39364a 0.25;
            border-radius: 10px;
        }

        .productview:hover
        {
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

      </style>

      <script>

          $(document).ready(function(){            
            
            var totalInStock = 0;

              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              //to show cart values
              $.ajax({
                        url: "/product/cart", 
                        method:"GET",
                        success: 
                            function(result){
                              totalInStock = result;
                              $("#cartTotal").html("<span class='badge'>"+totalInStock+"</span>");
                            }
                      });

              //for filter
              $("input[type='range']").change(function(){

                $.ajax({
                        url: "/home/?price="+$("#price").val()+"&discount="+$("#discount").val()+"&rating="+$("#rating").val(), 
                        method:"GET",
                        dataType: 'html',
                        success: 
                            function(result){
                              $('#listproducts').html(jQuery(result).find('#listproducts').html());                                    
                            }
                      });
                });
              
              //to store in Cart

              (function( $ ){
                  $.fn.onAddToCart = function(p_id) {

                    $.ajax({
                            url: "/product/cart/"+p_id, 
                            method:"POST",
                            success:
                                function(result){
                                  if(result)
                                      $("#addedToCartText").html("Already In Cart");
                                  else
                                  {
                                    totalInStock = parseInt(totalInStock);
                                   totalInStock+=1;
                                   var initial = $("#cartTotal").html();
                                   $("#cartTotal").html("<span class='badge'>"+totalInStock+"</span>");
                                  }
                                }
                          });
                  }; 
                })( jQuery );
              
            
          });

      </script>

@endsection

@section('content')

          <div id="myCarousel" 
              class="carousel slide" 
              data-ride="carousel">
              <!-- Carousel indicators -->
              <ol class="carousel-indicators">
                    <li data-target="#myCarousel" 
                      data-slide-to="0" 
                      class="active">
                    </li>
                    <li data-target="#myCarousel" 
                      data-slide-to="1">
                    </li>
                    <li data-target="#myCarousel" 
                      data-slide-to="2">
                    </li>
              </ol>
          <!-- Wrapper for carousel items -->
        
          <!-- Wrapper for carousel items -->
          
          <div class="carousel-inner">

              <div class="carousel-item active">

                <div class="row  p-2">

                  <div class="col-6 col-md-6">
                    <img class="rounded-circle"  src="{{asset('storage/product/'.$offeredProducts[0]->img_name)}}" alt="working" width="300" height="200" alt=""> 
                  </div>

                  <div class="col-6 col-md-6">
                      <h2 class="text-white">
                        {{$offeredProducts[0]->Discount}}<i class="fa fa-percent" aria-hidden="true"></i>Off On {{$offeredProducts[0]->Name}}
                      </h2>
                  </div>

                </div>
              
            </div>


              @for ($i = 1; $i < sizeof($offeredProducts); $i++)
              
                  <div class="carousel-item">

                    <div class="row h-100 p-2 align-content-md-center">

                      <div class="col-6 col-md-6">
                        <img class="rounded-circle"  src="{{asset('storage/product/'.$offeredProducts[$i]->img_name)}}" alt="working" width="300" height="200" alt=""> 
                      </div>

                      <div class="col-6 col-md-6">
                          <h2 class="text-white">
                            {{$offeredProducts[$i]->Discount}}<i class="fa fa-percent" aria-hidden="true"></i>Off On {{$offeredProducts[$i]->Name}}
                          </h2>
                      </div>

                    </div>
                  
                </div>

              @endfor
              
  
          </div>
          <!-- Carousel controls -->
          <a class="carousel-control-prev" 
              href="#myCarousel"
              data-slide="prev">
              <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" 
              href="#myCarousel" 
              data-slide="next">
              <span class="carousel-control-next-icon"></span>
          </a>
        </div>

          <!-- for Seach and Filter -->
        <div id="searchnfilter"
              class="row d-flex m-3"
              style="justify-content: space-around">

              <div class="col-12 col-md-6 align-self-center">
                <form action="/home/">
                    <div class="form-group row">
                      <label for="name"
                          class="col-md-4 col-form-label text-md-right" 
                          style="font-weight: bold">
                          Search
                      </label>

                      <div class="col-md-6">
                          <input type="text" 
                              class="form-control" 
                              placeholder="Search" 
                              id="name" 
                              name="name"
                              value="{{old ('name') }}">    
                      </div>   
                    </div>
                  </form>
              </div>

              <div class="col-12 col-md-4">
                  <span class="text-bold text-center" style="font-weight: bold">Filter</span>
                  <form>
                      <div class="form-group row">
                          <label class="col" 
                            for="discount">
                            Discount
                          </label>
                          <input type="range" 
                            class="custom-range col" 
                            value="0" min="0" max="100" step="5"
                            name="discount" 
                            id="discount">
                      </div>

                      <div class="form-group row">
                        <label for="price" 
                          class="col">
                          Price
                        </label>
                        <input 
                          type="range" 
                          class="custom-range col"
                          value="200" min="200" max="10000" step="50"
                          name="price"
                          id="price">
                      </div>

                      <div class="form-group row">
                        <label class="col" for="rating">Rating:</label>
                        <input type="range"
                          value="1" min="1" max="5" step="1"
                          class="custom-range col" name="rating" id="rating">
                      </div>
                  </form>
              </div>
        </div>

<!-- end of search And Filter -->

<hr class="solid">

<!-- list of Products -->

        <div id="listproducts" class="container">
            <div class="row justify-content-start">

                @if (sizeof($products)==0) 
                  <h1 class="text-center" style="font-family: Newsreader">Products Not Found</h1>
                @endif
              @foreach ($products as $product)
                  <div class="col-12 col-md-4 productview">
                      <div class="row">
                          <div class="col-4">
                              <img class="rounded-circle"  src="{{asset('storage/product/'.$product->img_name)}}" alt="working" width="100%" height="100%" alt=""> 
                          </div>

                          <div class="col-8 p-3">
                              <div class="row d-flex" 
                                  style="justify-content: space-around">
                                  <h2 class="text-center">
                                      {{$product->Name}}
                                  </h2>
                                  <button class="btn text-white btn-sm pb-0 btn-dark" style="background: #39364a;border: 1px solid #bbb;border-radius: 60%" onclick="$(this).onAddToCart({{$product->id}});" data-toggle="modal" data-target="#myModal"> 
                                      <h4>
                                          <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                      </h4>
                                  </button>
                                  <!-- Modal -->
                                  <div class="modal" id="myModal" role="dialog">
                                      <div class="modal-dialog modal-sm">              
                                      <!-- Modal content-->
                                        <div class="modal-content bg-dark">
                                            <div class="modal-body">
                                              <h1 class="text-white" style="font-family: Newsreader" id="addedToCartText">Added to Cart</h1>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default text-white" data-dismiss="modal">Close</button>                      
                                            </div>
                                        </div>
                                      </div>
                                  </div>

                              </div>

                              <div class="row justify-content-start">
                                  <span>{{$product->ratings[0]->rating}}<i class="fa fa-star" aria-hidden="true"></i></span>
                                  <h5 
                                    class="pl-2 @if ($product->Discount<=0) d-none @endif">{{$product->Discount}}<i class="fa fa-percent" aria-hidden="true"></i>off</h5>
                                  <span class="pl-2">
                                    @if ($product->Discount > 0) 
                                        <del >{{$product->Price}} <i class="fa fa-inr" aria-hidden="true"></i> </del>
                                    @endif

                                  </span>
                                  @php
                                    $value = (($product->Price/100)*($product->Discount)) ;
                                    $priceAfterDiscount = $product->Price-$value;
                                  @endphp

                                  <h3 class="pl-2">{{$priceAfterDiscount}}<i class="fa fa-inr" aria-hidden="true"></i> </h3>
                                  <span></span>
                              </div>
                          </div>
                      </div>    
                  </div>
              @endforeach
            </div>
        </div>



        @endsection
    <!-- product view ends here -->
