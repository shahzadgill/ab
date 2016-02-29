   
   <?php
   function render_cities($name,$class,$selected_id=0){
        global $db;
        //die("kkj".$selected_id);
        $result=$db->make_query("select * from cities");
        echo '<select name="'.$name.'" class="'.$class.'" id="'.$name.'" style="width:200px">';
        echo '<option value="">- All -</option>';
        while($row=$db->fetch($result)){
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        echo "</select>";
        if($selected_id>0){
            echo '<script>';
            echo 'document.getElementById("'.$name.'").value="'.$selected_id.'";';
            echo '</script>';
        }
    }

    function render_industries($name,$class,$selected_id=0){
        global $db;
        $result=$db->make_query("select * from industries");
        echo '<select name="'.$name.'" class="'.$class.'" id="'.$name.'" style="width:250px">';
        echo '<option value="">- All -</option>';
        while($row=$db->fetch($result)){
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        echo "</select>";
        if($selected_id>0){
            echo '<script>';
            echo 'document.getElementById("'.$name.'").value="'.$selected_id.'";';
            echo '</script>';
        }
    }

    
    function get_city_name($id){
        global $db;
        $result=$db->make_query("select * from cities where id=$id ");
        $row = $db->fetch($result);
        return $row['name'];
    }
    function get_industry_name($id){
        global $db;
        $result=$db->make_query("select * from industries where id=$id ");
        $row = $db->fetch($result);
        return $row['name'];
    }

    ?>