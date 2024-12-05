@extends('admin_layout')
@section('admin_content')
<h3>Xin chào 
    <span class="username">
        <?php
            $name = Session::get('admin_name');
            if($name){
                echo $name;
                
            }
        ?>
    </span> .
</h3>
@endsection