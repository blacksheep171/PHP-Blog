<?php 

Router::get('/',function(){
    echo 'hello';
});
Router::get('/home', "HomeController@index");

// Users
Router::post('/users', "UserController@createUser");
Router::get('/users', "UserController@index");
Router::get('/users/get_user/{id}', "UserController@getUser");
Router::post('/users/update/{id}', "UserController@updateUser");
Router::delete('/users/delete/{id}', "UserController@deleteUser");
Router::post('/users/change_password/{id}', "UserController@changeUserPassword");
Router::post('/users/upload', "UserController@upload");
Router::post('/users/login', "UserController@login");

// Posts
Router::post('/posts', "PostController@createPost");
Router::get('/posts', "PostController@index");
Router::get('/posts/get_post/{id}', "PostController@getPost");
Router::post('/posts/update/{id}', "PostController@updatePost");
Router::delete('/posts/delete/{id}', "PostController@deletePost");

// Categories
Router::post('/categories', "CategoryController@createCategory");
Router::get('/categories', "CategoryController@index");
Router::get('/categories/get_category/{id}', "CategoryController@getCategory");
Router::post('/categories/update_category/{id}', "CategoryController@updateCategory");
Router::delete('/categories/delete/{id}', "CategoryController@deleteCategory");

// Comments
Router::post('/comments', "CommentController@createComment");
Router::get('/comments', "CommentController@index");
Router::get('/comments/get_comment/{id}', "CommentController@getComment");
Router::post('/comments/update_comment/{id}', "CommentController@updateComment");
Router::delete('/comments/delete/{id}', "CommentController@deleteComment");

Router::any('*', function(){
    echo "404 page";
});
