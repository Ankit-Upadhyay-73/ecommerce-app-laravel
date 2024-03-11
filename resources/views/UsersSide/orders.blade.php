@extends('layouts.app')
@section('header')

    <script>
            $(document).ready(function() {
            
                $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                //star rating
                var $star_rating = $('.star-rating .fa');
                var SetRatingStar = function() {
                return $star_rating.each(function() 
                    {
                        if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                            return $(this).removeClass('fa-star-o').addClass('fa-star');
                        } 
                        else {
                            return $(this).removeClass('fa-star').addClass('fa-star-o');
                        }
                });
                };

                $star_rating.on('click', function() {
                    $star_rating.siblings('input.rating-value').val($(this).data('rating'));
                    //ajax request to store ratings
                    $.ajax({
                                        url: "/product/rating", 
                                        method:"POST",
                                        data:{
                                                rating:parseInt($star_rating.siblings('input.rating-value').val()),
                                            },
                                        success: 
                                            function(result){
                                                console.log(result);
                                            }
                                    });

                    return SetRatingStar();

                });

                SetRatingStar();

            });        
    </script>

    <style>

        .star-rating {
        line-height:32px;
        font-size:1.25em;
        }

        .star-rating .fa-star{color: yellow;}

    </style>

@endsection

@section('content')

    <div class="container">

        <div class="row text-center">
            <h1 class="mt-4">
                Ordered Products
            </h1>
        </div>

        <div>
            <table class="table table-dark">
                <thead>
                  <tr>
                    <th>Order id</th>
                    <th>Product Id</th>
                    <th>Amount</th>

                  </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)

                        <tr>
                            <td>
                                {{$order->id}}
                            </td>
                            <td>
                                {{$order->Product}}
                            </td>

                            <td>
                                {{$order->totalAmount}}
                            </td>
                            
                            <td>
                                <div class="star-rating" id="{{$order->id}}">
                                    <span class="fa fa-star-o" data-rating="1"></span>
                                    <span class="fa fa-star-o" data-rating="2"></span>
                                    <span class="fa fa-star-o" data-rating="3"></span>
                                    <span class="fa fa-star-o" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                    <input type="hidden" name="whatever1" class="rating-value" value="1">
                                  </div>                                                    
                            </td>

                        </tr>

                    @endforeach
                </tbody>
              </table>
            
        </div>

    </div>

@endsection