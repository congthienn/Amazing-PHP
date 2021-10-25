$(document).ready(function(){
    //Doanh thu
    var bieudo_doanhthu;
    var doanh_thu = document.getElementById("doanh_thu").getContext("2d");
    $.ajax({
        type: "GET",
        url: "API_doanhthu.php",
        success: function (response) {
            var data_response = JSON.parse(response);
            var data_time = [];
            var data_doanhthu = [];
            $(data_response).each(function(){
                data_time.push(this.time);
                data_doanhthu.push(this.doanhthu);
            });
            bieudo_doanhthu = new Chart(doanh_thu,{
                type:"line",
                data:{
                    labels:data_time,
                    datasets:[
                        {
                            label:"Doanh thu",
                            data:data_doanhthu,
                            borderColor:'#099909',
                            tension:0.1,
                            fill:true,
                            backgroundColor: 'rgba(0, 255, 0, 0.1)'
                        }
                    ]
                },
                options:{
                    plugins:{
                        legend:{
                            display:true
                        },
                        title:{
                            display:true,
                            text:"Biểu đồ thống kê doanh thu trong 6 tháng gần nhất",
                            font:{
                                size:15
                            }
                        }
                    },
                    responsive:true
                }
            });
        }
    });
    //Don hang
    var bieudo_donhang;
    var don_hang = document.getElementById("don_hang").getContext("2d");
    $.ajax({
        type: "GET",
        url: "API_donhang.php",
        success: function (response) {
            var data_response = JSON.parse(response);
            var data_time = [];
            var data_sum = [];
            $(data_response).each(function(){
                data_time.push(this.time);
                data_sum.push(this.sum);
            });
            data_sum.push(0);
            bieudo_donhang = new Chart(don_hang,{
                type:"line",
                data:{
                    labels:data_time,
                    datasets:[
                        {
                            label:"Tổng đơn hàng",
                            data:data_sum,
                            borderColor:'#007bff',
                            tension:0.1,
                            fill:true,
                            backgroundColor:'rgba(0,0,255, 0.1)'
                        }
                    ]
                },
                options:{
                    plugins:{
                        legend:{
                            display:true
                        },
                        title:{
                            display:true,
                            text:"Biểu đồ thống kê tổng đơn hàng trong 6 tháng gần nhất",
                            font:{
                                size:15
                            }
                        }
                    },
                    responsive:true
                }
            });
        }
    });
    //Tong san pham 
    function sum_product(){
        $.ajax({
            type: "GET",
            url: "API_sum_product.php",
            dataType: "json",
            success: function (response) {
                $(".sum_product").html(response);
            }
        });
    }
    sum_product();
    $(".btn_refresh_sum_product").click(function(){
        sum_product();
    });
    //Doanh thu thang hien tai
    function sum_revenue(){
        $.ajax({
            type: "GET",
            url: "API_sum_revenue.php",
            dataType: "json",
            success: function (response) {
                $(".sum_revenue").html(response);
            }
        });
    }
    sum_revenue();
    $(".btn_refresh_sum_revenue").click(function(){
        sum_revenue();
    });
    //Tong don hang thang hien tai
    function sum_order(){
        $.ajax({
            type: "GET",
            url: "API_sum_order.php",
            dataType: "json",
            success: function (response) {
                $(".sum_order").html(response);
            }
        });
    }
    sum_order();
    $(".btn_refresh_sum_order").click(function(){
        sum_order();
    });
    //Thong ke san pham ban trong 3 thang gan nhat
    var bieudo_sanpham;
    var day = new Date();
    var month = day.getMonth() + 1;
    var year = day.getFullYear();
    console.log(day);
    var san_pham = document.getElementById("san_pham").getContext("2d");
    $.ajax({
        type: "GET",
        url: "API_product.php",
        success: function (response) {
            var data_response = JSON.parse(response);
            var data_name = [];
            var data_month_1 = [];
            var data_month_2 =[];
            var data_month_3 = []
            var data_inventory = [];
            $(data_response).each(function(){
                data_name.push(this.product_name);
                data_month_1.push(this.month_1);
                data_month_2.push(this.month_2);
                data_month_3.push(this.month_3);
                data_inventory.push(this.inventory);
            });
            bieudo_sanpham = new Chart(san_pham,{
                type:"bar",
                data:{
                    labels:data_name,
                    datasets:[
                        {
                            label:month-2+'/'+year,
                            data:data_month_1,
                            backgroundColor: '#adb5bd'
                        },
                        {
                            label:month-1+'/'+year,
                            data:data_month_2,
                            backgroundColor: '#00dcff'
                        },
                        {
                            label:month+'/'+year,
                            data:data_month_3,
                            backgroundColor: '#318ff5'
                        },
                        {
                            label:'Tồn kho',
                            data:data_inventory,
                            backgroundColor: '#dc3545'
                        }
                    ]
                },
                options:{
                    plugins:{
                        legend:{
                            display:true
                        },
                        title:{
                            display:true,
                            text:"Biểu đồ thống kê số lượng bán ra của các sản phẩm trong 3 tháng gần nhất và số lượng còn trong kho",
                            font:{
                                size:15
                            }
                        }
                    },
                    responsive:true
                }
            });
            
        }
    });
    
});