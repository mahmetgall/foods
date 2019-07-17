<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="jumbotron">


        <p class="lead">Выберите ингредиенты</p>


</div>

    <div class="body-content" style="float:left; width:30%">

        <!-- Build your select: -->
        <select id="example-getting-started" multiple="multiple">
            <?php
                foreach($ingredients as $ingredient) {
                    echo '<option value="'.$ingredient['id'].'">'.$ingredient['name'].'</option>';
                }
            ?>
        </select>



    </div>
    <div style="float:left; width:70%">
    <ul id = "foods">

    </ul>


    </div>
</div>



<!-- Initialize the plugin: -->
<script type="text/javascript">
    
    $(document).ready(function() {
        $('#example-getting-started').multiselect();
        $( "#example-getting-started" ).change(function() {
            var ingredients = $( "#example-getting-started" ).val();
            var food = $( "#foods" );

            if (ingredients.length < 3) {
                food.empty();
                food.append('<li>Выберите больше ингредиентов</li>');
                return;

            }

            if (ingredients.length > 5) {
                food.empty();
                food.append('<li>Выберите не более 5 ингредиентов</li>');
                return;

            }


            $.ajax({
                type: 'POST',
                url: '/food/list',
                data: {ingredients},
                success: function (response) {
                    console.log(response);

                    food.empty();

                    if (!response) {
                        food.append('<li>Ничего не найдено</li>');
                    } else {

                        for (var i = 0; i < response.length; i++) {
                            food.append('<li>' + response[i]['name'] + '</li>');

                        }
                    }

                },

                error: function () {
                    food.empty();
                    food.append('<li>Ничего не найдено</li>');

                }

            });

        });


    });
</script>
