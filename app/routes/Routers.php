<?php 

Router::get('/',function(){
    echo 'hello';
});
Router::get('/home', "HomeController@index");

// Users
Router::post('/users', "UserController@create");
Router::get('/users', "UserController@index");
Router::get('/users/get_user/{id}', "UserController@getUser");
Router::post('/users/update/{id}', "UserController@updateUsers");
Router::delete('/users/delete/{id}', "UserController@delete");
Router::post('/users/change_password/{id}', "UserController@changePassword");

// Posts
Router::post('/posts', "PostController@createPost");
Router::get('/posts', "PostController@index");
Router::get('/posts/get_post/{id}', "PostController@getPost");
Router::post('/posts/update/{id}', "PostController@updatePost");
Router::delete('/posts/delete/{id}', "PostController@deletePost");

// categories
Router::post('/categories', "CategoryController@createCat");
Router::get('/categories', "CategoryController@index");
Router::get('/categories/get_category/{id}', "CategoryController@getCat");
Router::post('/categories/update/{id}', "CategoryController@updateCat");
Router::delete('/categories/delete/{id}', "CategoryController@deleteCat");

Router::get('/comments', function(){
    echo "comments page";
});

Router::any('*', function(){
    echo "404 page";
});
