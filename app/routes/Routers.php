<?php 

Router::get('/',function(){
    echo 'hello';
});
Router::get('/home', "HomeController@index");

// Users
Router::post('/users', "UserController@create");
Router::get('/users', "UserController@index");
Router::get('/users/{id}', "UserController@getUser");
Router::post('/users/update/{id}', "UserController@update");
Router::delete('/users/{id}', "UserController@delete");

// Posts
Router::post('/posts', "PostController@createPost");
Router::get('/posts', "PostController@index");
Router::get('/posts/{id}', "PostController@getPost");
Router::post('/posts/update/{id}', "PostController@update");
Router::delete('/posts/{id}', "PostController@deletePost");

// categories
Router::post('/categories', "CategoryController@createCat");
Router::get('/categories', "CategoryController@index");
Router::get('/categories/{id}', "CategoryController@getCat");
Router::delete('/categories/{id}', "CategoryController@deleteCat");

Router::get('/comments', function(){
    echo "comments page";
});
Router::get('/categories', function(){
    echo "categories page";
});

Router::any('*', function(){
    echo "404 page";
});
