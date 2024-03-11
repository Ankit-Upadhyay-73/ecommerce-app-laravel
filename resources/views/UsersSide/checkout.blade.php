@extends('layouts.app')    

@section('header')

    <script>
        var total=0;
        $(document).ready(function(){            

            $.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });        
            
            //Product Order
            $("#btnOrder").on("click",function()
            {
                var products = {!! json_encode($carts) !!};
                var includedProducts = [];
                for(var j=0;j<products.length;j++)
                {
                    includedProducts[j] = products[j]['id'];
                }
                $.ajax({
                        url: "/product/order", 
                        method:"POST",
                        data:{Product:includedProducts,totalAmount:$("#grand_total").html()},
                        success:
                            function(result){
                                window.location.href= "/product/order";
                            }
                        });
                });
            });

        //on Quantity Changed
        function onQuantityChanged(id,amount,quantity)
        {
            total=0;
            $("#"+id).html(quantity*amount);
            console.log(quantity*amount+"   "+id);
            var tbody = document.getElementById("dtble").children[1];
            for(var i = 0; i < tbody.children.length; i++){
                total+=parseInt(tbody.children[i].children[4].innerHTML);
            }
            $("#totalAmount").html(total);
            grand_total = total+50+20;
            $("#grand_total").html(grand_total);
        }

    </script>

@endsection
@section('content')

<div class="container">
        
    <h1 class="text-bold text-center mt-2" style="font-family: Newsreader">
        Order Summary
    </h1>

    <div>
        
        <table  id="dtble" class="table table-dark table-hover table-borderless table-responsive-sm">

            <thead>
                <tr>
                    <th></th>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($carts as $cart)
                    <tr>
                        <td>
                            <img src="{{asset('storage/product/'.$cart->img_name)}}"  alt="pimg" style="width: 40px;height:30px">
                        </td>
                        <td>{{$cart->Name}}</td>
                        @php
                            $discount = ($cart->Price/100)*$cart->Discount;
                            $afterDiscount = $cart->Price - $discount;
                        @endphp
                        <td>{{$afterDiscount}}</td>
                        <td>
                            <select class="w-75 form-control" onchange="onQuantityChanged({{$cart->id}},{{$afterDiscount}},this.value)">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </td>
                        <td id="{{$cart->id}}">{{$afterDiscount}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr class="solid">

        <div class="row" style="justify-content: flex-end">
            <div class="col-4 col-md-2">
                <span>Total</span>
            </div>
            <div class="col-4 col-md-2">
                <span style="font-weight: bold" id="totalAmount">
                    @php
                        $total = 0;
                        $afterDiscount = 0;
                        foreach ($carts as $cart) {
                            $amt = ($cart->Price/100)*($cart->Discount);
                            $afterDiscount += $cart->Price - $amt;
                        }
                    @endphp
                    {{$afterDiscount}}
                </span>
            </div>
        </div>

        <div class="row" style="justify-content: flex-end">
            <div class="col-4 col-md-2">
                <span>    Shipping</span>
            </div>
            <div class="col-4 col-md-2">
                <span id="shippingCharge">50</span>
            </div>
        </div>

        <div class="row" style="justify-content: flex-end">
            <div class="col-4 col-md-2">
                <span>Tax</span>
            </div>
            <div class="col-4 col-md-2">
                <span id="taxCharge">20</span>
            </div>
        </div>

        <hr class="solid">

        <div class="row" style="justify-content: flex-end">
            <div class="col-4 col-md-2">
                <h4>Grad Total</h4>
            </div>
            <div class="col-4 col-md-2">
                <h4 id="grand_total" style="font-weight: bold">
                    @php
                            $total = 0;
                            $afterDiscount = 0;
                            foreach ($carts as $cart) {
                                $amt = ($cart->Price/100)*($cart->Discount);
                                $afterDiscount += $cart->Price - $amt;
                            }
                            $grand_total = $afterDiscount+50+20; 
                    @endphp
                    {{$grand_total}}

                </h4>
            </div>
        </div>

        <div class="row" style="justify-content: flex-end">
            <div class="col-4 col-md-2">
                <button class="btn btn-dark"  id="btnOrder">
                    Order Now               
                    </button>   
            </div>
        </div>
        
    </div>

</div>


@endsection
