<?php 

Router::get('/',function(){
    echo 'hello';
});
Router::get('/home', "HomeController@index");
Router::get('/home/{list}/{page}', "HomeController@get_page");
// Users
Router::post('/users', "UserController@create");
Router::get('/users', "UserController@index");
Router::get('/users/{id}', "UserController@getUser");
Router::post('/users/update/{id}', "UserController@updates");
Router::delete('/users/{id}', "UserController@delete");


Router::get('/posts', function(){
    echo "posts page";
});
Router::get('/comments', function(){
    echo "comments page";
});
Router::get('/categories', function(){
    echo "categories page";
});
Router::get('/authors/{category}/{id}', function($cat,$page){
    echo $cat."<br>";
    echo $page."<br>";
});
Router::any('*', function(){
    echo "404 page";
});