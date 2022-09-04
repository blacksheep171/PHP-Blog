<?php 

Router::get('/',function(){
    echo 'hello';
});
Router::get('/home', "HomeController@index");
Router::put('/home/{list}/{page}', "HomeController@get_page");

Router::get('/users/get_all', "UserController@get_all");

Router::post('/users/create', "UserController@create");

        
Router::get('/users', function(){
    echo "users page";
});
Router::put('/posts', function(){
    echo "posts page";
});
Router::delete('/blogs', function(){
    echo "blogs page";
});
Router::any('/categories', function(){
    echo "categories page";
});
Router::get('/authors/{category}/{id}', function($cat,$page){
    echo $cat."<br>";
    echo $page."<br>";
});
Router::any('*', function(){
    echo "404 page";
});