<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <title>買宵夜</title>
        <style>
            
            @media (max-width: 600px) {     /* phone */
                #cart_pc{   
                    display: none;
                }
                #cart_phone{   
                    width: 15%;
                }
            }
            @media (min-width: 600px) {     /* desktop */
                #cart_phone{
                    display: none;
                }
                #cart_pc{
                    width: 20%;
                }
            }
        </style>
        <script>
            //vue
            window.onload = function () {
                var foodData = new Vue({
                    el: '#food',
                    data: {
                        foods:'',
                        storeName:"<?php  echo $_GET['store_name']; ?>",
                        foodNumber: [],
                        name:[],
                        keyword:'',
                    },
                    methods:{
                        fetchFoodData:function(){
                            axios.post('function/condb.php',{action:'fetchFood',name:this.storeName
                            }).then(function(response){
                                foodData.foods = response.data;
                                console.log(response.data);
                            });
                        },
                        addOrder:function(foodID,index){
                            if(foodData.name[index] == '' || foodData.foodNumber[index] == null){
                                if(foodData.name[index] == ''){
                                    alert("姓名不得為空白");
                                }
                                else if(foodData.foodNumber[index] == null){
                                    alert("數量不得為空白");
                                }
                            }
                            else{
                                axios.post('function/condb.php',{action:'addOrder',
                                    cus_name:foodData.name[index],
                                    food_ID:foodID,
                                    fnumber:foodData.foodNumber[index]
                                }).then(function(response){
                                    console.log(foodID);
                                    foodData.name[index] = null;
                                    foodData.foodNumber[index] = null;
                                    alert(response.data);
                                });
                            }
                        },
                        search:function(){
                            axios.post('function/condb.php',{action:'search',
                                name:this.storeName,
                                keyword:this.keyword,
                                ui:'food',
                            }).then(function(response){
                                foodData.foods = response.data;
                            })
                        }
                    },
                    created:function(){
                        this.fetchFoodData();
                        //this.fetchStoreName();
                    }
                });
            }

        </script>
    </head>
    <body>
        <div id="food">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand " href="index.php">      
                    <h1  class="mb-0"><strong>買宵夜</strong></h1>
                    <h6><strong>&nbsp;&nbsp;&nbsp;&nbsp;MyXiaoYae</strong></h6>       
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="btn-group btn-group-toggle mx-0 col-sm-7 " data-toggle="buttons">
                        <a href="index.php" class="btn btn-outline-warning btn-lg">首頁</a>
                        <a href="store_edit.php" class="btn btn-outline-warning btn-lg">編輯店家</a>
                        <a href="food_edit.php" class="btn btn-outline-warning btn-lg">編輯食物</a>
                    </div>
                    <a href="order.php"><img src="https://imgur.com/8bnWpa0.png" alt="cart" id="cart_pc"></a>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" v-model="keyword" placeholder="搜尋食物" aria-label="Search" @keyup="search()">
                    </form>
                </div>
            </nav>
            <div class="row ml-5 mr-0 my-1" style="white-space:nowrap;display:inline">
                <h1 class=" col-sm-11">
                    <strong>{{storeName}}</strong>
                    <a href="order.php"><img src="https://imgur.com/8bnWpa0.png" alt="cart" id="cart_phone"></a>
                </h1>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <thead class="bg-warning">
                        <tr>
                            <th width="30%">食物</th>
                            <th width="10%">價錢</th>
                            <th width="25%">姓名</th>
                            <th width="20%">數量</th>
                            <th width="15%">送單</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(food,index) in foods">
                            <td>{{food.food_name}}</td>
                            <td>{{food.price}}</td>
                            <td>                           
                                <input type="text" class="form-control " placeholder="" v-model="name[index]">                               
                            </td>
                            <td>               
                                <input type="number" class="form-control" min="1" max="9" v-model="foodNumber[index]">
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-secondary" @click="addOrder(food.food_ID,index)">加入</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>