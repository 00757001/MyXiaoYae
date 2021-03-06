<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                #cardPC{
                    display: none;
                }
            }
            @media (min-width: 600px) {     /* desktop */
                .card-img-top {
                    height: 50vh;
                    object-fit: cover;
                }
                #cardPhone{
                    display: none;
                }
                #cart_phone{
                    display: none;
                }
                #cart_pc{
                    width: 12%;
                }
            }
            
        </style>
        <script>
            //vue
            window.onload = function () {
                var cardData = new Vue({
                    el: '#card',
                    data: {
                        stores:'',
                        itemsPerRow: 3,
                    },
                    computed:{
                        rowCount:function(){
                            return Math.ceil(Object.keys(this.stores).length/(this.itemsPerRow));
                        },
                    },
                    methods:{
                        fetchAllData:function(){
                            axios.post('function/condb.php',{action:'fetchStore'
                            }).then(function(response){
                                cardData.stores = response.data;
                                console.log(response.data);
                                //console.log();
                            });
                        },
                        itemCountInRow:function(index){
                            return cardData.stores.slice((index-1) * this.itemsPerRow, index * this.itemsPerRow)
                        }
                    },
                    created:function(){
                        this.fetchAllData();
                    }
                });
            }
        </script>
    </head>
    <body>
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
                    <a href="index.php" class="btn btn-warning btn-lg">首頁</a>
                    <a href="store_edit.php" class="btn btn-outline-warning btn-lg">編輯店家</a>
                    <a href="food_edit.php" class="btn btn-outline-warning btn-lg">編輯食物</a>
                </div>
                <a href="order.php"><img  src="https://imgur.com/8bnWpa0.png" alt="cart" id="cart_pc"></a>
            </div>
        </nav>
        <div class="row ml-5 mr-0 my-1" style="white-space:nowrap;display:inline">
            <h1 class=" col-sm-11">
                <strong>今晚我想來點</strong>
                <a href="order.php"><img  src="https://imgur.com/8bnWpa0.png" alt="cart" id="cart_phone"></a>
            </h1>
        </div>
        <div class="card-deck mx-1 my-0 is" id ="card" >
            <div class="row pb-3" v-for="i in rowCount" id="cardPC">
                <div class="card" v-for="item in itemCountInRow(i)" style="width: 25rem;">
                    <img class="card-img-top " v-bind:src="item.URL" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title iconfont">{{item.store_name}}</h3>
                        <p class="card-text">{{item.address}}</br>{{item.business_hour}}</br>{{item.phone}}</p>
                        <a v-bind:href="'food.php?store_name=' + item.store_name" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="card" v-for="item in stores" id="cardPhone">
                <img class="card-img-top" v-bind:src="item.URL" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title iconfont">{{item.store_name}}</h3>
                    <p class="card-text">{{item.address}}</br>{{item.business_hour}}</br>{{item.phone}}</p>
                    <a v-bind:href="'food.php?store_name=' + item.store_name" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </body>
</html>